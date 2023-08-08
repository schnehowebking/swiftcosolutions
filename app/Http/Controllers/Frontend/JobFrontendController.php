<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class JobFrontendController extends Controller
{
    //
    public function index()
    {
        $jobs = Job::get();
        return view('frontend.job.index', \compact('jobs'));
    }

    public function show(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        return view('frontend.job.job_details', compact('job'));
    }
}
