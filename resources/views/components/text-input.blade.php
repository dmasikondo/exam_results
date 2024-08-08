@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'peer h-12 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm placeholder-transparent focus:ring-opacity-50 focus:ring-opacity-50 text-lg font-semibold focus:invalid:border-pink-500 focus:invalid:ring-pink-500']) !!}>


{{-- <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'peer h-12 w-full border-gray-300 border-1.5 rounded-md  placeholder-transparent focus:border-indigo-300 focus:ring focus:ring-indigo-900 focus:ring-opacity-50 rounded-md py-6 px-6 text-gray-400 text-lg font-semibold focus:invalid:border-pink-500 focus:invalid:ring-pink-500']) !!}> --}}
