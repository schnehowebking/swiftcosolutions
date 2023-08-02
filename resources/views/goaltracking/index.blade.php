{{-- @extends('layouts.admin')
@section('page-title')
    {{ __('Manage Goal Tracking') }}
@endsection
@push('css-page')
    <style>
        @import url({{ asset('css/font-awesome.css') }});

    </style>
@endpush
@push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function() {
                alert($(this).val());
                $(this).attr("checked");
            });
        });
    </script>
@endpush
@section('action-button')
    @can('Create Goal Tracking')
        <a href="#" data-url="{{ route('goaltracking.create') }}" data-size="lg"
        data-bs-toggle="tooltip" data-bs-placement="bottom"
        title="{{ __('Create') }}"           class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
            data-title="{{ __('Create New Goal Tracking') }}">
            <i class=" ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-body table-border-style">
                    <h5></h5>
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">

                            <thead>
                                <tr>
                                    <th>{{ __('Goal Type') }}</th>
                                    <th>{{ __('Subject') }}</th>
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('Target Achievement') }}</th>
                                    <th>{{ __('Start Date') }}</th>
                                    <th>{{ __('End Date') }}</th>
                                    <th>{{ __('Rating') }}</th>
                                    <th>{{ __('Progress') }}</th>
                                    @if (Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($goalTrackings as $goalTracking)
                                    <tr>
                                        <td>{{ !empty($goalTracking->goalType) ? $goalTracking->goalType->name : '' }}
                                        </td>
                                        <td>{{ $goalTracking->subject }}</td>
                                        <td>{{ !empty($goalTracking->branches) ? $goalTracking->branches->name : '' }}
                                        </td>
                                        <td>{{ $goalTracking->target_achievement }}</td>
                                        <td>{{ \Auth::user()->dateFormat($goalTracking->start_date) }}</td>
                                        <td>{{ \Auth::user()->dateFormat($goalTracking->end_date) }}</td>
                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($goalTracking->rating < $i)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="text-warning fas fa-star"></i>
                                                @endif
                                            @endfor
                                        </td>
                                        <td>
                                            <div class="progress-wrapper">
                                                <span class="progress-percentage"><small
                                                        class="font-weight-bold"></small>{{ $goalTracking->progress }}%</span>
                                                <div class="progress progress-xs mt-2 w-100">
                                                    <div class="progress-bar bg-{{ Utility::getProgressColor($goalTracking->progress) }}"
                                                        role="progressbar" aria-valuenow="{{ $goalTracking->progress }}"
                                                        aria-valuemin="0" aria-valuemax="100"
                                                        style="width: {{ $goalTracking->progress }}%;"></div>
                                                </div>
                                            </div>

                                        </td class="text-right action-btns">
                                        @if (Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking'))
                                            <td class="d-flex">
                                                @can('Edit Goal Tracking')
                                                    <a href="#"
                                                        data-url="{{ route('goaltracking.edit', $goalTracking->id) }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Goal Tracking') }}"
                                                        class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ __('Edit') }}"><i
                                                            class="ti ti-pencil"></i></a>
                                                @endcan
                                                @can('Delete Goal Tracking')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id], 'id' => 'delete-form-' . $goalTracking->id]) !!}
                                                <a href="#!"
                                                    class="action-btn btn-danger me-1 btn btn-sm d-inline-flex align-items-center show_confirm"
                                                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                    title="{{ __('Delete') }}">
                                                    <i class="ti ti-trash"></i></a>
                                                {!! Form::close() !!}

                                                @endcan
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ basic-table ] end -->
    </div>
@endsection --}}


