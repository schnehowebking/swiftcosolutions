

@extends('layouts.auth')
@section('page-title')
    {{__('Login')}}
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
<li class="nav-item">
    <select name="language" id="language" class="lang-dropdown btn btn-primary my-1 me-2" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
        @foreach(App\Models\Utility::languages() as $language)
            <option @if($lang == $language) selected @endif value="{{ route('login',$language) }}">{{Str::upper($language)}}</option>
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
                    <h2 class="mb-3 f-w-600">{{ __('Login') }}</h2>
                </div>
                <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate="" id="form_data">
                    @csrf
                    <div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter Yore Email" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="error invalid-email text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">{{ __('Password') }}</label>
                            <input class="form-control @error('password') is-invalid @enderror" id="password" type="password" name="password" placeholder="Enter Yore Password" required autocomplete="current-password">
                            @error('password')
                            <span class="error invalid-password text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                            @enderror

                            @if (Route::has('password.request'))
                            <div class="mb-2 mt-2">
                                <a href="{{ route('password.request') }}" class="small text-muted text-underline--dashed border-primar">{{ __('Forgot Your Password?') }}</a>
                            </div>
                            @endif
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
                            <button type="submit" class="login-do-btn btn btn-primary btn-block mt-2" tabindex="4">{{ __('Login') }}</button>
                        </div>

                        @if(Utility::getValByName('disable_signup_button')=='on')
                            <p class="my-4 text-center">{{ __("Don't have an account?") }}
                                <a href="{{route('register',$lang)}}" class="my-4 text-primary">{{__('Register')}}</a>
                            </p>
                        @endif
                    </div>
                </form>

        </div>
    </div>
        <div class="col-xl-6 img-card-side">
            <div class="auth-img-content">
                <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid">
                <h3 class="text-white mb-4 mt-5"> {{ __('“Attention is the new currency”') }}</h3>
                <p class="text-white"> {{__('The more effortless the writing looks, the more effort the writer
                    actually put into the process.')}}</p>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
    $(document).ready(function () {
    $("#form_data").submit(function (e) {
        $("#login_button").attr("disabled", true);
        return true;
         });
    });
</script>
