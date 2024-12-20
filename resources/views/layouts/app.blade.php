<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'E-Library')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
</head>

<body>
    <section class="p-0 m-0 min-h-screen bg-slate-50">
        @include('partials.navbar')
        <main>
            <div class="flex items-center justify-center w-full">
                @include('partials.alert')
            </div>
            @yield('content')
        </main>
        @include('partials.footer')
    </section>

    @routes

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#mobile-navbar-toggle').on('click', function() {
                $('#mobile-navbar').stop(true, true).slideToggle(300);
            });
        }, false);
    </script>
    @stack('scripts')
</body>

</html>
