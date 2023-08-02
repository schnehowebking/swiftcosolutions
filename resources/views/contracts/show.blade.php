
@extends('layouts.admin')

@section('page-title')
    {{$contract->subject}}
@endsection

@push('css-page')
<link rel="stylesheet" href="{{asset('css/summernote/summernote-bs4.css')}}">
    {{-- <link rel="stylesheet" href="{{asset('custom/libs/dropzonejs/dropzone.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('assets/css/plugins/dropzone.min.css')}}">
@endpush

@push('script-page')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
    <script src="{{ asset('css/summernote/summernote-bs4.js')}}"></script>
    {{-- <script src="{{ asset('custom/assets/libs/dropzonejs/min/dropzone.min.js')}}"></script> --}}
    <script src="{{asset('assets/js/plugins/dropzone-amd-module.min.js')}}"></script>
    <script src="{{ asset('assets/js/plugins/tinymce/tinymce.min.js') }}"></script>
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

@section('page-title')
    {{ __('Lead Detail') }}
@endsection

@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0"></h5>
    </div>
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('Home')}}</a></li>
    <li class="breadcrumb-item" aria-current="page"><a href="{{route('contract.index')}}">{{__('Contract')}}</a></li>
    {{-- <li class="breadcrumb-item active" aria-current="page">{{$contract->name}}</li> --}}
    <li class="breadcrumb-item active" aria-current="page"></li>{{__('Contract Detail')}}
@endsection

@section('action-button')
<div class="col-md-6 text-end d-flex ">
            @if ((\Auth::user()->type == 'company')&&($contract->status=='accept'))
                <a href="{{route('send.mail.contract',$contract->id)}}" class="btn btn-sm btn-primary btn-icon m-2"  data-bs-toggle="tooltip" data-bs-original-title="{{__('Send Email')}}"  >
                <i class="ti ti-mail text-white"></i>
            </a>
            @endif

        @can('Create Contract')
        @if ((\Auth::user()->type == 'company')&&($contract->status=='accept'))

                <a href="#" data-size="lg" data-url="{{route('contracts.copy',$contract->id)}}"data-ajax-popup="true" data-title="{{__('Duplicate')}}" class="btn btn-sm btn-primary btn-icon m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Duplicate')}}" ><i class="ti ti-copy text-white"></i></a>
            @endif
        @endcan

            @if (\Auth::user()->type == 'company'||\Auth::user()->type == 'employee')
            
                <a href="{{route('contract.download.pdf',\Crypt::encrypt($contract->id))}}" class="btn btn-sm btn-primary btn-icon m-2" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Download')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
            @endif

            @if (\Auth::user()->type == 'company'||\Auth::user()->type == 'employee')

                <a href="{{route('get.contract',$contract->id)}}" target="_blank" class="btn btn-sm btn-primary btn-iconn m-2" title="{{__('Preview')}}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <i class="ti ti-eye"></i>
                </a>
            @endif

            @if ((\Auth::user()->type == 'company' && $contract->company_signature == '') ||(\Auth::user()->type == 'employee' &&        $contract->employee_signature == ''))
                @if($contract->status == 'accept')
                    <a href="#" class="btn btn-sm btn-primary btn-icon m-2" data-url="{{ route('signature',$contract->id) }}" data-ajax-popup="true" data-title="{{__('Signature')}}" data-size="md" title="{{__('Signature')}}" data-bs-toggle="tooltip" data-bs-placement="top">
                        <i class="ti ti-writing-sign"></i>
                    </a>
                @endif 
        @endif

        @php
            $status = App\Models\Contract::status();
        @endphp
        <ul class="list-unstyled mb-0 m-2">
            <li class="dropdown dash-h-item drp-language">
                <a class="dash-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="drp-text hide-mob text-primary">{{ ucfirst($contract->status) }}
                        <i class="ti ti-chevron-down drp-arrow nocolor hide-mob"></i>
                </a>
                <div class="dropdown-menu dash-h-dropdown">
                    @foreach ($status as $k => $status)
                        <a class="dropdown-item status" data-id="{{ $k }}"
                            data-url="{{ route('contract.status', $contract->id) }}"
                            href="#">{{ ucfirst($status) }}</a>
                     @endforeach 
                </div>
            </li>
        </ul>
