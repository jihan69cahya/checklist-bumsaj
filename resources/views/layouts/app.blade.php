<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'My Laravel App')</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-100">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="fixed top-0 left-0 h-full">
                <!-- Sidebar component -->
                <x-sidebar />
            </div>

            <!-- Main content area -->
            <div class="w-full p-8 ml-64 content">
                @yield('content')
            </div>
        </div>
    </body>

</html>
