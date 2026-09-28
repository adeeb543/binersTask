<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discussion\StoreProjectDiscussionRequest;
use App\Http\Resources\Api\ProjectDiscussionResource;
use App\Models\Project;
use App\Services\ProjectDiscussionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request;

class ProjectDiscussionController extends Controller
{
    protected $discussionService;

    public function __construct(ProjectDiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
    }

    // جلب مناقشات مشروع معين
    public function index(int $projectId): JsonResponse
    {
        $discussions = $this->discussionService->getProjectDiscussions($projectId);

        return response()->json([
            'status' => true,
            'message' => 'تم جلب المناقشات بنجاح',
            'data' => ProjectDiscussionResource::collection($discussions)
        ]);
    }

    // إرسال رسالة أو ملف جديد عبر الـ API
    public function store(StoreProjectDiscussionRequest $request, Project $project): JsonResponse
    {
        $file = $request->file('file');

        // استدعاء نفس السيرفيس تماماً! (Clean Architecture قوة إعادة الاستخدام)
        $discussion = $this->discussionService->storeDiscussion($project, $request->validated(), $file);

        return response()->json([
            'status' => true,
            'message' => 'تم إرسال الرسالة بنجاح',
            'data' => new ProjectDiscussionResource($discussion)
        ], 201);
    }


    public function destroy(Request $request, int $id): JsonResponse
{
    // تمرير رقم الرسالة ومعرف المستخدم الحالي مباشرة للسيرفيس
    $this->discussionService->delete($id, $request->user()->id);

    return response()->json([
        'status' => true,
        'message' => 'تم حذف الرسالة بنجاح'
    ]);
}
}
