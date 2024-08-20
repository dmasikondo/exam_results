<!-- .Users Table -->
      @if($users->count()>0)
              <h2 class="my-4"> {{$users->links()}}</h2>
              <table class="w-full">
                <thead>
                  <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b">
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Dept</th>
                    <th class="px-4 py-3">Status</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
               @foreach($users as $user)
                  <tr class="bg-gray-50">
                    <td class="px-4 py-3">
                      <div class="flex items-center text-sm">
                        <div class="relative hidden w-8 h-8 mr-3 bg-gray-800 rounded-full md:block border-1">

                          <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true">
                            <div class="flex items-center justify-center w-8 h-8 mb-2 bg-blue-100 rounded-full">
                                <span class="text-sm font-semibold">
                                    {{-- {{ $user()->userAvatar() }} --}}
                                </span>
                            </div>
                          </div>
                        </div>
                        <div>
                        <a href="/users/{{$user->slug}}/edit" class="text-blue-400 hover:text-gray-400">
                          <p class="font-semibold">
                            {{$user['second_name']}} {{$user->first_name}}
                       @cannot('updateSelf',$user, Auth::user())
                          (Me)
                       @endcannot
                          </p>
                          <p class="text-xs text-gray-600 dark:text-gray-400">Created 3 days ago</p>
                        </a>

                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                      {{$user->email}}
                    </td>
                    <td class="px-4 py-3 text-sm">
                      @foreach($user->roles as $role)
                        <x-link href="/users?role={{$role->name}}" class="text-blue-400">{{$role->name}}</x-link>
                      @endforeach
                      @if($user->isStudent())
                       <x-link href="/users-students">Student</x-link>
                      @endif


                    </td>
                    <td class="px-4 py-3 text-sm">
                      @foreach($user->staff as $staff)
                          {{$staff->department->name}}
                      @endforeach
                    </td>
                    <td class="px-4 py-3 text-xs">
     {{-- Display user status--}}

                    @include('partials.user_status')

                  @can('updateSelf',$user, Auth::user())
                    @livewire('users.suspend-user', ['slug' => $user->slug], key($user->slug))
                  @endcan


       {{-- ./ Display user status--}}

                      <p class="text-xs text-gray-600 dark:text-gray-400">
                      	{{-- {{!is_null($student->user->fees[0]->cleared_at)? $student->user->fees[0]->cleared_at->diffForHumans():''}} --}}
                      </p>
                    </td>

                  </tr>
                @endforeach
                </tbody>
              </table>

              <h2 class="my-4"> {{$users->links()}}</h2>
        @else
            <h2 class="self-center inline-block px-4 my-4 text-xl font-semibold leading-loose text-center text-gray-400 bg-white rounded-lg">
              There are no requested registered users yet
            </h2>
        @endif
