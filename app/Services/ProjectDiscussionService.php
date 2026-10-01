<?php

namespace App\Services;

use App\Models\ProjectDiscussion;
use App\Repositories\ProjectDiscussionRepositoryInterface;
use App\Traits\HasFiles;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectDiscussionService
{
    use HasFiles;

    protected ProjectDiscussionRepositoryInterface $discussionRepository;

    public function __construct(ProjectDiscussionRepositoryInterface $discussionRepository)
    {
        $this->discussionRepository = $discussionRepository;
    }

    public function getProjectDiscussions(int $projectId)
    {
        return $this->discussionRepository->getByProjectId($projectId);
    }

    // جلب تفاصيل النقاش مع التحقق الإجباري من تطابق الـ projectId
    public function getDiscussionDetailsForProject(int $projectId, int $discussionId): ProjectDiscussion
    {
        $discussion = $this->discussionRepository->findByProjectAndId($projectId, $discussionId);

        if (! $discussion) {
            throw new NotFoundHttpException('الرسالة غير موجودة ضمن هذا المشروع.');
        }

        return $discussion;
    }

    public function storeDiscussion(int $projectId, array $data, $file = null, $sender = null): ProjectDiscussion
    {
        unset($data['file']);

        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('discussions_files', $fileName, 'public');

            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $filePath;
        }

        $data['project_id'] = $projectId;

        if (!$sender) {
            $sender = Auth::guard('admin')->user() ?? Auth::user();
        }

        if ($sender) {
            $data['sender_id'] = $sender->id;
            $data['sender_type'] = get_class($sender);
        }

        return $this->discussionRepository->create($data);
    }

    public function deleteDiscussion(int $projectId, int $discussionId): bool
    {
        // 1. التحقق وجلب النقاش بالمعرفين صريحين
        $discussion = $this->getDiscussionDetailsForProject($projectId, $discussionId);

        // 2. حذف الملف المرفق إن وجد
        if ($discussion->file_path) {
            $this->deleteFile($discussion->file_path);
        }

        // 3. الحذف الآمن عبر الريبو
        return $this->discussionRepository->deleteByProjectAndId($projectId, $discussionId);
    }
}
