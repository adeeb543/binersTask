<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\Project;

class ProjectPolicy
{
    public function view($user, Project $project): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $project->user_id === $user->id;
    }

    public function update($user, Project $project): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $project->user_id === $user->id;
    }

    public function delete($user, Project $project): bool
    {
        if ($user instanceof Admin) {
            return true;
        }
        return $project->user_id === $user->id;
    }
}
