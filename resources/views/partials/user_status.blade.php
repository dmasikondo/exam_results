                    @if(!$user->must_reset && !$user->is_suspended && !is_null($user->email_verified_at))
                      <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full">
                        Active
                        <x-icon name="check-circle" class="inline w-4 h-4"/>
                      </span>
                    @elseif(!$user->must_reset && $user->is_suspended && is_null($user->email_verified_at))
                      <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                        Suspended and Must verify email
                        <x-icon name="exclamation" class="inline w-4 h-4"/>
                      </span>
                    @elseif(!$user->must_reset && !$user->is_suspended && is_null($user->email_verified_at))
                      <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                        Must verify email
                        <x-icon name="exclamation" class="inline w-4 h-4"/>
                      </span>
                     @elseif($user->is_suspended && $user->must_reset)
                      <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                        Suspended and deactivated
                        <x-icon name="exclamation" class="inline w-4 h-4"/>
                      </span>
                     @elseif($user->must_reset)
                      <span class="px-2 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full">
                        Must Activate
                      </span>
                     @elseif($user->is_suspended)
                      <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full">
                        Suspended
                        <x-icon name="exclamation" class="inline w-4 h-4"/>
                      </span>

                    @endif
