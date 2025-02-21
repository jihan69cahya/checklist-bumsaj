<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen" style="background-image: url('/images/mega mendung biru.png'); background-size: contain; background-repeat: repeat;">

    <div class="w-full max-w-4xl bg-white shadow-lg rounded-lg overflow-hidden flex">
        <div class="w-1/2 bg-yellow-500 hidden md:block"></div>

        <div class="w-full md:w-1/2 p-10">
            <h2 class="text-lg font-semibold">SELAMAT DATANG</h2>
            <h1 class="text-2xl font-bold">BANDAR UDARA MUTIARA SIS AL JUFRI</h1>
            <p class="text-gray-500 text-sm mb-6">Kelengkapan Tanpa Kompromi, Standar Tinggi untuk Keamanan dan Efisiensi Bandara.</p>
            
            <form action="{{ route('beranda') }}" method="GET">
                <div class="mb-4">
                    <label class="block text-gray-700" for="username">Username</label>
                    <input id="username" type="text" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-700" for="password">Password</label>
                    <input id="password" type="password" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-yellow-600 transition">Masuk</button>
            </form>
        </div>
    </div>
</body>
</html>