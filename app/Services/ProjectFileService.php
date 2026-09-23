<?php

namespace App\Services;

use App\Repositories\ProjectFileRepositoryInterface;
use App\Repositories\ProjectRepositoryInterface;
use App\Models\ProjectFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

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

    public function uploadFile(int $projectId, $uploadedFile, int $userId): ProjectFile
    {
        // 1. التحقق أن المشروع يخص المستخدم
        $project = $this->projectRepository->findByIdAndUser($projectId, $userId);

        if (! $project) {
            throw ValidationException::withMessages([
                'project' => ['المشروع غير موجود أو ليس لديك صلاحية للوصول إليه.'],
            ]);
        }

        return DB::transaction(function () use ($projectId, $uploadedFile) {
            // 2. تخزين الملف في التخزين العام
            $filePath = $uploadedFile->store('project_files', 'public');
            $fileName = $uploadedFile->getClientOriginalName();
           // $fileType = $uploadedFile->getClientOriginalExtension();
            $fileSize = $uploadedFile->getSize();

            // 3. حفظ السجل في قاعدة البيانات
            return $this->fileRepository->create([
                'project_id' => $projectId,
                'file_name' => $fileName,
                'file_path' => $filePath,
                //'file_type' => $fileType,
                'file_size' => $fileSize,
            ]);
        });
    }

    public function deleteFile(int $fileId, int $userId): void
    {
        // التحقق أن الملف يتبع لمشروع يملكه المستخدم
        $file = $this->fileRepository->findByIdAndUser($fileId, $userId);

        if (! $file) {
            throw ValidationException::withMessages([
                'file' => ['الملف غير موجود أو ليس لديك صلاحية لحذفه.'],
            ]);
        }

        DB::transaction(function () use ($file) {
            // حذف الملف الفعلي من السيرفر
            if (Storage::disk('public')->exists($file->file_path)) {
                Storage::disk('public')->delete($file->file_path);
            }

            // حذف السجل من قاعدة البيانات
            $this->fileRepository->delete($file);
        });
    }
}
