<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    // عرض جميع مشاريع المستخدم الحالي
    public function index(Request $request): JsonResponse
    {
        $projects = $this->projectService->getUserProjects($request->user()->id);

        return response()->json([
            'status' => true,
            'data' => $projects
        ]);
    }

    // إنشاء مشروع جديد
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $project = $this->projectService->createProject($request->validated(), $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'تم إنشاء المشروع بنجاح',
            'data' => $project
        ], 201);
    }

    // عرض تفاصيل مشروع معين
    public function show(Request $request, int $id): JsonResponse
    {
        $project = $this->projectService->getProjectDetails($id, $request->user()->id);

        return response()->json([
            'status' => true,
            'data' => $project
        ]);
    }

    // تحديث مشروع
    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        $project = $this->projectService->updateProject($id, $request->validated(), $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث المشروع بنجاح',
            'data' => $project
        ]);
    }

    // حذف مشروع
    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->projectService->deleteProject($id, $request->user()->id);

        return response()->json([
            'status' => true,
            'message' => 'تم حذف المشروع بنجاح'
        ]);
    }
}
