<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $national_id = '';
    public string $phone_number = '';
    public string $surname = '';
    public string $names = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->national_id = Auth::user()->national_id;
        $this->second_name = Auth::user()->second_name;
        //$this->names = Auth::user()->names;

        // Check if phone_number be null before assignin' a value
        $userPhoneNumber = Auth::user()->phone_number;
        $this->phone_number = $userPhoneNumber ?? ''; // Assign an empty string if phone number be null
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'national_id' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($user->id), ],
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^(0|\+)[0-9]{6,19}$/', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        // if ($user->isDirty('email')) {
        //     $user->email_verified_at = null;
        // }

        $user->save();

        $this->dispatch('profile-updated', second_name: $user->second_name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    /* public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }*/

}; ?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div class="relative mt-4">
            <x-text-input wire:model="national_id" id="national_id" name="national_id" type="text" class="block w-full mt-1" required autofocus autocomplete="national_id" placeholder="national_id" />
            <x-input-label for="national_id" :value="__('National ID')" />
            <x-input-error class="mt-2" :messages="$errors->get('national_id')" />
        </div>

        <div class="relative mt-4">
            <x-text-input wire:model="phone_number" id="phone_number" name="phone_number" type="tel" class="block w-full mt-1" required  placeholder="Phone Number"/>
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="mt-2 text-sm text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
