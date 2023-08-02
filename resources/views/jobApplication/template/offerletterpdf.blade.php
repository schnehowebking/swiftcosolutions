
@extends('layouts.contractheader')
@section('page-title')
    {{ __('Offer Letter') }}
@endsection

@section('content')
<div class="row" >

    <div class="col-lg-10">
        <div class="container">
            <div>
                <div class="card mt-5" id="printTable" style="margin-left: 180px;margin-right: -57px;">
                
                    <div class="card-body" id="boxes">
                            <div class="row invoice-title mt-2">
                                <div class="col-xs-12 col-sm-12 col-nd-6 col-lg-6 col-12 ">
                                    {{-- <img  src="{{$img}}" style="max-width: 150px;"/> --}}
                                </div>
                                
                                <p data-v-f2a183a6="">
                                {{-- @dd($Offerletter) --}}
                                    <div>{!!$Offerletter->content!!}</div>
                                    {{-- <br>
                                    <div>{!!$contract->contract_description!!}</div> --}}
                                </p>
                        

                        </div>
                 </div>
            </div>
        </div>
    </div>

    
</div>

@endsection
@push('script-page')
    <script type="text/javascript" src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function closeScript() {
            setTimeout(function () {
                window.open(window.location, '_self').close();
            }, 1000);
        }

        $(window).on('load', function () {
            var element = document.getElementById('boxes');
            var opt = {
                filename: '{{$name->name}}',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };

            html2pdf().set(opt).from(element).save().then(closeScript);
        });

        
    </script>
    
@endpush