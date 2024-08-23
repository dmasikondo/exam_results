<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
//use App\Models\User;
use App\Models\Result;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\RedirectRouteTrait;

new #[Layout('layouts.guest')] class extends Component
{
    use RedirectRouteTrait;

    public string $surname = '';
    public string $names = '';
    public string $candidate_number;
    public string $national_id;
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'surname' => ['required', 'string', 'max:255', Rule::exists('results')
                ->where('names', $this->names)
                ->where('candidate_number',$this->candidate_number)],
            'names' => ['required', 'string', 'max:255'],
            'candidate_number' => ['required', 'string', 'max:255','exists:results,candidate_number'],
            'national_id' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $uuid = Str::uuid();
        $slug=$this->surname.$uuid;
        $uniq_slug = $slug.uniqid();
        $validated['slug']= $uniq_slug;
        $validated = array_merge($validated, [
            'second_name' => $validated['surname'],
            'first_name' => $validated['names'],
        ]);
        unset($validated['surname']); // Remove the 'surname' field
        unset($validated['names']);
        unset($validated['candidate_number']);
        $validated['password'] = Hash::make($validated['password']);

        DB::transaction(function()use ($validated, $uniq_slug){
            DB::beginTransaction(); // Set a savepoint within the transaction
            try{
                $user = User::create($validated);
                $user->fees()->create(['intake_id'=>1,'cleared_at'=>null,'slug'=>$uniq_slug]);
                $user->students()->create(['user_id'=> $user->id]);
                Result::where('candidate_number',$this->candidate_number)->update(['users_id'=>$user->id]);


                DB::commit(); // If all operations succeed, commit the transaction
                Auth::login($user);
                event(new Registered($user));
            }
            catch (\Exception $e) {
                DB::rollBack(); // If an error occurs, roll back to the savepoint
            }
        });

        $this->redirect(route($this->redirectToRoute(), absolute: false), navigate: true);

    }

    }
; ?>

<div>
    <form wire:submit="register">
        <!-- Candidate No. -->
        <div class="relative mt-4">
            <x-text-input wire:model="candidate_number" id="candidate_number" class="block w-full mt-1" type="text" name="candidate_number" required autofocus autocomplete="name" placeholder="Candiate Number" />
            <x-input-label for="candidate_number" :value="__('Candidate Number')" />
            <x-input-error :messages="$errors->get('candidate_number')" class="mt-2" />
        </div>
        <!-- Surname -->
        <div class="relative mt-4">
            <x-text-input wire:model="surname" id="surname" class="block w-full mt-1" type="text" name="surname" required autofocus autocomplete="Surname" placeholder="Surname" />
            <x-input-label for="surname" :value="__('Surname')" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>
        <!-- Names -->
        <div class="relative mt-4">
            <x-text-input wire:model="names" id="names" class="block w-full mt-1" type="text" name="names" required autofocus autocomplete="names" placeholder="Name(s)s" />
            <x-input-label for="names" :value="__('Name(s)')" />
            <x-input-error :messages="$errors->get('names')" class="mt-2" />
        </div>

        <!-- National Id -->
        <div class="relative mt-4">
            <x-text-input wire:model="national_id" id="national_id" class="block w-full mt-1" type="text" name="national_id" required autofocus autocomplete="names" placeholder="National ID" />
            <x-input-label for="national_id" :value="__('National ID')" />
            <x-input-error :messages="$errors->get('national_id')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="relative mt-4">
            <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autocomplete="username" placeholder="Email" />
            <x-input-label for="email" :value="__('Email')" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative mt-4">

            <x-text-input wire:model="password" id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />

            <x-input-label for="password" :value="__('Password')" />
        </div>

        <!-- Confirm Password -->
        <div class="relative mt-4">

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Confirm Password" />

            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>

            <x-primary-button class="ms-4" title="home">
                <a href="/">
                    <x-icon name="home" class="w-5 h-5"/>
                </a>
            </x-primary-button>
        </div>
    </form>
</div>
