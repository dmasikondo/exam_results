<div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Activate your account') }}
        </h2>
    </x-slot>
   <div class="py-12">
        <div class="mx-auto bg-indigo-200 shadow-inner max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 mb-6 bg-white border-b border-gray-200 shadow-lg sm:px-20">
                <div>
                    <div class="w-full p-5 bg-white rounded-lg lg:w-10/12 lg:rounded-l-none">
                        <x-session-message/>
                        <h3 class="pt-4 text-2xl text-center">Activating Your Account!</h3>
                        <form action="/users/activate-account" method="post" class="px-8 pt-6 pb-8 mb-4 bg-white rounded">
                            @csrf
                            @method('put')
                            <input type="hidden" name="token" value="{{$token}}">
                            <p>
                                @error('token')
                                    <span class="text-sm italic text-red-500">Invalid / Expired Token</span>
                                @enderror
                            </p>


                        <div class="flex flex-col gap-2 my-4 md:flex-row center">

                            <div class="relative flex-1">
                            <x-text-input id="first_name" value="{{old('first_name')}}" name="first_name" type="text"
                                placeholder="First Name(s)"
                                required
                                class="@error('first_name')border-red-400 @enderror"
                            />
                            <x-input-label for="first_name">First Name(s)</x-input-label>
                            <div class="absolute top-0 right-0 mt-2 mr-2">
                            </div>
                                <p>
                                    @error('first_name')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>

                            <div class="relative flex-1">
                            <x-text-input id="second_name" value="{{old('second_name')}}" name="second_name" type="text"
                                placeholder="Last Name"
                                required
                                class="@error('second_name')border-red-400 @enderror"
                            />
                            <x-input-label for="second_name">Last Name</x-input-label>
                            <div class="absolute top-0 right-0 mt-2 mr-2">
                            </div>
                                <p>
                                    @error('second_name')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 my-4 md:flex-row center">

                            <div class="relative flex-1">
                            <x-text-input id="password" name="password" type="password"
                                placeholder="Password"
                                required
                                class="@error('password')border-red-400 @enderror"
                            />
                            <x-input-label for="password">New Password</x-input-label>
                            <div class="absolute top-0 right-0 mt-2 mr-2">
                            </div>
                                <p>
                                    @error('password')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>

                            <div class="relative flex-1">
                            <x-text-input id="password_confirmation"  name="password_confirmation" type="password"
                                placeholder="Confirm Password"
                                required
                                class="@error('password_confirmation')border-red-400 @enderror"
                            />
                            <x-input-label for="password_confirmation">Confirm Password</x-input-label>
                            <div class="absolute top-0 right-0 mt-2 mr-2">
                            </div>
                                <p>
                                    @error('password_confirmation')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>

                        </div>

                            <div class="my-6 text-center">
                                <button class="w-full px-4 py-2 font-bold text-white bg-indigo-500 rounded-full hover:bg-indigo-700 focus:outline-none focus:shadow-outline" type="submit">
                                    Activate Account
                                </button>
                            </div>
                            <hr class="mb-6 border-t">

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
</div>
