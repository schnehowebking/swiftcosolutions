


@extends('layouts.auth')
@section('page-title')
    {{__('Forgot Password')}}
@endsection
@php
    // $logo=asset(Storage::url('uploads/logo/'));
$logo=\App\Models\Utility::get_file('uploads/logo/');

@endphp

@push('custom-scripts')
@if(env('RECAPTCHA_MODULE') == 'yes')
        {!! NoCaptcha::renderJs() !!}
@endif
@endpush

@section('language-bar')
{{-- @dd($lang) --}}
    <li class="nav-item">
        <select name="language" id="language" class="lang-dropdown btn btn-primary my-1 me-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            @foreach(App\Models\Utility::languages() as $language)
                <option @if($lang == $language) selected @endif value="{{ route('password.request',$language) }}">{{Str::upper($language)}}</option>
            @endforeach
        </select>
    </li>
@endsection

@section('content')

<div class="card">
    <div class="row align-items-center text-start">
        <div class="col-xl-6">
            <div class="card-body">
                <div class="">
                    <h2 class="mb-3 f-w-600">{{ __('Forgot Password') }}</h2>
                    {{-- @dd(session('status')) --}}
                    @if (session('status'))
                        <div class="alert alert-primary">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('password.email') }}" id="form_data">
                    @csrf
                    <div class="">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="Enter Yore Email" autocomplete="email" autofocus>
                            {{-- @error('email')
                            <span class="error invalid-email text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror --}}                            
                            @foreach ($errors->all() as $key => $error)
                                <span class="error invalid-email text-danger" role="alert">
                                    <small>{{ $error }}</small>
                                </span>                                
                            @endforeach
                        </div>                      
                        @if(env('RECAPTCHA_MODULE') == 'yes')
                            <div class="form-group col-lg-12 col-md-12 mt-3">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                <span class="error small text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        @endif
                            
                        <div class="d-grid">
                            <button class="btn btn-primary btn-submit btn-block mt-2">{{ __('Send Password Reset Link') }}  </button>
                        </div>
                        <p class="my-4 text-center">{{__('Back to ')}}
                            <a href="{{route('login',$lang)}}" class="my-4 text-primary">{{ __('Login') }}</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xl-6 img-card-side">
            <div class="auth-img-content">
                <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid">
                <h3 class="text-white mb-4 mt-5">“Attention is the new currency”</h3>
                <p class="text-white">The more effortless the writing looks, the more effort the writer
                    actually put into the process.</p>
            </div>
        </div>
    </div>
</div>
@endsection
