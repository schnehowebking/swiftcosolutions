
@extends('layouts.contractheader')
@section('page-title')
    {{ __('NOC') }}
@endsection

@section('content')
<div class="row" >

    <div class="col-lg-10">
        <div class="container">
            <div>
                <div class="card mt-5" id="printTable" style="margin-left: 180px;margin-right: -57px;">
                
                    <div class="card-body" id="boxes">
                            <div class="row invoice-title mt-2">
                                
                                
                                <p data-v-f2a183a6="">
                                {{-- @dd($Offerletter) --}}
                                    <div>{!!$noc_certificate->content!!}</div>
                                   
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
                filename: '{{$employees->name}}',
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A4'}
            };

            html2pdf().set(opt).from(element).save().then(closeScript);
        });

        
    </script>
    
@endpush