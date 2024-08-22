<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-7 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('') }}
                    </x-nav-link>
                </div>
        <!-- Student -->
          @if(Auth::user()->isStudent())
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('myresults')" :active="request()->routeIs('myresults')" wire:navigate>
                        <x-icon name="book-open" class="size-4"/>
                        {{ __('Exam Results') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('check-results')" :active="request()->routeIs('check-results')" wire:navigate>
                        <x-icon name="academic-cap" class="size-4"/>
                        {{ __('Check Other Results') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="#" wire:navigate>
                        <x-icon name="question-mark-circle" class="size-4"/>
                        {{ __('Exam Queries') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="#" :active="request()->routeIs('proof-of-payment')"  wire:navigate>
                        <x-icon name="currency-dollar" class="size-4"/>
                        {{ __('Fees Clearance') }}
                    </x-nav-link>
                </div>
            @endif
         <!--./ Student -->

          {{-- ITU --}}

      @if(Auth::user()->hasRole('superadmin') || (Auth::user()->belongsTodepartmentOf('IT Unit') && Auth::user()->hasRole('hod')))
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('staff-user-create')" :active="request()->routeIs('staff-user-create') || request()->routeIs('user-edit')" wire:navigate>
                        <x-icon name="user-add" class="size-4"/>
                        {{ __(' Add Staff User') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('users')" :active="request()->routeIs('users')" wire:navigate>
                        <x-icon name="users" class="size-4"/>
                        {{ __(' Users') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('results-csv')" :active="request()->routeIs('results-csv')" wire:navigate>
                        <x-icon name="ticked" class="size-4"/>
                        {{ __(' Exam Results csv') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('cleared-students-csv')" :active="request()->routeIs('cleared-students-csv')" wire:navigate>
                        <x-icon name="arrow-path" class="size-4"/>&nbsp;
                        {{ __(' Cleared Students csv') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link href="https://github.com/dmasikondo/exam_results"  target="_blank">
                        <x-icon name="book-open" class="size-4"/>
                        {{ __(' Documentation') }}
                    </x-nav-link>
                </div>
      @endif
      {{-- ./ITU --}}
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                            {{-- <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div> --}}
                            <div class="flex items-center justify-center w-8 h-8 mb-2 bg-blue-100 rounded-full">
                                <span class="text-sm font-semibold">
                                    {{ auth()->user()->userAvatar() }}
                                </span>
                            </div>
                                <div class="ms-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400 border-b-gray-200">
                            {{ __('Manage Your Account') }}
                        </div>
                        <div class="flex flex-col px-4 py-2 text-xs text-gray-400">
                            <div class="flex items-center justify-center w-8 h-8 mb-2 bg-blue-100 rounded-full">
                                <span class="text-sm font-semibold">
                                    {{ auth()->user()->userAvatar() }}
                                </span>
                            </div>
                            <div class="text-left">
                                <p class="text-sm font-semibold">
                                    {{ auth()->user()->first_name.' '.  auth()->user()->second_name }}</p>
                            </div>
                        </div>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            <x-icon name="mail" class="w-6 h-6 text-blue-100"/>
                            {{ Auth::user()->email }}
                        </div>
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -me-2 sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

    {{-- isStudent --}}
    @if(Auth::user()->isStudent())
        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('myresults')" :active="request()->routeIs('myresults')" wire:navigate>
                <x-icon name="book-open" class="size-4"/>
                {{ __(' Other Results') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('check-results')" :active="request()->routeIs('check-results')" wire:navigate>
                <x-icon name="academic-cap" class="size-4"/>
                {{ __(' Other Results') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" href="#" wire:navigate>
                <x-icon name="question-mark-circle" class="size-4"/>
                {{ __(' Exam Queries') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" href="#" :active="request()->routeIs('proof-of-payment')" wire:navigate>
                <x-icon name="currency-dollar" class="size-4"/>
                {{ __(' Fees Clearance') }}
            </x-responsive-nav-link>
        </div>
    @endif
    {{-- ./isStudent --}}


    {{-- isITU --}}
    @if(Auth::user()->hasRole('superadmin') || (Auth::user()->belongsTodepartmentOf('IT Unit') && Auth::user()->hasRole('hod')))

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('staff-user-create')" :active="request()->routeIs('staff-user-create')  || request()->routeIs('user-edit')" wire:navigate>
                <x-icon name="user-add" class="size-4"/>
                {{ __(' Add Staff User') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('users')" :active="request()->routeIs('users')" wire:navigate>
                <x-icon name="users" class="size-4"/>
                {{ __(' Users') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('results-csv')" :active="request()->routeIs('results-csv')" wire:navigate>
                <x-icon name="ticked" class="size-4"/>
                {{ __(' Exam Results csv') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center" :href="route('cleared-students-csv')" :active="request()->routeIs('cleared-students-csv')" wire:navigate>
                <x-icon name="arrow-path" class="size-4"/>
                {{ __(' Cleared Students csv') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-2 pb-3 space-x-1">
            <x-responsive-nav-link class="flex items-center"  href="https://github.com/dmasikondo/exam_results"  target="_blank">
                <x-icon name="book-open" class="size-4"/>
                {{ __(' Documentation') }}
            </x-responsive-nav-link>
        </div>
    @endif

    {{-- ./isITU --}}

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800 dark:text-gray-200" x-data="{{-- {{ json_encode(['name' => auth()->user()->first_name]) }} --}}" x-text="name" x-on:profile-updated.window="name = $event.detail.name">
                </div>

                <div class="flex items-center justify-center w-8 h-8 mb-2 bg-blue-100 rounded-full">
                    <span class="text-sm font-semibold">
                        {{ auth()->user()->userAvatar() }}
                    </span>
                </div>
                <div class="text-sm font-medium text-gray-500">
                    {{ auth()->user()->first_name.' '.  auth()->user()->second_name }}
                </div>
                <div class="block px-4 py-2 text-xs text-gray-400">
                    <x-icon name="mail" class="w-6 h-6 text-blue-100"/>
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link class="flex items-center" :href="route('profile')" :active="request()->routeIs('profile')" wire:navigatewire:navigate>
                    <x-icon name="user" class="size-4"/>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="flex items-center">
                        <x-icon name="lock-closed" class="size-4"/>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
