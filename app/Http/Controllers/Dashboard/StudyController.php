<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Study;
use Illuminate\Support\Facades\Auth;

class StudyController extends Controller
{
    public function create(Project $project)
    {
        // إذا كان الطلب يمتلك دراسة مسبقاً، نحوله لصفحة التعديل مباشرة
        if ($project->study) {
            return redirect()->route('admin.studies.edit', $project->study->id);
        }

        return view('dashboard.studies.create', compact('project'));
    }

    // حفظ الدراسة في قاعدة البيانات
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'technical_solution'      => 'required|string',
            'scope_of_work'           => 'required|string',
            'estimated_duration_days' => 'required|integer|min:1',
            'estimated_cost'          => 'nullable|numeric|min:0',
            'technical_notes'         => 'nullable|string',
        ]);

        Study::create([
            'project_id'              => $project->id,
            'admin_id'                => Auth::guard('admin')->id(), // أو guard('admin') حسب إعدادات المصادقة لدينك
            'technical_solution'      => $request->technical_solution,
            'scope_of_work'           => $request->scope_of_work,
            'estimated_duration_days' => $request->estimated_duration_days,
            'estimated_cost'          => $request->estimated_cost,
            'technical_notes'         => $request->technical_notes,
        ]);

        return redirect()->route('admin.projects.show', $project->id)
            ->with('success', 'تم إضافة دراسة الطلب بنجاح.');
    }

    // عرض صفحة تعديل الدراسة
    public function edit(Study $study)
    {
        $project = $study->project;
        return view('dashboard.studies.edit', compact('study', 'project'));
    }

    // تحديث الدراسة
    public function update(Request $request, Study $study)
    {
        $request->validate([
            'technical_solution'      => 'required|string',
            'scope_of_work'           => 'required|string',
            'estimated_duration_days' => 'required|integer|min:1',
            'estimated_cost'          => 'nullable|numeric|min:0',
            'technical_notes'         => 'nullable|string',
        ]);

        $study->update($request->all());

        return redirect()->route('admin.projects.show', $study->project_id)
            ->with('success', 'تم تحديث الدراسة بنجاح.');
    }
}
