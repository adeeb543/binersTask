<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discussion\StoreProjectDiscussionRequest;
use App\Http\Resources\Api\ProjectDiscussionResource;
use App\Models\ProjectDiscussion;
use App\Services\ProjectDiscussionService;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectDiscussionController extends Controller
{
    use AuthorizesRequests;

    protected ProjectDiscussionService $discussionService;
    protected ProjectService $projectService;

    public function __construct(
        ProjectDiscussionService $discussionService,
        ProjectService $projectService
    ) {
        $this->discussionService = $discussionService;
        $this->projectService = $projectService;
    }

    // عرض مناقشات المشروع
    public function index(int $projectId): JsonResponse
    {
        $project = $this->projectService->getProjectDetails($projectId);

        // التحقق عبر الـ Policy (viewAny)
        $this->authorize('viewAny', [ProjectDiscussion::class, $project]);

        $discussions = $this->discussionService->getProjectDiscussions($projectId);

        return response()->json([
            'status' => true,
            'message' => 'تم جلب المناقشات بنجاح',
            'data' => ProjectDiscussionResource::collection($discussions)
        ]);
    }

    // إرسال رسالة جديدة
    public function store(StoreProjectDiscussionRequest $request, int $projectId): JsonResponse
    {
        $project = $this->projectService->getProjectDetails($projectId);

        // التحقق عبر الـ Policy (create)
        $this->authorize('create', [ProjectDiscussion::class, $project]);

        $file = $request->file('file');
        $discussion = $this->discussionService->storeDiscussion($projectId, $request->validated(), $file);

        return response()->json([
            'status' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
            'data' => new ProjectDiscussionResource($discussion)
        ], 201);
    }

    // حذف الرسالة
    public function destroy(int $projectId, int $discussionId): JsonResponse
{
    // 1. جلب النقاش مع التحقق الأمني الكامل أنه يتبع للـ projectId الموجود بالروت
    $discussion = $this->discussionService->getDiscussionDetailsForProject($projectId, $discussionId);

    // 2. فحص الصلاحية عبر الـ Policy
    $this->authorize('delete', $discussion);

    // 3. الحذف الآمن بالمعرفين
    $this->discussionService->deleteDiscussion($projectId, $discussionId);

    return response()->json([
        'status' => true,
        'message' => 'تم حذف الرسالة بنجاح'
    ]);
}
}