</div>
@endsection

@section('content')
    <div class="col-xl-12">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#general" class="list-group-item list-group-item-action border-0">{{ __('General') }} <div
                                    class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                            <a href="#attachments" class="list-group-item list-group-item-action border-0">{{ __('Attachment') }} <div
                                    class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                            <a href="#comment" class="list-group-item list-group-item-action border-0">{{ __('Comment') }} <div
                                    class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                            <a href="#notes" class="list-group-item list-group-item-action border-0">{{ __('Notes') }} <div
                                    class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">
                    <div id="general">
                        <div class="row">
                            <div class="col-xl-7">
                                <div class="row">
                                    <div class="col-lg-4 col-6">
                                        <div class="card">
                                            <div class="card-body" style="min-height: 205px;">
                                                <div class="theme-avtar bg-primary">
                                                    <i class="ti ti-user-plus"></i>
                                                </div>
                                                <h6 class="mb-3 mt-4">{{ __('Attachment') }}</h6>
                                                    <h3 class="mb-0">{{count($contract->files)}}</h3>
                                                <h3 class="mb-0"></h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <div class="card">
                                            <div class="card-body" style="min-height: 205px;">
                                                <div class="theme-avtar bg-info">
                                                    <i class="ti ti-click"></i>
                                                </div>
                                                <h6 class="mb-3 mt-4">{{ __('Comment') }}</h6>
                                                <h3 class="mb-0">{{count($contract->comment)}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-6">
                                        <div class="card">
                                            <div class="card-body" style="min-height: 205px;">
                                                <div class="theme-avtar bg-warning">
                                                    <i class="ti ti-file"></i>
                                                </div>
                                                <h6 class="mb-3 mt-4 ">{{ __('Notes') }}</h6>
                                                <h3 class="mb-0">{{count($contract->note)}}</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-5">
                                <div class="card report_card total_amount_card">
                                    <div class="card-body pt-0 ">
                                        <address class="mb-0 text-sm">
                                            <div class="row mt-3 align-items-center">
                                                <h6>{{ __('Contract Detail') }}</h6>
                                                <div class="col-sm-4 h6 text-sm">{{ __('Employee Name') }}</div>
                                                <div class="col-sm-8 text-sm"> {{  $contract->employee->name }}</div>

                                                <div class="col-sm-4 h6 text-sm">{{ __('Subject') }}</div>
                                                <div class="col-sm-8 text-sm"> {{  $contract->subject }}</div>

                                                <div class="col-sm-4 h6 text-sm">{{__(' Type')}}</div>
                                                <div class="col-sm-8 text-sm">{{$contract->contract_type->name }}</div>

                                                <div class="col-sm-4 h6 text-sm">{{ __('Value') }}</div>
                                                <div class="col-sm-8 text-sm"> {{ Auth::user()->priceFormat($contract->value)}}</div>

                                                <div class="col-sm-4 h6 text-sm">{{__('Start Date')}}</div>
                                                <div class="col-sm-8 text-sm">{{ Auth::user()->dateFormat($contract->start_date) }}</div>

                                                <div class="col-sm-4 h6 text-sm">{{__('End Date')}}</div>
                                                <div class="col-sm-8 text-sm">{{ Auth::user()->dateFormat($contract->end_date) }}</div>

                                                
                                            </div>
                                        </address>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">{{ __('Description ') }}</h5>
                            </div>
                            <div class="card-body p-3">
                            {{ Form::open(['route' => ['contracts.description.store', $contract->id]]) }}
                                <div class="col-md-12">
                                    <div class="form-group mt-3">
                                        <textarea class="tox-target pc-tinymce-2" name="contract_description"  id="summernote" rows="8">{!! $contract->contract_description !!}</textarea>
                                    </div>
                                </div>
                            @can('Create Contract')
                                @if((\Auth::user()->type == 'company')&& ($contract->status == 'accept'))
                                <div class="col-md-12 text-end">
                                    <div class="form-group mt-3 me-3">
                                    {{ Form::submit(__('Add'), ['class' => 'btn  btn-primary']) }}
                                    </div>
                                </div>
                                {{ Form::close() }}
                                @endif
                            @endcan
                            </div>
                            
                        </div>
                    </div>

                    <div id="attachments" >
                        <div class="row ">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{__('Attachments')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class=" ">
                                            {{-- <div class="card-body bg-none"> --}}
                                                @if($contract->status=='accept')
                                                <div class="col-md-12 dropzone browse-file" id="my-dropzone"></div>
                                                @endif
                                            {{-- </div> --}}
                                        </div>
                                

                                    @foreach($contract->files as $file)
                                    <div class=" py-3">
                                        <div class="list-group-item ">
                                        <div class="row align-items-center">
                                                    <div class="col">
                                                        <h6 class="text-sm mb-0">
                                                            <a href="#!">{{ $file->files }}</a>
                                                        </h6>
                                                        
                                                        <p class="card-text small text-muted">
                                                            {{ number_format(\File::size(storage_path('contract_attechment/' . $file->files)) / 1048576, 2) . ' ' . __('MB') }}
                                                        </p>
                                                    </div>
                                                    
                                                    @php
                                                    $attachments=\App\Models\Utility::get_file('contract_attechment');
                                                    @endphp
                                                    <div class="action-btn bg-warning p-0 w-auto    ">
                                                        <a href="{{$attachments . '/' . $file->files }}"
                                                            class=" btn btn-sm d-inline-flex align-items-center"
                                                            download="" data-bs-toggle="tooltip" title="Download">
                                                        <span class="text-white"><i class="ti ti-download"></i></span>
                                                        </a>
                                                    </div>
                                                    <div class="col-auto actions">
                                                    @can('Delete Attachment')
                                                        @if(((\Auth::user()->id == $file->user_id) || (\Auth::user()->type == 'company'))&&($contract->status == 'accept'))

                                                                <div class="action-btn bg-danger ms-2">
                                                          
                                                                    <form action=""></form>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['contracts.file.delete', [$contract->id, $file->id]]]) !!}
                                                                    <a href="#!" class="mx-3 btn btn-sm  align-items-center bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                                        <i class="ti ti-trash text-white"></i>
                                                                    </a>
                                                                    {!! Form::close() !!}

                                                                </div>
                                                            @endif
                                                    @endcan
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div  id="comment" role="tabpanel" aria-labelledby="pills-comments-tab">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div id="comment">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{__('Comments')}}</h5>
                                        </div>
                                        <div class="card-footer">
                                            {{-- {{ Form::open(['route' => ['comment.store', $contract->id]]) }} --}}
                                            <div class="col-12 d-flex">
                                                @if(($contract->status == 'accept'))
                                                <div class="form-group mb-0 form-send w-100">
                                                    {{-- <form method="POST" class="card-comment-box" id="FormComments" data-action="{{route('comment.store', $contract->id )}}"> --}}
                                                    
                                                        <input type="hidden" id="commenturl" value="{{route('comment.store', $contract->id )}}">
                                                        <textarea rows="1" id="formComment" class="form-control" name="comment" data-toggle="autosize" placeholder="Add a comment..." spellcheck="false"></textarea><grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none; z-index: 1;" class="cGcvT"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none; z-index: 1;" class="cGcvT"></grammarly-extension>
                                                    {{-- </form> --}}
                                                </div>

                                                <button id="comment_submit" class="btn b tn-send"><i class="f-16 text-primary ti ti-brand-telegram">
                                                    </i>
                                                </button>
                                                @endif
                                            </div>
                                                <div class="">
                                                    <div class="list-group list-group-flush mb-0" id="comments">
                                                        @foreach($contract->comment as $comment)
                                                        @php
                                                        $user = \App\Models\User::find($comment->user_id);
                                                        $logo=\App\Models\Utility::get_file('uploads/avatar/');
                                                        @endphp
                                                        {{-- @dd($contract->comment) --}}
                                                            <div class="list-group-item ">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                       
                                                                        
                                                                        <a href="{{ !empty($user->avatar) ? $logo . '/' . $user->avatar : $logo . '/avatar.png' }}" target="_blank">
                                                                            <img class="rounded-circle"  width="25" height="25" src="{{ !empty($user->avatar) ? $logo . '/' . $user->avatar : $logo . '/avatar.png' }}">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col ml-n2">
                                                                        <p class="d-block h6 text-sm font-weight-light mb-0 text-break">{{ $comment->comment }}</p>
                                                                        <small class="d-block">{{$comment->created_at->diffForHumans()}}</small>
                                                                    </div> 

                                                                @can('Delete Comment')
                                                                    @if(((\Auth::user()->id == $comment->user_id) || (\Auth::user()->type == 'company')) &&($contract->status == 'accept'))
                                                                                <div class="p-0 w-auto action-btn bg-danger">
                                                                                    <form action=""></form>
                                                                                    {!! Form::open(['method' => 'GET', 'route' => ['comment.destroy', $comment->id]]) !!}
                                                                                        <a href="#!" class="btn btn-sm d-inline-flex align-items-center bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                                                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                                                    </a>
                                                                                    {!! Form::close() !!}
                                                                                </div>
                                                                        @endif
                                                                @endcan
                                                                       
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                           
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div id="notes" role="tabpanel" aria-labelledby="pills-comments-tab">
                        <div class="row pt-2">
                            <div class="col-12">
                                <div id="notes">
                                    <div class="card">
                                    <div class="card-header">
                                        <h5>{{__('Notes')}}</h5>
                                    </div>
                                    <div class="card-body">
                                        @if($contract->status == 'accept')
                                            <form action=""></form>
                                            {{ Form::open(['route' => ['contracts.note.store', $contract->id]]) }}
                                            <div class="form-group">
                                               
                                                <textarea rows="3" id="summernote" class="form-control tox-target pc-tinymce summernotes" name="note" data-toggle="autosize" placeholder="Add a notes..." spellcheck="false" required></textarea><grammarly-extension data-grammarly-shadow-root="true" style="position: absolute; top: 0px; left: 0px; pointer-events: none; z-index: 1;" class="cGcvT"></grammarly-extension><grammarly-extension data-grammarly-shadow-root="true" style="mix-blend-mode: darken; position: absolute; top: 0px; left: 0px; pointer-events: none; z-index: 1;" class="cGcvT"></grammarly-extension>
                                            </div>
                                            <div class="col-md-12 text-end mb-0">
                                                {{ Form::submit(__('Add'), ['class' => 'btn  btn-primary']) }}
                                            </div>
                                             {{ Form::close() }}
                                        @endif
                                        <div class="">
                                            <div class="list-group list-group-flush mb-0" id="comments">
                                                @foreach($contract->note as $note)
                                                @php
                                                $user = \App\Models\User::find($note->user_id);
                                                $logo=\App\Models\Utility::get_file('uploads/avatar/');
                                                @endphp
                                                <div class="list-group-item ">
                                                    <div class="row align-items-center">
                                                       
                                                        <div class="col-auto">
                                                         
                                                            <a href="{{ !empty($user->avatar) ? $logo . '/' . $user->avatar : $logo . '/avatar.png' }}" target="_blank">
                                                                <img class="rounded-circle"  width="25" height="25" src="{{ !empty($user->avatar) ? $logo . '/' . $user->avatar : $logo . '/avatar.png' }}">
                                                            </a>
                                                        </div>
                                                        <div class="col ml-n2">
                                                            <p class="d-block h6 text-sm font-weight-light mb-0 text-break">{{ $note->note }}</p>
                                                            <small class="d-block">{{$note->created_at->diffForHumans()}}</small>
                                                        </div>
                                                        @can('Delete Note')
                                                            @if(((\Auth::user()->id == $note->user_id) || (\Auth::user()->type == 'company'))&&($contract->status == 'accept'))
                                                                        <div class="p-0 w-auto action-btn bg-danger">
                                                                        {!! Form::open(['method' => 'GET', 'route' => ['contracts.note.destroy', $note->id]]) !!}
                                                                        <a href="#!" class=" btn btn-sm d-inline-flex align-items-center bs-pass-para " data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('Delete')}}">
                                                                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                                    </a>
                                                                    {!! Form::close() !!}
                                                                        </div>
                                                                @endif
                                                         @endcan
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    </div>
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

