@extends('layouts.contractheader')
@section('page-title')
    {{ __('Contract View') }}
@endsection


@section('content')
    <div class="row">

    <div class="col-lg-10">
        <div class="container">
            <div>

                    <div class="text-md-end mb-2"style="margin-right: -44px;">
                       
                        <a href="{{route('contract.download.pdf',\Crypt::encrypt($contract->id))}}" class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Download')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
                        
                    </div>

                <div class="card mt-5" id="printTable" style="margin-left: 180px;margin-right: -57px;">
                    <div class="card-body">
                        <div class="row invoice-title mt-2">
                            <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                                <img  src="{{$img}}" style="max-width: 150px;"/>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 text-end">
                                <h3 class="invoice-number">{{\Auth::user()->contractNumberFormat($contract->id)}}</h3>
                            </div>    
                        </div>
                        <div class="row align-items-center mb-4">
                            
                            <div class="col-sm-6 mb-3 mb-sm-0 mt-3">
                                <div class="col-lg-6 col-md-8 mb-3">
                                    <h6 class="d-inline-block m-0 d-print-none">{{__('Contract Type  :')}}</h6>
                                    <span class="col-md-8"><span class="text-md">{{$contract->contract_type->name }}</span></span>
                                </div>
                                <div class="col-lg-6 col-md-8">
                                <h6 class="d-inline-block m-0 d-print-none">{{__('Contract Value   :')}}</h6>
                                <span class="col-md-8"><span class="text-md">{{ Auth::user()->priceFormat($contract->value) }}</span></span>
                            </div>
                           
  
                            </div>
                            <div class="col-sm-6 text-sm-end">
                                <div>
                                    <div class="float-end">
                                        <div class="">
                                            <h6 class="d-inline-block m-0 d-print-none">{{__('Start Date   :')}}</h6>
                                            <span class="col-md-8"><span class="text-md">{{Auth::user()->dateFormat($contract->start_date) }}</span></span>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="d-inline-block m-0 d-print-none">{{__('End Date   :')}}</h6>
                                            <span class="col-md-8"><span class="text-md">{{Auth::user()->dateFormat($contract->end_date)}}</span></span>
                                        </div>
                                       
                                        {{-- {!! DNS2D::getBarcodeHTML(route('pay.invoice',\Illuminate\Support\Facades\Crypt::encrypt($invoice->id)), "QRCODE",2,2) !!} --}}
                                    </div>

                                </div>
                            </div>
                        </div>
                        <p data-v-f2a183a6="">
                            
                            <div>{!!$contract->description!!}</div>
                            <br>
                            <div>{!!$contract->contract_description!!}</div>
                        </p>

                        <div class="row">
                            <div class="col-6">
                                <div style="margin-top: 20px;">
                                    <img width="" src="{{$contract->company_signature}}" >
                                </div>
                                <div>
                                    <h5 class="mt-4">{{__('Company Signature')}}</h5>
                                </div>
                            </div> 
                            <div class="col-6 text-end">
                                <div style="margin-bottom: 20px;">
                                    <img width="" src="{{$contract->employee_signature}}" >
                                </div>
                                <div>
                                    <h5 style="margin-top: 45px;">{{__('Employee Signature')}}</h5>
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