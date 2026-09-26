<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Study\StoreStudyRequest;
use App\Http\Requests\Study\UpdateStudyRequest;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Study;
use App\Services\StudyService;
use Illuminate\Support\Facades\Auth;

class StudyController extends Controller
{
    protected $studyService;

    public function __construct(StudyService $studyService)
    {
        $this->studyService = $studyService;
    }

    public function create(Project $project)
    {
        if ($project->study) {
            return redirect()->route('admin.studies.edit', $project->study->id);
        }

        return view('dashboard.studies.create', compact('project'));
    }

    public function store(StoreStudyRequest $request, Project $project)
    {

        $this->studyService->createStudy($project, $request->all());

        return redirect()->route('admin.projects.show', $project->id)
            ->with('success', 'تم إضافة دراسة الطلب بنجاح.');
    }

    public function edit(Study $study)
    {
        $project = $study->project;
        return view('dashboard.studies.edit', compact('study', 'project'));
    }

    public function update(UpdateStudyRequest $request, Study $study)
    {

        $this->studyService->updateStudy($study, $request->all());

        return redirect()->route('admin.projects.show', $study->project_id)
            ->with('success', 'تم تحديث الدراسة بنجاح.');
    }
}
