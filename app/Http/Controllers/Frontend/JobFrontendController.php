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

    public function getJobList()
    {
        $jobs = Job::get();
        return view('frontend.job.job_listing', \compact('jobs'));
    }

    public function create()
    {
        return view('frontend.job.edit');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $res = Job::save_job($request);
        return back();
    }

    public function show(Request $request, $id)
    {
        $job = Job::findOrFail($id);
        return view('frontend.job.job_details', compact('job'));
    }
}
