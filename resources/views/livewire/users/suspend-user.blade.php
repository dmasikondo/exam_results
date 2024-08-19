<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Computed;
use App\Models\User;

new class extends Component {

    #[Locked]
    public $slug;

    public $user;

    public $isSuspended = false;

    public function suspension()
    {
        $this->isSuspended = !$this->isSuspended;
        $this->user->update(['is_suspended' =>$this->isSuspended]);

        $this->dispatch('user-suspension');
    }

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->user = User::where('slug', $slug)->firstOrFail();

        $this->isSuspended = $this->user->is_suspended;


    }
}; ?>

<div>
    <div class="flex items-center gap-4">
        <x-primary-button class="text-xs" wire:click='suspension' wire:confirm.prompt="Are you sure you want to change suspension state of user? \n\nType YES in capital letters to confirm|YES">
            {{ $isSuspended? 'UnSuspend?': 'Suspend?' }}

        </x-primary-button>

        <x-action-message class="me-3" on="user-suspension">
            {{ __('Done.') }}
        </x-action-message>
    </div>
</div>
