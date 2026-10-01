<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    // عرض جميع مشاريع المستخدم الحالي (التوقيع محفوظ 100%)
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
        // 1. جلب المشروع من السيرفيس بالـ ID فقط
        $project = $this->projectService->getProjectDetails($id);

        // 2. التحقق من الصلاحية عبر البوليصي
        $this->authorize('view', $project);

        return response()->json([
            'status' => true,
            'data' => $project
        ]);
    }

    // تحديث مشروع
    public function update(UpdateProjectRequest $request, int $id): JsonResponse
    {
        // 1. جلب المشروع للتأكد من وجوده
        $project = $this->projectService->getProjectDetails($id);

        // 2. التحقق من صلاحية التعديل
        $this->authorize('update', $project);

        // 3. التنفيذ عبر السيرفيس
        $updatedProject = $this->projectService->updateProject($id, $request->validated());

        return response()->json([
            'status' => true,
            'message' => 'تم تحديث المشروع بنجاح',
            'data' => $updatedProject
        ]);
    }

    // حذف مشروع
    public function destroy(Request $request, int $id): JsonResponse
    {
        // 1. جلب المشروع للتأكد من وجوده
        $project = $this->projectService->getProjectDetails($id);

        // 2. التحقق من صلاحية الحذف
        $this->authorize('delete', $project);

        // 3. التنفيذ عبر السيرفيس
        $this->projectService->deleteProject($id);

        return response()->json([
            'status' => true,
            'message' => 'تم حذف المشروع بنجاح'
        ]);
    }
}
