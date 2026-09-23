@extends('layouts.app') {{-- أو التيمبليت الخاص بالداشبورد عندك --}}

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">إدارة المشاريع</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">اسم المشروع</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">الحالة الحالية</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">تغيير الحالة</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($projects as $project)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $project->name ?? 'مشروع #' . $project->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($project->status == 'completed') bg-green-100 text-green-800
                                @elseif($project->status == 'in_progress') bg-blue-100 text-blue-800
                                @elseif($project->status == 'rejected') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $project->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{-- فورم تغيير الحالة مع التحديث الفوري --}}
                            <form action="{{ route('dashboard.projects.updateStatus', $project->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                    <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                                    <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>قيد التنفيذ</option>
                                    <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>مكتمل</option>
                                    <option value="rejected" {{ $project->status == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">لا توجد مشاريع مضافة حالياً.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection
