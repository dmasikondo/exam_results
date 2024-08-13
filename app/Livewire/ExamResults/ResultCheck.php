<?php

namespace App\Livewire\ExamResults;

use App\Models\Intake;
use Livewire\Component;

class ResultCheck extends Component
{
    public $intakes;

    public function render()
    {
        $this->intakes = Intake::orderBy('id')->get();
        return view('livewire.examResults.result-check');
    }

}