@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Goal Tracking') }}
@endsection
{{-- @push('css-page')
    <style>
        @import url({{ asset('css/font-awesome.css') }});

    </style>
@endpush --}}
{{-- @push('script-page')
    <script src="{{ asset('js/bootstrap-toggle.js') }}"></script>
    <script>
        $('document').ready(function() {
            $('.toggleswitch').bootstrapToggle();
            $("fieldset[id^='demo'] .stars").click(function() {
                alert($(this).val());
                $(this).attr("checked");
            });
        });
    </script>
@endpush --}}
@section('action-button')
    @can('Create Goal Tracking')
        <a href="#" data-url="{{ route('goaltracking.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Goal Tracking') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Goal Tracking') }}</li>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5> </h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Goal Type') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Target Achievement') }}</th>
                                <th>{{ __('Start Date') }}</th>
                                <th>{{ __('End Date') }}</th>
                                <th>{{ __('Rating') }}</th>
                                <th width="20%">{{ __('Progress') }}</th>
                                @if (Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($goalTrackings as $goalTracking)
                                <tr>
                                    <td>{{ !empty($goalTracking->goalType) ? $goalTracking->goalType->name : '' }}
                                    </td>
                                    <td>{{ $goalTracking->subject }}</td>
                                    <td>{{ !empty($goalTracking->branches) ? $goalTracking->branches->name : '' }}
                                    </td>
                                    <td>{{ $goalTracking->target_achievement }}</td>
                                    <td>{{ \Auth::user()->dateFormat($goalTracking->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($goalTracking->end_date) }}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($goalTracking->rating < $i)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <span class="progress-percentage"><small
                                                    class="font-weight-bold"></small>{{ $goalTracking->progress }}%</span>
                                            <div class="progress progress-xs mt-2 w-100">
                                                <div class="progress-bar bg-{{ Utility::getProgressColor($goalTracking->progress) }}"
                                                    role="progressbar" aria-valuenow="{{ $goalTracking->progress }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ $goalTracking->progress }}%;"></div>
                                            </div>
                                        </div>

                                    </td class="text-right action-btns">
                                    @if (Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking'))
                                        <td class="text-right action-btns">
                                            @can('Edit Goal Tracking')
                                                <a href="#" data-url="{{ route('goaltracking.edit', $goalTracking->id) }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Edit Goal Tracking') }}" class="edit-icon"
                                                    data-toggle="tooltip" data-original-title="{{ __('Edit') }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('Delete Goal Tracking')
                                                <a href="#" class="delete-icon"
                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                    data-toggle="tooltip" data-original-title="{{ __('Delete') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{ $goalTracking->id }}').submit();"><i
                                                        class="fas fa-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id], 'id' => 'delete-form-' . $goalTracking->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach --}}

                            @foreach ($goalTrackings as $goalTracking)
                                <tr>
                                    <td>{{ !empty($goalTracking->goalType) ? $goalTracking->goalType->name : '' }}
                                    </td>
                                    <td>{{ $goalTracking->subject }}</td>
                                    <td>{{ !empty($goalTracking->branches) ? $goalTracking->branches->name : '' }}
                                    </td>
                                    <td>{{ $goalTracking->target_achievement }}</td>
                                    <td>{{ \Auth::user()->dateFormat($goalTracking->start_date) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($goalTracking->end_date) }}</td>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($goalTracking->rating < $i)
                                                <i class="fas fa-star"></i>
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                    </td>
                                    <td>
                                        <div class="progress-wrapper">
                                            <span class="progress-percentage"><small
                                                    class="font-weight-bold"></small>{{ $goalTracking->progress }}%</span>
                                            <div class="progress progress-xs mt-2 w-100">
                                                <div class="progress-bar bg-{{ Utility::getProgressColor($goalTracking->progress) }}"
                                                    role="progressbar" aria-valuenow="{{ $goalTracking->progress }}"
                                                    aria-valuemin="0" aria-valuemax="100"
                                                    style="width: {{ $goalTracking->progress }}%;"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Goal Tracking') || Gate::check('Delete Goal Tracking'))
                                            <span>

                                                @can('Edit Goal Tracking')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('goaltracking.edit', $goalTracking->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Goal Tracking') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Goal Tracking')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['goaltracking.destroy', $goalTracking->id], 'id' => 'delete-form-' . $goalTracking->id]) !!}
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                            data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                            aria-label="Delete"><i
                                                                class="ti ti-trash text-white text-white"></i></a>
                                                        </form>
                                                    </div>
                                                @endcan
                                            </span>
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
