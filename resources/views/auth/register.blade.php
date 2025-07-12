<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hampersly') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex">
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-[#FFE99A] to-[#FFAAAA] items-center justify-center p-12 text-center relative overflow-hidden">
            <div>
                <h1 class="text-4xl lg:text-5xl font-extrabold text-white">Bergabung dengan Kami</h1>
                <p class="mt-4 text-lg text-white/80">Daftarkan akun Anda dan mulailah perjalanan Anda, baik sebagai pembeli maupun penjual hampers unik.</p>
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center bg-white p-8">
            <div class="w-full max-w-md">
                <a href="/" class="flex justify-center mb-8">
                    <div class="font-extrabold text-4xl text-[#A16262]">
                        Hampersly
                    </div>
                </a>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div>
                        <label for="name" class="block font-medium text-sm text-gray-700">{{ __('Name') }}</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                               class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="email" class="block font-medium text-sm text-gray-700">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                               class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password" class="block font-medium text-sm text-gray-700">{{ __('Password') }}</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password"
                               class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="block font-medium text-sm text-gray-700">{{ __('Confirm Password') }}</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                               class="block mt-1 w-full border-gray-300 focus:border-[#FF9898] focus:ring focus:ring-[#FF9898] focus:ring-opacity-50 rounded-md shadow-sm" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>

                        <button type="submit" class="ms-4 inline-flex items-center px-6 py-3 bg-[#FF9898] border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-[#FFAAAA] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FF9898] transition ease-in-out duration-150">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>