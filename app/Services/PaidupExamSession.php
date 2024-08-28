<?php

namespace App\Services;

use App\Models\ClearedStudent;
use App\Models\User;

class PaidupExamSession
{
    public function paidUpIntakesArray(User $user): array
    {
        /**
         * return an array of the intakes that a user is paid for
         * as provided by fees table and uploaded csv file in cleared_students table
         */


        // retrieve the paid up intakes for the user from fees table
        $paidUpIntakesFromFees = $user->fees->where('is_cleared', true)->pluck('intake_id')->toArray();

        // Retrieve the intake IDs that the user paid up for, from the cleared_students table based on national_id_name
        $paidUpIntakesFromClearedStudents = ClearedStudent::where('national_id_name', 'like', '%' . $user->national_id . '%')
            ->pluck('intake_id')
            ->toArray();

        // Merge the intake IDs from both sources to get all paid up intake IDs
        $paidUpIntakes = array_unique(array_merge($paidUpIntakesFromFees, $paidUpIntakesFromClearedStudents));
        return $paidUpIntakes;
    }
}
