@extends('layouts.admin')
@section('page-title')
    {{ $emailTemplate->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Email Template') }}</li>
@endsection
@push('pre-purpose-css-page')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-bs4.css')}}">
@endpush
@push('script-page')
<script src="{{asset('css/summernote/summernote-bs4.js')}}"></script>
<script src="{{asset('assets/js/plugins/tinymce/tinymce.min.js')}}"></script>
<script>
    if ($(".pc-tinymce-2").length) {
        tinymce.init({
            selector: '.pc-tinymce-2',
            height: "400",
            content_style: 'body { font-family: "Inter", sans-serif; }'
        });
    }
</script>
@endpush

@section('action-button')
<div class="row">
               
    <div class="text-end mb-3">
        {{Form::model($currEmailTempLang, array('route' => array('email_template.update', $currEmailTempLang->parent_id), 'method' => 'PUT')) }}
         {{-- @dd($currEmailTempLang->parent_id) --}}

        <div class="text-end">
            <div class="d-flex justify-content-end drp-languages">
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            {{-- <i class="ti ti-world nocolor"></i> --}}
                            <span
                                class="drp-text hide-mob text-primary">{{ Str::upper($currEmailTempLang->lang) }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end"
                             aria-labelledby="dropdownLanguage">
                            @foreach ($languages as $lang)
                                <a href="{{ route('manage.email.language', [$emailTemplate->id, $lang]) }}"
                                   class="dropdown-item {{ $currEmailTempLang->lang == $lang ? 'text-primary' : '' }}">{{ Str::upper($lang) }}</a>
                            @endforeach
                        </div>
                    </li>
                </ul>
                <ul class="list-unstyled mb-0 m-2">
                    <li class="dropdown dash-h-item drp-language">
                        <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                           href="#" role="button" aria-haspopup="false" aria-expanded="false"
                           id="dropdownLanguage">
                            <span
                                class="drp-text hide-mob text-primary">{{ __('Template: ') }}{{ $emailTemplate->name }}</span>
                            <i class="ti ti-chevron-down drp-arrow nocolor"></i>
                        </a>
                        <div class="dropdown-menu dash-h-dropdown dropdown-menu-end" aria-labelledby="dropdownLanguage">
                            @foreach ($EmailTemplates as $EmailTemplate)
                                <a href="{{ route('manage.email.language', [$EmailTemplate->id,(Request::segment(3)?Request::segment(3):\Auth::user()->lang)]) }}"
                                   class="dropdown-item {{$emailTemplate->name == $EmailTemplate->name ? 'text-primary' : '' }}">{{ $EmailTemplate->name }}
                                </a>
                            @endforeach
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
        
@endsection


@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body ">
                <h5 class= "font-weight-bold pb-3">{{ __('Placeholders') }}</h5>

                    <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header card-body">
                                    <div class="row text-xs">

                                        @if($emailTemplate->slug=='new_user')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Create User')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Email')}} : <span class="pull-right text-primary">{email}</span></p>
                                                <p class="col-4">{{__('Password')}} : <span class="pull-right text-primary">{password}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='new_employee')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Create')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{employee_name}</span></p>
                                                <p class="col-4">{{__('Password')}} : <span class="pull-right text-primary">{employee_password}</span></p>
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{employee_email}</span></p>
                                                <p class="col-4">{{__('Employee Branch')}} : <span class="pull-right text-primary">{employee_branch}</span></p>
                                                <p class="col-4">{{__('Employee Department')}} : <span class="pull-right text-primary">{employee_department}</span></p>
                                                <p class="col-4">{{__('Employee Designation')}} : <span class="pull-right text-primary">{employee_designation}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='new_payroll')
                                            <div class="row">
                                                
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Payroll Create')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('Employee Email')}} : <span class="pull-right text-primary">{payslip_email}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{name}</span></p>
                                                <p class="col-4">{{__('Salary Month')}} : <span class="pull-right text-primary">{salary_month}</span></p>
                                                <p class="col-4">{{__('URL')}} : <span class="pull-right text-primary">{url}</span></p>
    
                                            </div>
                                        @elseif($emailTemplate->slug=='new_ticket')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Ticket Create')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Ticket Title')}} : <span class="pull-right text-primary">{ticket_title}</span></p>
                                                <p class="col-4">{{__('Ticket Employee Name')}} : <span class="pull-right text-primary">{ticket_name}</span></p>
                                                <p class="col-4">{{__('Ticket Code')}} : <span class="pull-right text-primary">{ticket_code}</span></p>
                                                <p class="col-4">{{__('Ticket Description')}} : <span class="pull-right text-primary">{ticket_description}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='new_award')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Award Create')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{award_name}</span></p>
                                            
                                            </div>
                                        @elseif($emailTemplate->slug=='employee_transfer')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Transfer')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{transfer_name}</span></p>
                                                <p class="col-4">{{__('Transfer Date')}} : <span class="pull-right text-primary">{transfer_date}</span></p>
                                                <p class="col-4">{{__('Transfer Department')}} : <span class="pull-right text-primary">{transfer_department}</span></p>
                                                <p class="col-4">{{__('Transfer Branch')}} : <span class="pull-right text-primary">{transfer_branch}</span></p>
                                                <p class="col-4">{{__('Transfer Desciption')}} : <span class="pull-right text-primary">{transfer_description}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='employee_resignation')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Resignation')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee Name')}} : <span class="pull-right text-primary">{assign_user}</span></p>
                                                <p class="col-4">{{__('Last Working Date')}} : <span class="pull-right text-primary">{resignation_date}</span></p>
                                                <p class="col-4">{{__('Resignation Date')}} : <span class="pull-right text-primary">{notice_date}</span></p>
                                            </div>
                                        @elseif($emailTemplate->slug=='employee_trip')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Trip')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee ')}} : <span class="pull-right text-primary">{employee_trip_name}</span></p>
                                                <p class="col-4">{{__('Purpose of Trip')}} : <span class="pull-right text-primary">{purpose_of_visit}</span></p>
                                                <p class="col-4">{{__('Start Date')}} : <span class="pull-right text-primary">{start_date}</span></p>
                                                <p class="col-4">{{__('End Date')}} : <span class="pull-right text-primary">{end_date}</span></p>
                                                <p class="col-4">{{__('Country')}} : <span class="pull-right text-primary">{place_of_visit}</span></p>
                                                <p class="col-4">{{__('Description')}} : <span class="pull-right text-primary">{trip_description}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='employee_promotion')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Promotion')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee')}} : <span class="pull-right text-primary">{employee_promotion_name}</span></p>
                                                <p class="col-4">{{__('Designation')}} : <span class="pull-right text-primary">{promotion_designation}</span></p>
                                                <p class="col-4">{{__('Promotion Title')}} : <span class="pull-right text-primary">{promotion_title}</span></p>
                                                <p class="col-4">{{__('Promotion Date')}} : <span class="pull-right text-primary">{promotion_date}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='employee_complaints')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Complaints')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee')}} : <span class="pull-right text-primary">{employee_complaints_name}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='employee_warning')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Warning')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee')}} : <span class="pull-right text-primary">{employee_warning_name}</span></p>
                                                <p class="col-4">{{__('Subject')}} : <span class="pull-right text-primary">{warning_subject}</span></p>
                                                <p class="col-4">{{__('Description')}} : <span class="pull-right text-primary">{warning_description}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='employee_termination')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Employee Termination')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Employee')}} : <span class="pull-right text-primary">{employee_termination_name}</span></p>
                                                <p class="col-4">{{__('Notice Date')}} : <span class="pull-right text-primary">{notice_date}</span></p>
                                                <p class="col-4">{{__('Termination Date')}} : <span class="pull-right text-primary">{termination_date}</span></p>
                                                <p class="col-4">{{__('Termination Type')}} : <span class="pull-right text-primary">{termination_type}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='leave_status')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Leave Status')}}</h6> --}}
                                                <p class="col-4">{{__('App Name')}} : <span class="pull-end text-primary">{app_name}</span></p>
                                                <p class="col-4">{{__('Company Name')}} : <span class="pull-right text-primary">{company_name}</span></p>
                                                <p class="col-4">{{__('App Url')}} : <span class="pull-right text-primary">{app_url}</span></p>
                                                <p class="col-4">{{__('Leave email')}} : <span class="pull-right text-primary">{leave_email}</span></p>
                                                <p class="col-4">{{__('Leave Status')}} : <span class="pull-right text-primary">{leave_status}</span></p>
                                                <p class="col-4">{{__('Employee')}} : <span class="pull-right text-primary">{leave_status_name}</span></p>
                                                <p class="col-4">{{__('Leave Reason')}} : <span class="pull-right text-primary">{leave_reason}</span></p>
                                                <p class="col-4">{{__('Leave Start Date')}} : <span class="pull-right text-primary">{leave_start_date}</span></p>
                                                <p class="col-4">{{__('Leave End Date')}} : <span class="pull-right text-primary">{leave_end_date}</span></p>
                                                <p class="col-4">{{__(' Total Days')}} : <span class="pull-right text-primary">{total_leave_days}</span></p>
                                            </div>
                                            @elseif($emailTemplate->slug=='contract')
                                            <div class="row">
                                                {{-- <h6 class="font-weight-bold pb-3">{{__('Contract')}}</h6> --}}
                                                <p class="col-4">{{__('Contract Subject')}} : <span class="pull-right text-primary">{contract_subject}</span></p>
                                                <p class="col-4">{{__('Contract Employee')}} : <span class="pull-right text-primary">{contract_employee}</span></p>
                                                <p class="col-4">{{__('Contract Start Date')}} : <span class="pull-right text-primary">{contract_start_date}</span></p>
                                                <p class="col-4">{{__('Contract End Date')}} : <span class="pull-right text-primary">{contract_end_date}</span></p>
                                            </div>
                                            @endif
                                    </div>
                                
                                </div>
                            </div>
                    </div>
                    {{-- <div class="card"> --}}
                    {{Form::model($currEmailTempLang, array('route' => array('email_template.update', $currEmailTempLang->parent_id), 'method' => 'PUT')) }}
                        <div class="row">
                            <div class="form-group col-6">
                                {{ Form::label('subject', __('Subject'), ['class' => 'col-form-label text-dark']) }}
                                {{ Form::text('subject', null, ['class' => 'form-control font-style', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-md-6">
                                {{ Form::label('from', __('From'), ['class' => 'col-form-label text-dark']) }}
                                {{ Form::text('from', $emailTemplate->from, ['class' => 'form-control font-style', 'required' => 'required']) }}
                            </div>
                            <div class="form-group col-12">
                                {{Form::label('content',__('Email Message'),['class'=>'form-label text-dark'])}}
                                {{Form::textarea('content',$currEmailTempLang->content,array('class'=>'pc-tinymce-2','required'=>'required'))}}
                            </div>
                        </div>
                        <hr>
                        <div class="col-md-12 text-end">
                            {{Form::hidden('lang',null)}}
                            <input type="submit" value="{{__('Save Changes')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                        </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection