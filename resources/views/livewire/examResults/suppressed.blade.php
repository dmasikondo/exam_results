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
        <div class="mt-8 space-y-4">
            <h2 class="font-semibold text-4xl text-gray-300 tracking-wide">
                Exam Results Suppressed!</h2>

            <div class="font-thin text-lg">
                <ul>
                    <p>For the Following sessions:</p>
                  @foreach($unpaidIntakes as $intake)
                    <x-list.section>{{$intake->title}}</x-list.section>
                  @endforeach
                </ul>
                <p>
                  To view your Harare Polytechnic's Hexco Examination Results ...
                </p>
            </div>

            <div class="mt-4 text-gray-500">
                You must be fully paid up to Harare Polytechnic (with $0 balance or <span class="text-red-700">$-</span>) in your college account and be cleared by the Accounts Department.
            </div>
        </div>

        <div class="my-2 py-12">
            <a href="{{route('proof-of-payment')}}">
            <button  class="float-right p-2 rounded-lg bg-indigo-500 text-white hover:text-indigo-500 hover:bg-white hover:border-4 hover:border-indigo-500" >

                Send Proof of Payment
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="inline h-6 w-6">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
            </button>
            </a>

        </div>
    @endif
</div>
