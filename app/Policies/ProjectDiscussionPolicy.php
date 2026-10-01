<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Project;
use App\Models\ProjectDiscussion;

class ProjectDiscussionPolicy
{
    // هل يمكن للمستخدم عرض مناقشات هذا المشروع؟
    public function viewAny($user, Project $project): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $project->user_id === $user->id;
    }

    // هل يمكن للمستخدم عرض تفاصيل رسالة محددة؟
    public function view($user, ProjectDiscussion $discussion): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $discussion->project && $discussion->project->user_id === $user->id;
    }

    // هل يمكن للمستخدم إرسال رسالة/مناقشة جديدة في هذا المشروع؟
    public function create($user, Project $project): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $project->user_id === $user->id;
    }

    // هل يمكن للمستخدم تعديل الرسالة؟ (غالباً فقط صاحب الرسالة)
    public function update($user, ProjectDiscussion $discussion): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $discussion->sender_type === get_class($user) && $discussion->sender_id === $user->id;
    }

    // هل يمكن للمستخدم حذف الرسالة؟ (مالك المشروع أو صاحب الرسالة نفسه)
    public function delete($user, ProjectDiscussion $discussion): bool
    {
        if ($user instanceof Admin) {
            return true;
        }

        $isProjectOwner = $discussion->project && $discussion->project->user_id === $user->id;
        $isSender = $discussion->sender_type === get_class($user) && $discussion->sender_id === $user->id;

        return $isProjectOwner || $isSender;
    }
}
