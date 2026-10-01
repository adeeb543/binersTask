<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\ProjectFile;

class ProjectFilePolicy
{
    public function delete($user, ProjectFile $file): bool
    {
        // إذا كان المستخدم Admin يمتلك الصلاحية دائماً
        if ($user instanceof Admin) {
            return true;
        }

        // التأكد أن المشروع الذي يتبع له الملف يملكه المستخدم الحالي
        return $file->project && $file->project->user_id === $user->id;
    }
}
