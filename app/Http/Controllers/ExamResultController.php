<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\ClearedStudent;
use App\Models\Intake;
use App\Models\Result;
use App\Services\PaidupExamSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ExamResultController extends Controller
{

    public function __construct(private PaidupExamSession $paidUpExamSession)
    {

    }
    public function getLatestIntakeResultsForPaidUpUser()
    {
        $loggedInUser = auth()->user();

        Gate::authorize('view', Result::class);

        $paidUpIntakes = $this->paidUpExamSession->paidUpIntakesArray($loggedInUser);

        $latestIntakeResults = $loggedInUser->results()
            ->whereIn('intake_id', $paidUpIntakes)
            ->with('intake')
            ->latest()
            ->get()
            ->groupBy('intake_id');

        if (!$latestIntakeResults->isEmpty()) {
            $ArrayOflatestIntakeResults = $latestIntakeResults->toArray();
            $leadingResult = reset($ArrayOflatestIntakeResults)[0];
            $candidateNumber = $leadingResult['candidate_number'];
        }
        else{
            $leadingResult = NULL;
            $candidateNumber = '';
        }


        return view('examResults.myresults',[
            'examResults'=>$latestIntakeResults,
            'leadingResults' =>$leadingResult,
            'candidateNumber' =>$candidateNumber,
        ]);
    }

    public function checkMyresults(Request $request)
    {
        $loggedInUser = auth()->user();

        Gate::authorize('view', Result::class);

        $paidUpIntakes = $this->paidUpExamSession->paidUpIntakesArray($loggedInUser);

        //validate, check if there are results with the given candidate number matching first name and surname

        $request->validate([
            'candidate_number' => ['required', 'string', 'max:255', Rule::exists('results')
                ->where('names',$loggedInUser->first_name)
                ->where('surname',$loggedInUser->second_name)
                ->where('intake_id',request()->exam_session)],
            'exam_session' => ['required'],
        ],
            ['candidate_number.exists'=>'No results for selected Exam Session matching your Candidate No.'],
        );
            //declare variables from form inputs
            $candidate_number = request()->candidate_number;
            $exam_session = Intake::where('id',request()->exam_session)->first();
            $exam_session = $exam_session->label;

        //check if the results exist
        $exam_search_outcome = Result::where('candidate_number',request()->candidate_number)
                                ->where('names',$loggedInUser->first_name)
                                ->where('surname',$loggedInUser->second_name)
                                ->where('intake_id',request()->exam_session);

        //if the results were not yet assigned to the user then do so
        if($exam_search_outcome->whereNull('users_id')->count()>0)
        {
            foreach($exam_search_outcome->whereNull('users_id')->get() as $exam_result){
                $exam_result->update(['users_id'=>$loggedInUser->id]);
            }
             //create a record in fees clearance
            $uniq_slug = $loggedInUser->second_name.uniqid();
            $loggedInUser->fees()->create(['intake_id'=>request()->exam_session,'cleared_at'=>NULL,'slug'=>$uniq_slug]);

        }


        $searchedIntakeResults = Result::where('candidate_number',request()->candidate_number)
        ->where('names',$loggedInUser->first_name)
        ->where('surname',$loggedInUser->second_name)
        ->where('intake_id',request()->exam_session)
        ->whereIn('intake_id', $paidUpIntakes)
        ->get()
        ->groupBy('intake_id');

        if (!$searchedIntakeResults->isEmpty()) {
        $ArrayOfSearchedIntakeResults = $searchedIntakeResults->toArray();
        $leadingResult = reset($ArrayOfSearchedIntakeResults)[0];
        }

        else{
            $leadingResult = NULL;
        }

        session()->flash('message', "Scroll down for results of Candidate No. $candidate_number for $exam_session ");
        $array = [$searchedIntakeResults];

        return view('examResults.checked-results',[
            'examResults'=>$searchedIntakeResults,
            'leadingResults' =>$leadingResult,
            'candidateNumber' =>$candidate_number,
        ]);

    }


    public function uploadCsv()
    {
        Gate::authorize('create', Result::class);
        return view('examResults.upload-csv');
    }

}
