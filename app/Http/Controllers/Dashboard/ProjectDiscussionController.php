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
        $this->discussionService =$discussionService;
    }

    public function store(StoreProjectDiscussionRequest $request, Project$project)
    {
        $file =$request->file('file');

        // تمرير `$project->id` كـ int تماماً كما تطلب السيرفيس، دون تعديل السيرفيس!
        $this->discussionService->storeDiscussion($project->id, $request->validated(),$file);

        return redirect()->back()->with('success', 'تم إرسال الطلب/الملاحظة بنجاح.');
    }

    public function show(Project $project)
    {
        $discussions = $this->discussionService->getProjectDiscussions($project->id);

        return view('dashboard.projects.show', compact('project', 'discussions'));
    }

    public function destroy($projectId,$discussionId)
    {
        // تمرير المعرفين بالترتيب الذي تطلبه السيرفيس: (projectId, discussionId)
        $this->discussionService->deleteDiscussion($projectId,$discussionId);

        return redirect()->back()->with('success', 'تم حذف الرسالة بنجاح');
    }
}
