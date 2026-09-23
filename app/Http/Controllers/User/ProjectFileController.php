<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreFileRequest;
use App\Services\ProjectFileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    protected ProjectFileService $fileService;

    public function __construct(ProjectFileService $fileService)
    {
        $this->fileService = $fileService;
    }

    // رفع ملف وربطه بالمشروع
    public function store(StoreFileRequest $request, int $projectId): JsonResponse
    {
        $file = $this->fileService->uploadFile($projectId, $request->file('file'), $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'تم رفع الملف بنجاح وربطه بالمشروع',
            'data' => $file
        ], 201);
    }

    // حذف ملف تابع للمشروع
    public function destroy(Request $request, int $projectId, int $fileId): JsonResponse
    {
        $this->fileService->deleteFile($fileId, $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'تم حذف الملف بنجاح'
        ]);
    }
}
