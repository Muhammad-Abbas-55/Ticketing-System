<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Ticketing System</title>

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
<body class="bg-gradient-to-br from-black via-blue-900 to-black min-h-screen flex justify-center items-center p-6">

    <form method="POST" action="{{ route('password.email') }}" class="w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
        @csrf

        <h2 class="text-3xl font-semibold text-center text-gray-800 mb-8">Reset Your Password</h2>

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Email')" class="text-gray-600" />
            <x-text-input 
                id="email" 
                class="block mt-1 w-full border border-gray-300 p-2 rounded-md focus:ring-blue-500 focus:border-blue-500"
                type="email" 
                name="email" 
                :value="old('email')" 
                required 
                autofocus 
            />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="w-full py-3 px-4 text-center bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition duration-300">
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>

</body>
</html>
