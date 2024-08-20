<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FeeController extends Controller
{
    public function uploadcsv()
    {
        Gate::authorize('create', Fee::class);
        return view('fees.upload-csv');
    }
}
