<?php

use Livewire\Volt\Component;
use App\Models\Fee;
use App\Models\Intake;
use App\Models\ClearedStudent;

new class extends Component {
    public $unpaidIntakes;

    public function mount()
    {
        $loggedInUser = auth()->user();

        $unpaidUpIntakesFromFees = Fee::where('user_id', $loggedInUser->id)
            ->where('is_cleared', false)
            ->pluck('intake_id')->toArray();

        $paidUpIntakesFromClearedStudents = ClearedStudent::where('national_id_name', 'like', '%' . $loggedInUser->national_id . '%')
            ->pluck('intake_id')->toArray();

        $unpaidIntakesIds = array_unique(array_diff($unpaidUpIntakesFromFees,$paidUpIntakesFromClearedStudents));
        $this->unpaidIntakes = Intake::whereIn('id', $unpaidIntakesIds)->get();
    }
}; ?>

<div>
    @if($unpaidIntakes->isNotEmpty())
        <p>Exam Results suppressed for session(s):</p>
        <ul>
            @foreach($unpaidIntakes as $intake)
                <li>{{ $intake->title }}</li>
            @endforeach
        </ul>

    @endif
</div>
