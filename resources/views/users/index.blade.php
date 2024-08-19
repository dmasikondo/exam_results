<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('HrePoly User Profiles') }}
        </h2>
    </x-slot>

    <div class="mx-4 mt-4">
      <div class="overflow-hidden rounded-lg shadow-xs max-w-7xl">

        <div class="overflow-x-auto">
            @include('partials.search_user')
            <x-session-warning/>
            <x-session-message/>
            @include('partials.users_list')
      </div>
     </div>
    </div>
</x-app-layout>
