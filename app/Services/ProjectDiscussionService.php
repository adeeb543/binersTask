<?php

namespace App\Services;

use App\Repositories\ProjectDiscussionRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ProjectDiscussionService
{
    protected $discussionRepository;

    public function __construct(ProjectDiscussionRepositoryInterface $discussionRepository)
    {
        $this->discussionRepository = $discussionRepository;
    }

    public function getProjectDiscussions(int $projectId)
    {
        return $this->discussionRepository->getByProjectId($projectId);
    }

    public function storeDiscussion($project, array $data, $file = null, $sender = null)
{
    unset($data['file']);

    // معالجة رفع الملف إن وجد
    if ($file) {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('discussions_files', $fileName, 'public');

        $data['file_name'] = $file->getClientOriginalName();
        $data['file_path'] = $filePath;
    }

    $data['project_id'] = $project->id;

    // إذا لم يتم تمرير المرسل، نحاول معرفته تلقائياً من الـ Auth (سواء Admin أو User)
    if (!$sender) {
        $sender = Auth::guard('admin')->user() ?? Auth::user();
    }

    // تأكد أن المرسل موجود فعلاً لمنع الأخطاء
    if ($sender) {
        $data['sender_id'] = $sender->id;
        $data['sender_type'] = get_class($sender);
    }

    return $this->discussionRepository->create($data);
}


    public function delete(int $id)
{
    $discussion = $this->discussionRepository->getByProjectId($id); // تأكد أن لديك دالة find في الريبوستري، أو استخدم Model::find($id)
    return $this->discussionRepository->delete($id);
}
}
