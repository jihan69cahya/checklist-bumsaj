<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'My Laravel App')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="bg-gray-100">
        <div class="flex min-h-screen">
            <div class="fixed top-0 left-0 h-full">
                <x-sidebar />
            </div>

            <div class="w-full ml-64">
                @include('components.topbar')

                <div class="p-8">
                    @yield('content')
                </div>
            </div>
        </div>

        @yield('scripts')
    </body>

</html>
