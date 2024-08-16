<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between mx-2">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Send My Proof of Payment') }}
            </h2>
        </div>

    </x-slot>
    <div class="mx-auto mt-4 mb-16 shadow-lg max-w-7xl sm:px-6 lg:px-8">
    {{-- <div class="p-6 mb-6 bg-white border-b border-gray-200 shadow-lg sm:px-20"> --}}
        @livewire('comment.comment-upload',['fileableType' =>"App\Models\Fee",'isFromStudent'=>true, 'possibleNewProofOfPayment'=>true,])
    </div>

</x-app-layout>
