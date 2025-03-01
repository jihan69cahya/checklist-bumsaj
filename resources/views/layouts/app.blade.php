<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <title>@yield('title', 'My Laravel App')</title>
        @if (app()->environment('local'))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            @php $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true); @endphp
            <link href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}" rel="stylesheet">
            <script src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}" defer></script>
        @endif
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
