<div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-extrabold leading-tight {{--text-indigo-200 --}}">
            {{ __('Register a user') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mb-6 bg-white border-b border-gray-200 rounded-full shadow-lg">
                <div>
                    <div class="w-full p-5 bg-white rounded-lg lg:rounded-l-none">
                        <x-session-message/>
                        <x-session-warning/>
                        <h3 class="pt-4 text-2xl text-center text-gray-300">
                        @if(isset($user))
                            Update {{$user->first_name. ' '. $user->second_name }}
                        @else
                                Create a Member of
                        @endif
                             Staff's  User Account!
                        </h3>
                        <form action="{{ isset($user) ? route('user-update', $user->slug) : route('user-store') }}" method="post" class="px-8 pt-6 pb-8 mb-4 bg-white rounded">
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif


                        <div class="flex flex-col gap-2 my-4 md:flex-row center">
                            <div class="relative flex-1">
                            <x-text-input id="first_name" value="{{isset($user) ? $user->first_name : old('first_name')}}" name="first_name" type="text"
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
                            <x-text-input id="last_name" value="{{isset($user) ? $user->second_name : old('last_name')}}" name="last_name" type="text"
                                placeholder="Last Name"
                                required
                                class="@error('last_name')border-red-400 @enderror"
                            />
                            <x-input-label for="last_name">Last Name</x-input-label>
                            <div class="absolute top-0 right-0 mt-2 mr-2">
                            </div>
                                <p>
                                    @error('last_name')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>

                        </div>

                        <div class="flex flex-col gap-2 my-4 md:flex-row center">
                            <div class="relative flex-1">
                            <x-text-input id="email" value="{{isset($user) ? $user->email : old('email')}}" name="email" type="email"
                                placeholder="Email"
                                required
                                class="@error('email')border-red-400 @enderror"
                            />
                            <x-input-label for="email">Email</x-input-label>
                                <p>
                                    @error('email')
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
                                <p>
                                    @error('password_confirmation')
                                        <span class="text-sm italic text-red-500">{{ $message }}</span>
                                    @enderror
                                </p>
                            </div>

                        </div>

                        <div class="flex flex-col gap-2 my-4 md:flex-row center">
                                <div class="relative flex-1 w-full mt-4">
                                    <select id="role"  name="role" placeholder="Select a User Role" required>
                                        <option value="" class="py-4 border-l-4 border-transparent hover:border-blue-500 "></option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}" @if((old('role') && old('role') == $role->id) || (isset($user) && $user->roles->contains('id', $role->id))) selected @endif class="h-12">
                                            {{$role->name}}
                                        </option>
                                    @endforeach
                                    </select>
                                    <x-input-label for="role">Select a User Role</x-input-label>
                                    <p class="text-sm italic text-red-900">@error('role') {{$message}} @enderror</p>
                                </div>

                                <div class="relative flex-1 mt-4">
                                    <select id="department"  name="department" placeholder="Select the User's Department" required>
                                        <option value="" class="py-4 border-l-4 border-transparent hover:border-blue-500 "></option>
                                    @foreach($departments as $department)
                                        <option value="{{$department->id}}" @if((old('department') && old('department') == $department->id) || (isset($user) && $user->staff->contains('department_id', $department->id))) selected @endif class="h-12">
                                            {{$department->name}}
                                        </option>
                                    @endforeach
                                    </select>
                                    <x-input-label for="department">Select the User's Department</x-input-label>
                                    <p class="text-sm italic text-red-900">@error('department') {{$message}} @enderror</p>
                                </div>
                        </div>
                          <div class="my-6 text-center">
                                <button class="inline w-full px-4 py-3 font-bold text-white bg-indigo-300 rounded-full cursor-pointer hover:bg-indigo-100 hover:text-indigo-900" type="submit">
                                    {{ isset($user) ? 'Update ' : 'Create ' }} User Account
                                </button>
                            </div>
                            <hr class="mb-6 border-t">
                        </form>
                        <div class="mx-4 space-y-2 text-sm italic">
                            <p class="font-semibold">NB:</p>
                            <p>Head of Departments such as Accountant must be assigned role of HOD and department name is Accounts</p>
                            <p>Similarily the Principal Librarian has role of HOD and department is Library</p>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
</div>
