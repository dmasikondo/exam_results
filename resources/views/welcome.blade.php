<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Harare Polytechnic Results</title>
        <link rel="icon" href="{{ URL::asset('storage/images/favicon2.png') }}" type="image/x-icon"/>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- header inner -->
        <div class="bg-cover" style="background-image: url('/storage/images/banner.jpg')">
         <div class="mx-auto max-w-7xl">
            <div class="grid grid-rows-3 gap-4 my-4 mb-20 md:grid-cols-3">
                <div class="pt-4 mt-8 text-blue-900 email">
                    <a href="mailto:info@hrepoly.ac.zw"><x-icon name="mail" class="w-8 h-8"/> Email : hrepoly@hrepoly.ac.zw</a>
                </div>
                <div class="mt-4 logo">
                    <a href="/"><img src="/storage/images/hrepoly_logo.png" /></a>
                </div>
                <div class="pt-4 pb-20 mt-8 contact_nu">
                    <a href="#"> <x-icon name="phone" class="w-8 h-8 text-blue-900"/> Contact : +263 8677000343</a>
                </div>
            </div>
            <div class="py-32 mx-4 my-20">
                <div class="space-y-4 font-semibold traking-wide">
                    <x-session-warning/>
                    <h1 class="text-6xl text-blue-900 ">View</h1>
                    <h2 class="text-5xl ">Your Results Online</h2>
                </div>
                <div class="inline-block px-6 py-2 mt-8 mb-40 text-xl text-center bg-white border border-blue-900 hover:bg-gray-100">
                    <button class="">
                        <a href="#how">HOW ??</a>
                    </button>
                </div>

            </div>

            </div>
        </div>


        <div class="relative flex items-top justify-center {{-- min-h-screen --}} {{-- bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0 --}}">
            @if (Route::has('login'))
                <div class="{{-- hidden --}} fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        @if(Auth::user()->isStudent())
                            <a href="{{ url('/my-results') }}" class="text-sm text-gray-700 underline">Dashboard</a>

                        @elseif((Auth::user()->hasRole('hod') && Auth::user()->belongsTodepartmentOf('IT Unit')) || Auth::user()->hasRole('superadmin'))
                             <a href="{{ url('/users/registration') }}" class="text-sm text-gray-700 underline">Dashboard</a>

                        @elseif((Auth::user()->hasRole('hod') && Auth::user()->belongsTodepartmentOf('accounts')) || Auth::user()->hasRole('accounts'))
                             <a href="{{ url('/dashboard/fees-clearances') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                        @else
                            <a href="{{ url('/') }}" class="text-sm text-gray-700 underline">Dashboard</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif


        <div class="bg-white with-full">
            <div class="{{-- grid md:grid-cols-2 grid-rows-2 gap-12 --}} md:flex">
                <div class="relative md:flex-1">
                    <div class="absolute inset-0 bg-gradient-to-r from-blue-900 to-gray-700 {{-- transform -skew-y-3 --}}transform -skew-y-3 -rotate-6  shadow-lg rounded-3xl -translate-y-6"></div>
                    <div class="relative">
                        <div id="how" class="p-6 bg-white shadow-lg rounded-xl">
                            <h3 class="py-4 text-4xl font-extrabold text-blue-900"><a name="how">How to Access<strong class="text-gray-700"> / View your Results Online</strong></a></h3>
                            <ul type="square" class="pt-8 pb-16 space-y-4">
                                <x-list.ticked> <a href="/register" class="text-blue-900 hover:text-blue-500 hover:bg-gray-100">Register</a> using your candidate number with NO - SPACES</x-list.ticked>
                                <x-list.ticked> Enter your Surname and first name(s) as is on your Student ID</x-list.ticked>
                                <x-list.ticked> Enter your National ID Number as it is on your offer letter or student ID</x-list.ticked>
                                <x-list.ticked> Enter a valid email address, do not forget it, it will be required when logging in</x-list.ticked>
                                <x-list.ticked> Set your password and do not forget it as it will be required when logging in</x-list.ticked>
                                <x-list.ticked> If you were cleared by accounts, you will be able to view your results</x-list.ticked>
                                <x-list.ticked> If not cleared then you will need to upload your proof of payment in pdf / picture format</x-list.ticked>
                                <x-list.ticked> The fees clearance status is availed to you when you successfully register</x-list.ticked>
                                <p>Do not forget to log out!</p>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class=" md:flex-1">
                    <img src="/storage/images/how.png" alt="how_to_view_your_results">
                </div>
            </div>
        </div>
        </div>
        <div class="py-4 bg-blue-900">
            <div class="mx-auto max-w-7xl">
                <div class="flex justify-center mx-4 mt-4 sm:items-center sm:justify-between">
                    <div class="text-sm text-center text-gray-500 sm:text-left">
                        <div class="flex items-center">

                            <a href="https://portal.hrepoly.ac.zw" class="ml-1 underline">
                                Portal
                            </a>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p>&copy; {{date('Y')}} IT Unit</p>
                    </div>

                    <div class="ml-4 text-sm text-center text-gray-500 sm:text-right sm:ml-0">
                        <a href="https://www.hrepoly.ac.zw">Harare Polytechnic</a>
                    </div>
                </div>
            </div>
        </div>

    </body>
</html>
