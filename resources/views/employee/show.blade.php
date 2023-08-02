@extends('layouts.admin')

@section('page-title')
    {{__('Employee')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ url('employee') }}">{{ __('Employee') }}</a></li>
    <li class="breadcrumb-item">{{ __('Manage Employee') }}</li>
@endsection

@section('action-button')
    <div class="float-end">
    @can('edit employee')
        <a href="{{route('employee.edit',\Illuminate\Support\Facades\Crypt::encrypt($employee->id))}}" data-bs-toggle="tooltip" title="{{__('Edit')}}"class="btn btn-sm btn-primary">
            <i class="ti ti-pencil"></i>
        </a>
    @endcan
    </div>
    <div class="text-end mb-3">
        <div class="d-flex justify-content-end drp-languages">
            <ul class="list-unstyled mb-0 m-2">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="drp-text hide-mob text-primary"> {{__('Joining Letter')}}
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{route('joiningletter.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>    
                    
                        <a href="{{route('joininglatter.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>  
                    </div>
                </li>
            </ul>
            <ul class="list-unstyled mb-0 m-2">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="drp-text hide-mob text-primary"> {{__('Experience Certificate')}}
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{route('exp.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>    
                    
                        <a href="{{route('exp.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>  
                    </div>
                </li>
            </ul>
            <ul class="list-unstyled mb-0 m-2">
                <li class="dropdown dash-h-item drp-language">
                    <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <span class="drp-text hide-mob text-primary"> {{__('NOC')}}
                            <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                    </a>
                    <div class="dropdown-menu dash-h-dropdown">
                        <a href="{{route('noc.download.pdf',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('PDF')}}</a>    
                    
                        <a href="{{route('noc.download.doc',$employee->id)}}" class=" btn-icon dropdown-item" data-bs-toggle="tooltip" data-bs-placement="top"  target="_blanks"><i class="ti ti-download ">&nbsp;</i>{{__('DOC')}}</a>  
                    </div>
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="row">
            <div class="col-sm-12 col-md-6">

                    <div class="card " style="height: 200px;">
                    <div class="card-body employee-detail-body fulls-card">
                    <h5>{{__('Personal Detail')}}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Employee ID')}} : </strong>
                                    <span>{{$employeesId}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">{{__('Name')}} :</strong>
                                    <span>{{$employee->name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">{{__('Email')}} :</strong>
                                    <span>{{$employee->email}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Date of Birth')}} :</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->dob)}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Phone')}} :</strong>
                                    <span>{{$employee->phone}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Address')}} :</strong>
                                    <span>{{$employee->address}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Salary Type')}} :</strong>
                                    <span>{{!empty($employee->salaryType)?$employee->salaryType->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Basic Salary')}} :</strong>
                                    <span>{{$employee->salary}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="col-sm-12 col-md-6">

                    <div class="card " style="height:200px">
                    <div class="card-body employee-detail-body fulls-card">
                        <h5>{{__('Company Detail')}}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Branch')}} : </strong>
                                    <span>{{!empty($employee->branch)?$employee->branch->name:''}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">{{__('Department')}} :</strong>
                                    <span>{{!empty($employee->department)?$employee->department->name:''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Designation')}} :</strong>
                                    <span>{{!empty($employee->designation)?$employee->designation->name:''}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Date Of Joining')}} :</strong>
                                    <span>{{\Auth::user()->dateFormat($employee->company_doj)}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6">

                    <div class="card " style="height:200px">
                    <div class="card-body employee-detail-body fulls-card">
                        <h5>{{__('Document Detail')}}</h5>
                        <hr>
                        <div class="row">
                            @php
                                $employeedoc = $employee->documents()->pluck('document_value','document_id');
                                $logo=\App\Models\Utility::get_file('uploads/document');
                            @endphp
                            @if(!$documents->isEmpty())
                            @foreach($documents as $key=>$document)
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{$document->name }} : </strong>
                                    <span><a href="{{ (!empty($employeedoc[$document->id])?$logo.'/'.$employeedoc[$document->id]:'') }}" target="_blank">{{ (!empty($employeedoc[$document->id])?$employeedoc[$document->id]:'') }}</a></span>
                                </div>
                            </div>
                            @endforeach
                            @else
                              <div class="text-center">
                                No Document Type Added.!
                              </div>
                            @endif

                        </div>
                    </div>
                    </div>
            </div>
            <div class="col-sm-12 col-md-6">

                    <div class="card " style="height:200px">
                    <div class="card-body employee-detail-body fulls-card">
                    <h5>{{__('Bank Account Detail')}}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Account Holder Name')}} : </strong>
                                    <span>{{$employee->account_holder_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm font-style">
                                    <strong class="font-bold">{{__('Account Number')}} :</strong>
                                    <span>{{$employee->account_number}}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Bank Name')}} :</strong>
                                    <span>{{$employee->bank_name}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Bank Identifier Code')}} :</strong>
                                    <span>{{$employee->bank_identifier_code}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Branch Location')}} :</strong>
                                    <span>{{$employee->branch_location}}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info text-sm">
                                    <strong class="font-bold">{{__('Tax Payer Id')}} :</strong>
                                    <span>{{$employee->tax_payer_id}}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
