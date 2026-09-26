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

    public function storeDiscussion($project, array $data, $file = null)
    {
        unset($data['file']);
        // معالجة رفع الملف المفرد إن وجد
        if ($file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('discussions_files', $fileName, 'public');

            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $filePath;
        }

        $data['project_id'] = $project->id;

        // ربط الـ Morph للمرسل (Admin الحالي)
        $admin = Auth::guard('admin' )->user();
        $data['sender_id'] = $admin->id;
        $data['sender_type'] = get_class($admin);

        return $this->discussionRepository->create($data);
    }
}
