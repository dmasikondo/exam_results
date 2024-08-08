<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Exam Results') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="flex flex-col items-center min-h-screen pt-6 bg-gray-100 sm:justify-center sm:pt-0 dark:bg-gray-900">

            <div class=" md:flex">
                <div class="relative md:flex-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-gray-700 {{-- transform -skew-y-3 --}}transform -skew-y-2 -rotate-4  shadow-lg rounded-3xl -translate-y-3">
                    </div>
                    <div class="relative">
                        <div id="login" class="p-6 bg-gray-100 shadow-lg -- rounded-xl">
                            <div class="w-full px-6 py-4 mt-6 overflow-hidden {{-- bg-white --}} shadow-md sm:max-w-md dark:bg-gray-800 sm:rounded-lg">
                                <div class="flex justify-center -mt-4">
                                    <a href="/" wire:navigate>
                                        <x-application-logo class="w-20 h-20 text-gray-500 fill-current" />
                                    </a>
                                </div>
                                <div class="my-4">
                                   {{ $slot }}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
