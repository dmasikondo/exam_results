@props(['value'])

<label {{ $attributes->merge(['class' => 'absolute left-2 px-1 -top-2.5 bg-white text-gray-700 dark:text-gray-300 text-sm transition-all peer-placeholder-shown:text-base peer-placeholder-shown:text-indigo-500 peer-placeholder-shown:top-2 peer-focus:-top-2.5 peer-focus:text-indigo-600 peer-focus:text-sm']) }}>
	{{ $value ?? $slot }}
</label>
