<?php

use Livewire\Volt\Component;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;
use App\Models\Intake;

new class extends Component {

    public $examSession;
    public $intakeId;
    public $allIntakeTitles;
    public $sessionName;
    public $showIntakeId = false;

    public function intakeChecker()
    {
        try {
            $this->validate([
                'examSession' => ['required'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('examSession');

            throw $e;
        }

        $intake = Intake::firstOrNew(['title' => $this->examSession]);

        $intake->label = $intake->title;
        $intake->save();
        $this->reset('examSession');
       // $this->dispatch('intake-updated');

        $this->intakeId = $intake->id;
        $this->sessionName = $intake->title;
        $this->showIntakeId = true;

    }

    public function hideIntakeId()
    {
        $this->showIntakeId = false;
    }


    // #[On('intake-updated')]
    public function mount()
    {
        $this->allIntakeTitles = Intake::orderBy('created_at', 'desc')->pluck('title')->all();
    }
}; ?>

<div>
    <div class="my-4">
        <h2 class="my-2 font-semibold">
            Choose or create exam session from the list
        </h2>
        <form wire:submit="intakeChecker">
            <div class="relative">
                <x-input-label for="exam-session" :value="__('Exam Session')"/>

                <input list="exam-sessions" name="exam-session" id="exam-session" wire:model='examSession' class="p-2 border rounded-md focus:outline-none focus:ring focus:border-blue-300" wire:keydown='hideIntakeId'>
                <x-input-error :messages="$errors->get('examSession')" class="mt-2"/>
                <datalist id="exam-sessions" class="absolute z-10 w-40 mt-1 bg-white border rounded-md shadow-lg">
                    @foreach($allIntakeTitles  as $title)
                        <option value="{{$title}}">
                            <option value=""></option>
                    @endforeach
                </datalist>
                <x-primary-button class="ms-3">
                    {{ __('Check Intake_id') }}
                </x-primary-button>
            </div>

        </form>
      @if($showIntakeId)
        <p wire:transition>
            <span class="font-bold">Note:</span> The intake_id that you should enter on your csv file should be <span class="font-extrabold">{{$intakeId}}</span> for Exam session: <span class="font-bold">{{$sessionName}}</span>
        </p>
      @endif
    </div>

</div>
