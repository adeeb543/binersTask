<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class DashboardProjectController extends Controller
{
    protected $projectService;

    // حقن السيرفيس لاستخدامها عند الحاجة لدوال معينة
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * عرض قائمة المشاريع في الداشبورد
     */
    public function index()
    {
        $projects = Project::latest()->paginate(10);

        return view('dashboard.projects.index', compact('projects'));
    }

    /**
     * تحديث حالة المشروع من الداشبورد
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        $project = Project::findOrFail($id);
        $project->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة المشروع بنجاح');
    }
}
