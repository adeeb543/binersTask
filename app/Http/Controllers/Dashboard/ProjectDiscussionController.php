<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discussion\StoreProjectDiscussionRequest;
use App\Models\Project;
use App\Services\ProjectDiscussionService;

class ProjectDiscussionController extends Controller
{
    protected $discussionService;

    public function __construct(ProjectDiscussionService $discussionService)
    {
        $this->discussionService = $discussionService;
    }

    public function store(StoreProjectDiscussionRequest $request, Project $project)
    {
        $file = $request->file('file');

        $this->discussionService->storeDiscussion($project, $request->validated(), $file);

        return redirect()->back()->with('success', 'تم إرسال الطلب/الملاحظة بنجاح.');
    }


    public function show(Project $project)
    {
        // جلب مناقشات هذا المشروع عبر الـ Service
        $discussions = $this->discussionService->getProjectDiscussions($project->id);

        return view('dashboard.projects.show', compact('project', 'discussions'));
    }
}
