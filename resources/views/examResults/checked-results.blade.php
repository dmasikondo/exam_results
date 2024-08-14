<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between mx-2">

            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Checked Exam Results') }}
            </h2>
            <p class ="text-gray-400.text-sm">
                 for candidate No. - {{$candidateNumber ?? ''}}
            </p>
        </div>

    </x-slot>

    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 mt-4 mb-16">
        @livewire('examResults.result-check')
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="my-4">
                        <livewire:examResults.suppressed/>
                    </div>
                    @include('partials.examresults-table')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
