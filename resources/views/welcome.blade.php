<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Tickting System</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-black via-blue-900 to-black min-h-screen flex flex-col justify-center items-center">

    <div class="text-center">
        <h1 class="text-5xl font-bold text-white mb-6">Welcome to Tickting System</h1>
        <p class="text-gray-300 text-lg mb-8">Your Tickting application is ready. Build something amazing!</p>

        <div class="flex justify-center gap-6">
            <a href="{{ url('/login') }}" class="px-6 py-3 bg-blue-700 text-white rounded-lg hover:bg-blue-800 transition">Login</a>
            <a href="{{ url('/register') }}" class="px-6 py-3 bg-gray-700 text-white rounded-lg hover:bg-gray-600 transition">Register</a>
        </div>
    </div>

    <footer class="absolute bottom-4 text-gray-500 text-sm">
        ©All rights reserved.
    </footer>

</body>
</html>
