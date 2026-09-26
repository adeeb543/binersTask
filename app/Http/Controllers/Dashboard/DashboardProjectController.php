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
        // استخدام دالة من الـ Service بدلاً من الاستعلام المباشر (يمكنك إضافتها للـ Service إذا لم تكن موجودة)
        $projects = $this->projectService->getAllProjectsForDashboard(10);

        return view('dashboard.projects.index', compact('projects'));
    }

    /**
     * عرض تفاصيل المشروع مع علاقاته
     */
    public function show($id)
    {
        // جلب المشروع مع العلاقات عبر الـ Service
        $project = $this->projectService->getProjectDetailsForAdmin($id);

        if (! $project) {
            abort(404, 'المشروع غير موجود');
        }

        return view('dashboard.projects.show', compact('project'));
    }

    /**
     * تحديث حالة المشروع من الداشبورد
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,rejected',
        ]);

        // تمرير العملية للـ Service لتحديث الحالة ومنطقها البرمجي
        $this->projectService->updateProjectStatus($id, $request->status);

        return redirect()->back()->with('success', 'تم تحديث حالة المشروع بنجاح');
    }
}
