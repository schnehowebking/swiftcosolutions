@extends('layouts.admin')
@push('script-page')
    <script type="text/javascript">

        $(document).on("click", ".email-template-checkbox", function () {
            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {_token: $('meta[name="csrf-token"]').attr('content'), status: chbox.val()},
                type: 'post',
                success: function (response) {
                    if (response.is_success) {
                        toastr('Success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        toastr('Error', response.error, 'error');
                    }
                },
                error: function (response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        toastr('Error', response.error, 'error');
                    } else {
                        toastr('Error', response, 'error');
                    }
                }
            })
        });

    </script>
@endpush
@section('page-title')
    @if(\Auth::user()->type=='company')
        {{__('Email Notification')}}
    @else
        {{__('Email Templates')}}
    @endif
@endsection
@section('title')
    <div class="d-inline-block">
        @if(\Auth::user()->type=='company')
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Email Notification')}}</h5>
        @else
            <h5 class="h4 d-inline-block font-weight-400 mb-0">{{__('Email Templates')}}</h5>
        @endif
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Dashboard')}}</a></li>
    @if(\Auth::user()->type=='company')
        <li class="breadcrumb-item active" aria-current="page">{{__('Email Notification')}}</li>
    @else
        <li class="breadcrumb-item active" aria-current="page">{{__('Email Template')}}</li>
    @endif
@endsection
@section('action-btn')
@endsection
@section('content')
    {{-- <div class="card">
        <div class="table-responsive">
            <table class="table align-items-center" id="myTable">
                <thead>
                <tr>
                    <th scope="col" class="sort" data-sort="name"> {{__('Name')}}</th>
                    @if(\Auth::user()->type=='company')
                        <th class="text-right">{{__('On / Off')}}</th>
                    @else
                        <th class="text-right">{{__('Action')}}</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach ($EmailTemplates as $EmailTemplate)
                    <tr>
                        <td>{{ $EmailTemplate->name }}</td>
                        <td>
                            @if(\Auth::user()->type=='super admin')
                                <a href="{{ route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang]) }}" class="action-item mr-2 float-right" data-toggle="tooltip" title="{{__('View')}}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            @endif
                            @if(\Auth::user()->type=='company')
                                <div class="custom-control custom-switch text-right">
                                    <input type="checkbox" class="email-template-checkbox custom-control-input" id="email_tempalte_{{$EmailTemplate->template->id}}" @if($EmailTemplate->template->is_active == 1) checked="checked" @endif value="{{$EmailTemplate->template->is_active}}" data-url="{{route('status.email.language',[$EmailTemplate->template->id])}}">
                                    <label class="custom-control-label form-control-label" for="email_tempalte_{{$EmailTemplate->template->id}}"></label>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div> --}}
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                <h5></h5>
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name"> {{__('Name')}}</th>
                                @if(\Auth::user()->type=='company')
                                    <th class="text-end">{{__('On / Off')}}</th>
                                @else
                                    <th class="text-end">{{__('Action')}}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($EmailTemplates as $EmailTemplate)
                                <tr>
                                    <td>{{ $EmailTemplate->name }}</td>
                                    <td>
                                        @if(\Auth::user()->type=='super admin')
                                        <div class="text-end">
                                        <div class="action-btn bg-warning ms-2">
                                            <a href="{{ route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang]) }}" class="mx-3 btn btn-sm d-inline-flex align-items-center" data-toggle="tooltip" title="{{__('View')}}">
                                                <i class="ti ti-eye text-white"></i>
                                            </a>
                                        </div>
                                        </div>
                                        @endif
                                        @if(\Auth::user()->type=='company')
                                        <div class="text-end">
                                            <div class="form-check form-switch d-inline-block">
                                                <input class="form-check-input" type="checkbox"
                                                 id="email_tempalte_{{$EmailTemplate->template->id}}" 
                                                  @if($EmailTemplate->template->is_active == 1) checked="checked" @endif 
                                                  value="{{$EmailTemplate->template->is_active}}" 
                                                  data-url="{{route('status.email.language',[$EmailTemplate->template->id])}}" 
                                                   role="switch">
                                                <label class="custom-control-label form-control-label" for="email_tempalte_{{$EmailTemplate->template->id}}"></label>
                                            </div>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

