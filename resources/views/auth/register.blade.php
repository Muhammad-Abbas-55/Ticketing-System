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

<body class="bg-gradient-to-br from-black via-blue-900 to-black min-h-screen flex flex-col justify-center items-center p-6">

    <form method="POST" action="{{ route('register') }}" class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl">
        @csrf

        <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Register</h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-600" />
            <x-text-input id="name" 
                class="block mt-1 w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="text" 
                name="name" 
                :value="old('name')" 
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-600" />
            <x-text-input id="email" 
                class="block mt-1 w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="email" 
                name="email" 
                :value="old('email')" 
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-gray-600" />
            <x-text-input id="password" 
                class="block mt-1 w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="password" 
                name="password" 
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-600" />
            <x-text-input id="password_confirmation" 
                class="block mt-1 w-full border border-gray-300 px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" 
                type="password" 
                name="password_confirmation" 
                required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="underline text-sm text-gray-600 hover:text-blue-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4 w-full py-3 flex justify-center items-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</body>

</html>
