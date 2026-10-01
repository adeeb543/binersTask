<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreFileRequest;
use App\Services\ProjectFileService;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectFileController extends Controller
{
    use AuthorizesRequests;

    protected ProjectFileService $fileService;
    protected ProjectService $projectService;

    public function __construct(ProjectFileService $fileService, ProjectService $projectService)
    {
        $this->fileService = $fileService;
        $this->projectService = $projectService;
    }

    public function store(StoreFileRequest $request, int $projectId): JsonResponse
    {
        $project = $this->projectService->getProjectDetails($projectId);
        $this->authorize('update', $project);

        $file = $this->fileService->uploadFile($projectId, $request->file('file'));

        return response()->json([
            'status' => true,
            'message' => 'تم رفع الملف بنجاح وربطه بالمشروع',
            'data' => $file
        ], 201);
    }

    public function destroy(Request $request, int $projectId, int $fileId): JsonResponse
    {
        $file = $this->fileService->getFileDetailsForProject($projectId, $fileId);
        $this->authorize('delete', $file);

        $this->fileService->deleteFile($projectId, $fileId);

        return response()->json([
            'status' => true,
            'message' => 'تم حذف الملف بنجاح'
        ]);
    }
}
