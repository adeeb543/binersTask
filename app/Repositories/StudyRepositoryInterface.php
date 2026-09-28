<?php

namespace App\Repositories;

use App\Models\Study;

interface StudyRepositoryInterface
{
    public function findByProjectId(int $projectId): ?Study;
    public function create(array $data): Study;
    public function update(Study $study, array $data): bool;
}
