
@php
$logo=\App\Models\Utility::get_file('uploads/logo/');
    
@endphp
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{!empty($companySettings['title_text']) ? $companySettings['title_text']->value : config('app.name', 'HRMGO')}} - {{$job->title}}</title>

    <link rel="icon" href="{{$logo.'/'.(isset($companySettings['company_favicon']) && !empty($companySettings['company_favicon'])?$companySettings['company_favicon']->value:'favicon.png')}}" type="image" sizes="16x16">

    <link rel="stylesheet" href="{{ asset('libs/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" id="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
<header class="header header-transparent" id="header-main">

    <nav class="navbar navbar-main navbar-expand-lg navbar-transparent navbar-light bg-white" id="navbar-main">
        <div class="container px-lg-0">
            <a class="navbar-brand mr-lg-5" href="#">
                <img class="hweb" alt="Image placeholder" src="{{$logo.'/'.(isset($companySettings['company_logo']) && !empty($companySettings['company_logo'])?$companySettings['company_logo']->value:'logo-dark.png')}}" id="navbar-logo" style="height: 50px;">
            </a>
            <button class="navbar-toggler pr-0" type="button" data-toggle="collapse" data-target="#navbar-main-collapse" aria-controls="navbar-main-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar-main-collapse">

                <ul class="navbar-nav align-items-lg-center ml-lg-auto">
                    <li class="nav-item">
                        <div class="dropdown global-icon" data-toggle="tooltip" data-original-titla="{{__('Choose Language')}}">
                            <a class="nav-link px-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="0,10">
                                <i class="ti ti-globe-europe"></i>
                                <span class="d-none d-lg-inline-block">{{\Str::upper($currantLang)}}</span>
                            </a>

                            <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                @foreach($languages as $language)
                                    <a class="dropdown-item @if($language == $currantLang) text-danger @endif" href="{{route('job.requirement',[$job->code,$language])}}">{{\Str::upper($language)}}</a>
                                @endforeach
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<div class="main-content">
    <!-- Spotlight -->
    <section class="slice slice-xl" data-offset-top="#header-main">
        <div class="container pt-6">
            <div class="row row-grid justify-content-center">
                <div class="col-lg-8 text-center">
                    <h6 class="text-sm text-uppercase ls-2 text-muted font-weight-700">{{__('Careers')}}</h6>
                    <h2 class="h1 mb-4">{{__('Job openings')}}</h2>
                    <p class="lead lh-180">{{$job->title}}</p>
                    <p class="lead lh-180">
                        @foreach(explode(',',$job->skill) as $skill)
                            <span class="badge bg-primary p-2 px-3 rounded"> {{$skill}}</span>

                        @endforeach
                    </p>
                    <p class="lead lh-180">{{$job->position}} {{__('Position')}}</p>
                    <p class="lead lh-180"><i class="ti ti-map-marker-alt"></i> {{!empty($job->branches)?$job->branches->name:''}} </p>
                   <!--  @if($job->end_date >= date('Y-m-d'))
                        <div class="mt-3">
                            <a href="{{route('job.apply',[$job->code,$currantLang])}}" class="btn btn-primary">
                                <span class="btn-inner--icon"><i class="ti ti-angle-right"></i></span>
                                <span class="btn-inner--text">{{__('Apply now')}}</span>
                            </a>
                        </div>
                    @endif -->
                </div>
            </div>
        </div>
        @if($job->end_date >= date('Y-m-d'))
                        <div class="text-center mt-5">
                            <a href="{{route('job.apply',[$job->code,$currantLang])}}" class="btn btn-primary ">
                                <span class="btn-inner--icon"><i class="ti ti-angle-right"></i></span>
                                <span class="btn-inner--text">{{__('Apply now')}}</span>
                            </a>
                        </div>
                    @endif
    </section>
    <section class="slice slice-lg bg-section-secondary delimiter-top delimiter-bottom">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card shadow">
                        <div class="card-body px-lg-5 py-lg-5">
                            <h4 class="mb-4">{{__('Requirements')}}</h4>
                            
                            {!! $job->requirement !!}
                        </div>
                    </div>
                    <div class="card shadow mt-5">
                        <div class="card-body px-lg-5 py-lg-5">
                            <h4 class="mb-4">{{__('Description')}}</h4>
                            {!! $job->description !!}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </section>

</div>

<footer id="footer-main">
    <div class="footer-dark">
        <div class="container">
            <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                <div class="col-md-6">
                    <div class="copyright text-sm font-weight-bold text-center text-md-left">
                        {{!empty($companySettings['footer_text']) ? $companySettings['footer_text']->value : ''}}
                    </div>
                </div>
                <div class="col-md-6">
                    <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-dribbble"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-instagram"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-github"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_blank">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<script src="{{ asset('js/site.core.js') }}"></script>
<script src="{{ asset('js/autosize.min.js') }}"></script>
<script src="{{ asset('js/site.js') }}"></script>
<script src="{{ asset('js/demo.js') }} "></script>
</body>

</html>
