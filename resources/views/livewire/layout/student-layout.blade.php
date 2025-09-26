<div>
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Student Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="min-h-screen flex">
        {{-- Student Sidebar --}}
        @include('layouts.student-sidebar')

        <div class="flex-1 flex flex-col">
            {{-- Navigation --}}
            <livewire:layout.navigation />

            {{-- Content --}}
            <main class="py-6 px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>

</div>
