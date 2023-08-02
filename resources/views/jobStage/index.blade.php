@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Job Stage') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job Stage') }}</li>
@endsection

@section('action-button')
    @can('Create Job Stage')
        <a href="#" data-url="{{ route('job-stage.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Job Stage') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection


@section('content')
        <div class="col-3">
            @include('layouts.hrm_setup')
        </div>
        <div class="col-9">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5> --}}
                <ul class="list-group conversations-list sortable">
                    @foreach ($stages as $stage)
                        <li class="list-group-item border-0 d-flex justify-content-between " data-id="{{ $stage->id }}">

                            <div class="d-flex justify-content-start">
                                <h6 class=" pe-3 ps-0 mb-0 "> {{ $stage->title }}</h6>

                            </div>
                            <div class="d-flex justify-content-end">
                                <div class="action-btn bg-info ms-2">
                                    <a class="mx-3 btn btn-sm  align-items-center" href="#"
                                        data-url="{{ route('job-stage.edit', $stage->id) }}" data-ajax-popup="true"
                                        data-size="md" data-bs-toggle="tooltip" title=""
                                        data-title="{{ __('Edit Job Stage') }}"
                                        data-bs-original-title="{{ __('Edit') }}"><i class="ti ti-pencil  text-white"></i></a>
                                </div>
                                <div class="action-btn bg-danger ms-2">
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['job-stage.destroy', $stage->id], 'id' => 'delete-form-' . $stage->id]) !!}
                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                        aria-label="Delete"><i class="ti ti-trash text-white "></i></a>
                                    </form>
                                </div>

                            </div>
                        </li>
                    @endforeach

                </ul>

                <small class="text-muted"> {{ __('Note') }} :{{ __('You can easily order change of job stage using drag & drop.') }}</small>
            </div>
           
        </div>
        </div>
@endsection

@push('script-page')
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>
    @if (\Auth::user()->type == 'company')
        <script>
            $(function() {
                $(".sortable").sortable();
                $(".sortable").disableSelection();
                $(".sortable").sortable({
                    stop: function() {
                        var order = [];
                        $(this).find('li').each(function(index, data) {
                            order[index] = $(data).attr('data-id');
                        });

                        $.ajax({
                            url: "{{ route('job.stage.order') }}",
                            data: {
                                order: order,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            type: 'POST',
                            success: function(data) {},
                            error: function(data) {
                                data = data.responseJSON;
                                toastr('Error', data.error, 'error')
                            }
                        })
                    }
                });
            });
        </script>
    @endif
@endpush
