<?php

namespace App\Services;

use App\Repositories\StudyRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class StudyService
{
    protected $studyRepository;

    public function __construct(StudyRepositoryInterface $studyRepository)
    {
        $this->studyRepository = $studyRepository;
    }

    /**
     * حفظ دراسة جديدة للطلب
     */
    public function createStudy($project, array $data)
    {
        $data['project_id'] = $project->id;
        // ربط الدراسة بالمشرف الحالي
        $data['admin_id'] = Auth::guard('admin')->id();

        return $this->studyRepository->create($data);
    }

    /**
     * تحديث الدراسة الحالية
     */
    public function updateStudy($study, array $data)
    {
        return $this->studyRepository->update($study, $data);
    }

    /**
     * جلب دراسة عبر الـ ID
     */
    public function getProjectStudy(int $projectId)
{
    return $this->studyRepository->findByProjectId($projectId);
}
}
