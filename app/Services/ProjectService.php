<?php
namespace App\Services;

use App\Repositories\ProjectRepositoryInterface;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProjectService
{
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    public function getUserProjects(int $userId): Collection
    {
        return $this->projectRepository->getAllByUser($userId);
    }

    public function createProject(array $data, int $userId): Project
    {
        return DB::transaction(function () use ($data, $userId) {
            $data['user_id'] = $userId;
            return $this->projectRepository->create($data);
        });
    }

    // جلب المشروع بالـ ID فقط (الصلاحية تُفحص بالبوليصي في الكونترولر)
    public function getProjectDetails(int $id): Project
    {
        $project = $this->projectRepository->findById($id);

        if (! $project) {
            throw new NotFoundHttpException('المشروع غير موجود.');
        }

        return $project;
    }

    public function updateProject(int $id, array $data): Project
    {
        $project = $this->getProjectDetails($id);

        DB::transaction(function () use ($project, $data) {
            $this->projectRepository->update($project, $data);
        });

        return $project->fresh();
    }

    public function deleteProject(int $id): void
    {
        $project = $this->getProjectDetails($id);

        DB::transaction(function () use ($project) {
            $this->projectRepository->delete($project);
        });
    }

    // دوال لوحة التحكم الخاصة بالأدمن (تبقى كما هي بكامل قوتها)
    public function getAllProjectsForDashboard($perPage = 10)
    {
        return $this->projectRepository->getPaginated($perPage);
    }

    public function getProjectDetailsForAdmin($id)
    {
        $relations = ['user', 'files', 'discussions', 'study', 'quotation', 'activities'];
        return $this->projectRepository->findByIdWithRelations($id, $relations);
    }

    public function updateProjectStatus($id, string $status)
    {
        return $this->projectRepository->updateStatus($id, $status);
    }
}
