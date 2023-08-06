<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Training;
use Illuminate\Http\Request;

class ElearningFrontendController extends Controller
{
    //
    public function index()
    {
        $trainigs = Training::get();
        return view('frontend.elearning.index', compact('trainigs'));
    }

    public function create()
    {
        return view('frontend.elearning.edit');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required'
        ]);
        $res = Training::save_training($request);
        return \back();
    }

    public function show(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        return view('frontend.elearning.show', compact('training'));
    }
}
