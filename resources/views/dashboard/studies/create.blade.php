@extends('dashboard.layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- رأس الصفحة -->
    <div class="flex justify-between items-center bg-white p-6 rounded-lg shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">إضافة دراسة تقنية للطلب: #{{ $project->id }}</h1>
            <p class="text-gray-500 text-sm mt-1">المشروع: {{ $project->title }}</p>
        </div>
        <a href="{{ route('admin.projects.show', $project->id) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition text-sm font-semibold">
            ← العودة لتفاصيل الطلب
        </a>
    </div>

    <!-- نموذج إضافة الدراسة -->
    <form action="{{ route('admin.studies.store', $project->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow-sm space-y-6">
        @csrf

        <!-- الحل التقني -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">الحل التقني المقترح (Technical Solution):</label>
            <textarea name="technical_solution" rows="4" required placeholder="اكتب تفاصيل الحل التقني..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">{{ old('technical_solution') }}</textarea>
            @error('technical_solution') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- نطاق العمل -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">نطاق العمل (Scope of Work):</label>
            <textarea name="scope_of_work" rows="4" required placeholder="حدد ما سيتم تنفيذه ضمن هذا الطلب..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">{{ old('scope_of_work') }}</textarea>
            @error('scope_of_work') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- المدة المقدرة بالأيام -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">المدة المقدرة (بالأيام):</label>
                <input type="number" name="estimated_duration_days" min="1" required placeholder="مثال: 14" value="{{ old('estimated_duration_days') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                @error('estimated_duration_days') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <!-- التكلفة المقدرة -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">التكلفة المقدرة ($):</label>
                <input type="number" step="0.01" name="estimated_cost" placeholder="مثال: 500.00" value="{{ old('estimated_cost') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">
                @error('estimated_cost') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- ملاحظات فنية -->
        <div>
            <label class="block text-gray-700 font-semibold mb-2">ملاحظات فنية إضافية (اختياري):</label>
            <textarea name="technical_notes" rows="3" placeholder="أي ملاحظات إضافية للمشرف أو العميل..." class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 border">{{ old('technical_notes') }}</textarea>
            @error('technical_notes') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- أزرار الإجراء -->
        <div class="flex justify-end space-x-3 pt-4 border-t">
            <a href="{{ route('admin.projects.show', $project->id) }}" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg hover:bg-gray-300 transition font-semibold">إلغاء</a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition font-semibold shadow-sm">حفظ الدراسة</button>
        </div>
    </form>
</div>
@endsection
