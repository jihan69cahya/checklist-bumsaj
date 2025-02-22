<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="flex items-center justify-center min-h-screen"
        style="background-image: url('/images/mega mendung biru.png'); background-size: contain; background-repeat: repeat;">
        <div class="flex w-full max-w-4xl overflow-hidden bg-white rounded-lg shadow-lg">
            <div class="hidden w-1/2 bg-yellow-500 md:block"></div>
            <div class="w-full p-10 md:w-1/2">
                <h2 class="text-lg font-semibold">SELAMAT DATANG</h2>
                <h1 class="text-2xl font-bold">BANDAR UDARA MUTIARA SIS AL JUFRI</h1>
                <p class="mb-6 text-sm text-gray-500">Kelengkapan Tanpa Kompromi, Standar Tinggi untuk Keamanan dan
                    Efisiensi Bandara.</p>

                @if ($errors->any())
                    <div class="p-4 mb-4 text-red-700 bg-red-100 border border-red-400 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login.authenticate') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700" for="email">Email</label>
                        <input
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700" for="password">Password</label>
                        <input
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            id="password" name="password" type="password" required>
                    </div>
                    <button class="w-full py-2 text-white transition bg-blue-600 rounded-md hover:bg-yellow-600"
                        type="submit">Masuk</button>
                </form>
            </div>
        </div>
    </body>

</html>
