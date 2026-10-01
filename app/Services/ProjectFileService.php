<?php

namespace App\Services;

use App\Repositories\ProjectFileRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectFileService
{
    protected ProjectFileRepositoryInterface $fileRepository;
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(
        ProjectFileRepositoryInterface $fileRepository,
        ProjectRepositoryInterface $projectRepository
    ) {
        $this->fileRepository = $fileRepository;
        $this->projectRepository = $projectRepository;
    }

    public function uploadFile(int $projectId, $uploadedFile): ProjectFile
    {
        $project = $this->projectRepository->findById($projectId);

        if (! $project) {
            throw new NotFoundHttpException('المشروع غير موجود.');
        }

        return DB::transaction(function () use ($projectId, $uploadedFile) {
            $filePath = $uploadedFile->store('project_files', 'public');
            $fileName = $uploadedFile->getClientOriginalName();
            $fileSize = $uploadedFile->getSize();

            return $this->fileRepository->create([
                'project_id' => $projectId,
                'file_name' => $fileName,
                'file_path' => $filePath,
                'file_size' => $fileSize,
            ]);
        });
    }

    public function getFileDetailsForProject(int $projectId, int $fileId): ProjectFile
    {
        $file = $this->fileRepository->findByProjectAndId($projectId, $fileId);

        if (! $file) {
            throw new NotFoundHttpException('الملف غير موجود ضمن هذا المشروع.');
        }

        return $file;
    }

    public function deleteFile(int $projectId, int $fileId): void
    {
        $file = $this->getFileDetailsForProject($projectId, $fileId);

        DB::transaction(function () use ($projectId, $fileId, $file) {
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            $this->fileRepository->deleteByProjectAndId($projectId, $fileId);
        });
    }
}
