<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - الداشبورد</title>
    <!-- تضمين تيلويند سي إس إس للتنسيق السريع -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- ناف بار أو هيدر بسيط -->
    <nav class="bg-white shadow mb-6">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">لوحة التحكم</h1>
            <a href="{{ route('admin.projects.index') }}" class="text-blue-600 hover:underline">المشاريع</a>
        </div>
    </nav>

    <!-- محتوى الصفحات -->
    <main>
        @yield('content')
    </main>

</body>
</html>
