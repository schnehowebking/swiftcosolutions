<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompanyFrontendController extends Controller
{
    //
    public function index()
    {
        return view('frontend.company.index');

    }
}
