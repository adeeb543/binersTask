@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <!-- رأس الصفحة وزر العودة -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">تفاصيل الطلب: #{{ $project->id }}</h1>
            <p class="text-gray-500 text-sm mt-1">تاريخ الإنشاء: {{ $project->created_at->format('Y-m-d H:i') }}</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-semibold">
            ← العودة للقائمة
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- العمود الأيمن: المعلومات الأساسية، الدراسة، والملفات -->
        <div class="md:col-span-2 space-y-6">

            <!-- معلومات المشروع الأساسية -->
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">معلومات الطلب</h3>
                <div>
                    <span class="text-gray-500 text-sm">اسم المشروع / العنوان:</span>
                    <p class="text-gray-800 font-semibold text-lg mt-1">{{ $project->title }}</p>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">الوصف التفصيلي:</span>
                    <p class="text-gray-700 mt-1 leading-relaxed bg-gray-50 p-4 rounded-lg">{{ $project->description ?? 'لا يوجد وصف متاح.' }}</p>
                </div>
                <div>
                    <span class="text-gray-500 text-sm">صاحب الطلب (العميل):</span>
                    <p class="text-gray-800 font-medium mt-1">{{ $project->user->name ?? 'غير محدد' }} ({{ $project->user->email ?? '' }})</p>
                </div>
            </div>

            <!-- قسم الدراسة (Study Relation) -->
            <!-- قسم الدراسة الفنية (Study) -->
<div class="bg-white p-6 rounded-lg shadow-sm space-y-4 border-r-4 border-blue-500">
    <div class="flex justify-between items-center border-b pb-2">
        <h3 class="text-lg font-bold text-gray-800">دراسة الطلب الفنية</h3>

        <!-- زر إضافة أو تعديل الدراسة -->
        @if(!$project->study)
            <a href="{{ route('admin.studies.create', $project->id) }}" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-700 transition">
                + إضافة دراسة للطلب
            </a>
        @else
            <a href="{{ route('admin.studies.edit', $project->study->id) }}" class="bg-gray-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-700 transition">
                تعديل الدراسة
            </a>
        @endif
    </div>

    @if($project->study)
        <div class="space-y-4 text-sm text-gray-700">
            <div>
                <span class="font-semibold text-gray-900 block mb-1">الحل التقني (Technical Solution):</span>
                <p class="bg-gray-50 p-3 rounded-lg leading-relaxed">{{ $project->study->technical_solution }}</p>
            </div>

            <div>
                <span class="font-semibold text-gray-900 block mb-1">نطاق العمل (Scope of Work):</span>
                <p class="bg-gray-50 p-3 rounded-lg leading-relaxed">{{ $project->study->scope_of_work }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 pt-2 border-t">
                <div>
                    <span class="text-gray-500 block text-xs">المدة المقدرة:</span>
                    <span class="font-bold text-gray-800 text-base">{{ $project->study->estimated_duration_days }} أيام</span>
                </div>
                <div>
                    <span class="text-gray-500 block text-xs">التكلفة المقدرة:</span>
                    <span class="font-bold text-green-600 text-base">
                        {{ $project->study->estimated_cost ? '$' . number_format($project->study->estimated_cost, 2) : 'غير محددة' }}
                    </span>
                </div>
            </div>

            @if($project->study->technical_notes)
                <div class="pt-2 border-t">
                    <span class="font-semibold text-gray-900 block mb-1">ملاحظات فنية:</span>
                    <p class="bg-gray-50 p-3 rounded-lg text-gray-600">{{ $project->study->technical_notes }}</p>
                </div>
            @endif
        </div>
    @else
        <div class="text-center py-4">
            <p class="text-gray-400 text-sm">لم يتم تقديم دراسة تقنية لهذا الطلب حتى الآن.</p>
        </div>
    @endif
</div>

            <!-- قسم الملفات المرفقة (Files Relation) -->
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">الملفات المرفقة</h3>
                <ul class="divide-y divide-gray-100">
                    @forelse($project->files as $file)
                        <li class="py-3 flex justify-between items-center">
                            <span class="text-sm text-gray-700">{{ $file->file_name ?? basename($file->file_path ?? '') }}</span>
                            <a href="{{ $file->file_path }}" target="_blank" class="text-blue-600 hover:underline text-sm font-semibold">عرض</a>
                        </li>
                    @empty
                        <p class="text-gray-400 text-sm">لا توجد ملفات مرفقة لهذا الطلب.</p>
                    @endforelse
                </ul>
            </div>

        </div>

        <!-- العمود الأيسر: الحالة، عرض السعر (Quotation)، والنشاطات/النقاشات -->
        <div class="space-y-6">

            <!-- الحالة والسعر (من جدول الـ Quotation) -->
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">الملخص المالي والحالة</h3>

                <div class="flex justify-between items-center">
                    <span class="text-gray-500 text-sm">الحالة الحالية:</span>
                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-800 font-bold">
                        {{ $project->status }}
                    </span>
                </div>

                <div class="flex justify-between items-center border-t pt-4">
                    <span class="text-gray-500 text-sm">عرض السعر (Price):</span>
                    <span class="text-green-600 font-bold text-xl">
                        {{ isset($project->quotation->price) ? '$' . number_format($project->quotation->price, 2) : 'لم يُحدد بعد' }}
                    </span>
                </div>
            </div>

            <!-- قسم النقاشات / التعليقات (Discussions Relation) -->
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">النقاشات والملاحظات</h3>
                <div class="space-y-3">
                    @forelse($project->discussions as $discussion)
                        <div class="bg-gray-50 p-3 rounded text-sm">
                            <p class="text-gray-700">{{ $discussion->body ?? $discussion->message ?? '' }}</p>
                            <span class="text-xs text-gray-400 mt-1 block">{{ $discussion->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">لا توجد نقاشات بعد.</p>
                    @endforelse
                </div>
            </div>

            <!-- قسم التحديثات أو النشاطات (Activities Relation) -->
            <div class="bg-white p-6 rounded-lg shadow-sm space-y-4">
                <h3 class="text-lg font-bold text-gray-800 border-b pb-2">سجل التحديثات (Activity Log)</h3>
                <div class="space-y-2">
                    @forelse($project->activities as $activity)
                        <div class="text-xs text-gray-600 border-r-2 border-gray-300 pr-2 py-1">
                            <p>{{ $activity->description ?? $activity->action ?? 'تحديث على المشروع' }}</p>
                            <span class="text-gray-400 text-[10px]">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <p class="text-gray-400 text-sm">لا توجد نشاطات مسجلة.</p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