@push('script-page')
{{-- url: $("#form-comment").data('action'), --}}
{{-- location.reload(); --}}
<script>
    $(document).on('click', '#comment_submit', function (e) {
                var curr = $(this);

                var comment = $('#formComment').val();

        

                if (comment != '') {
                    $.ajax({
                        url: $('#commenturl').val(),
                        data: {"comment": comment, "_token": "{{ csrf_token() }}",},
                        type: 'POST',
                        success: function (data) {
                              
                            show_toastr('{{__("Success")}}', 'Comment Create Successfully!', 'success');


                            setTimeout(function () {
                                location.reload();
                            }, 500)
                            data = JSON.parse(data);
                            console.log(data);
                            data = JSON.parse(data);
                            console.log(data);
                            var html = "<div class='list-group-item px-0'>" +
                                "                    <div class='row align-items-center'>" +
                                "                        <div class='col-auto'>" +
                                "                            <a href='#' class='avatar avatar-sm rounded-circle ms-2'>" +
                                "                                <img src="+data.default_img+" alt='' class='avatar-sm rounded-circle'>" +
                                "                            </a>" +
                                "                        </div>" +
                                "                        <div class='col ml-n2'>" +
                                "                            <p class='d-block h6 text-sm font-weight-light mb-0 text-break'>" + data.comment + "</p>" +
                                "                            <small class='d-block'>"+data.current_time+"</small>" +
                                "                        </div>" +
                                "                        <div class='action-btn bg-danger me-4'><div class='col-auto'><a href='#' class='mx-3 btn btn-sm  align-items-center delete-comment' data-url='" + data.deleteUrl + "'><i class='ti ti-trash text-white'></i></a></div></div>" +
                                "                    </div>" +
                                "                </div>";

                            $("#comments").prepend(html);
                            $("#form-comment textarea[name='comment']").val('');
                            load_task(curr.closest('.task-id').attr('id'));
                            show_toastr('success', 'Comment Added Successfully!');
                        },
                        error: function (data) {
                            show_toastr('error', 'Some Thing Is Wrong!');
                        }
                    });
                } else {
                    show_toastr('error', 'Please write comment!');
                }
            });






            $(document).on("click", ".delete-comment", function () {
                var btn = $(this);

                $.ajax({
                    url: $(this).attr('data-url'),
                    type: 'DELETE',
                    dataType: 'JSON',
                    data: {"comment": comment, "_token": "{{ csrf_token() }}",},
                    success: function (data) {
                        load_task(btn.closest('.task-id').attr('id'));
                        show_toastr('success', 'Comment Deleted Successfully!');
                        btn.closest('.list-group-item').remove();
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        if (data.message) {
                            show_toastr('error', data.message);
                        } else {
                            show_toastr('error', 'Some Thing Is Wrong!');
                        }
                    }
                });
            });
