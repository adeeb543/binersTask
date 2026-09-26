<?php

namespace App\Repositories\Eloquent;

use App\Models\Study;
use App\Repositories\StudyRepositoryInterface;

class StudyRepository implements StudyRepositoryInterface
{
    public function findById(int $id): ?Study
    {
        return Study::with('project')->find($id);
    }

    public function create(array $data): Study
    {
        return Study::create($data);
    }

    public function update(Study $study, array $data): bool
    {
        return $study->update($data);
    }
}