</script>

<script>

    Dropzone.autoDiscover = true;
    myDropzone = new Dropzone("#my-dropzone", {
        maxFiles: 20,
    
        parallelUploads: 1,
        
        url: "{{route('contracts.file.upload',[$contract->id])}}",
        success: function (file, response) {
            if (response.is_success) {
                dropzoneBtn(file, response);
            show_toastr('{{__("Success")}}', 'Attachment Create Successfully!', 'success');

            } else {
                myDropzone.removeFile(file);
                show_toastr('{{__("Error")}}', 'File type must be match with Storage setting.', 'error');
            }
            location.reload();   
        },
        error: function (file, response) {
            myDropzone.removeFile(file);
            if (response.error) {
                show_toastr('{{__("Error")}}', 'File type must be match with Storage setting.', 'error');
            } else {
                show_toastr('{{__("Error")}}', 'File type must be match with Storage setting.', 'error');
            }
        }
    });
    myDropzone.on("sending", function (file, xhr, formData) {
        formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
        formData.append("contract_id", {{$contract->id}});
    });

    function dropzoneBtn(file, response) {
        var download = document.createElement('a');
        download.setAttribute('href', response.download);
        download.setAttribute('class', "action-btn btn-primary mx-1 mt-1 btn btn-sm d-inline-flex align-items-center");
        download.setAttribute('data-toggle', "tooltip");
        download.setAttribute('data-original-title', "{{__('Download')}}");
        download.innerHTML = "<i class='fas fa-download'></i>";

        var del = document.createElement('a');
        del.setAttribute('href', response.delete);
        del.setAttribute('class', "action-btn btn-danger mx-1 mt-1 btn btn-sm d-inline-flex align-items-center");
        del.setAttribute('data-toggle', "tooltip");
        del.setAttribute('data-original-title', "{{__('Delete')}}");
        del.innerHTML = "<i class='ti ti-trash'></i>";

        del.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (confirm("Are you sure ?")) {
                var btn = $(this);
                $.ajax({
                    url: btn.attr('href'),
                    data: {_token: $('meta[name="csrf-token"]').attr('content')},
                    type: 'DELETE',
                    success: function (response) {
                        if (response.is_success) {
                            btn.closest('.dz-image-preview').remove();
                        } else {
                            show_toastr('{{__("Error")}}', response.error, 'error');
                        }
                    },
                    error: function (response) {
                        response = response.responseJSON;
                        if (response.is_success) {
                            show_toastr('{{__("Error")}}', response.error, 'error');
                        } else {
                            show_toastr('{{__("Error")}}', response.error, 'error');
                        }
                    }
                })
            }
        });

        var html = document.createElement('div');
        html.setAttribute('class', "text-center mt-10");
        html.appendChild(download);
        html.appendChild(del);

        file.previewTemplate.appendChild(html);
    }

    // @foreach($contract->files as $file)
    // var mockFile = {name: "{{$file->files}}", size: {{\File::size(storage_path('contract_attechment/'.$file->files))}}};
    // myDropzone.emit("addedfile", mockFile);
    // myDropzone.emit("thumbnail", mockFile, "{{asset('storage/contract_attechment/'.$file->files)}}");
    // myDropzone.emit("thumbnail", mockFile, "{{asset(Storage::url('contract_attechment/'.$file->files))}}");
    // myDropzone.emit("complete", mockFile);
    // dropzoneBtn(mockFile, {download: "{{route('contracts.file.download',[$contract->id,$file->id])}}", delete: "{{route('contracts.file.delete',[$contract->id,$file->id])}}"});
    // @endforeach
    
</script> 

<script>
    $(document).on("click", ".status", function() {
          
          var status = $(this).attr('data-id');
          var url = $(this).attr('data-url');
          $.ajax({
              url: url,
              type: 'POST',
              data: {
                  
                  "status": status,
                  "_token": "{{ csrf_token() }}",
              },
              success: function(data) {
                  show_toastr('{{__("Success")}}', 'Status Update Successfully!', 'success'); 
                  location.reload();   
              }
             
          });
      });
</script> 

   


@endpush

    