{{-- @extends('layouts.admin')
@section('page-title')
    {{ __('Manage Indicator') }}
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

        $(document).ready(function() {
            var d_id = $('#department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#designation_id').empty();
                    $('#designation_id').append('<option value="">{{ __('Select Designation') }}</option>');
                    $.each(data, function(key, value) {
                        $('#designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                }
            });
        }
    </script>
@endpush

@section('action-button')
    @can('Create Indicator')
        <a href="#" data-url="{{ route('indicator.create') }}"
            class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="{{ __('Create') }}" data-title="{{ __('Create New Indicator') }}">
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
                                    <th>{{ __('Branch') }}</th>
                                    <th>{{ __('Department') }}</th>
                                    <th>{{ __('Designation') }}</th>
                                    <th>{{ __('Overall Rating') }}</th>
                                    <th>{{ __('Added By') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                        <th>{{ __('Action') }}</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($indicators as $indicator)
                                    @php
                                        if (!empty($indicator->rating)) {
                                            $rating = json_decode($indicator->rating, true);
                                            if (!empty($rating)) {
                                                $starsum = array_sum($rating);
                                                $overallrating = $starsum / count($rating);
                                            } else {
                                                $overallrating = 0;
                                            }
                                        } else {
                                            $overallrating = 0;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ !empty($indicator->branches) ? $indicator->branches->name : '' }}</td>
                                        <td>{{ !empty($indicator->departments) ? $indicator->departments->name : '' }}</td>
                                        <td>{{ !empty($indicator->designations) ? $indicator->designations->name : '' }}</td>
                                        <td>

                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($overallrating < $i)
                                                    @if (is_float($overallrating) && round($overallrating) == $i)
                                                        <i class="text-warning fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="fas fa-star"></i>
                                                    @endif
                                                @else
                                                    <i class="text-warning fas fa-star"></i>
                                                @endif
                                            @endfor
                                            <span class="theme-text-color">({{ number_format($overallrating, 1) }})</span>
                                        </td>
                                        <td>{{ !empty($indicator->user) ? $indicator->user->name : '' }}</td>
                                        <td>{{ \Auth::user()->dateFormat($indicator->created_at) }}</td>
                                        @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                            <td class="d-flex">
                                                @can('Show Indicator')
                                                    <a href="#" data-url="{{ route('indicator.show', $indicator->id) }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Indicator Detail') }}"
                                                        class="action-btn btn-success me-1 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ __('View') }}"><i
                                                            class="ti ti-eye"></i></a>
                                                @endcan
                                                @can('Edit Indicator')
                                                    <a href="#" data-url="{{ route('indicator.edit', $indicator->id) }}"
                                                        data-size="lg" data-ajax-popup="true"
                                                        data-title="{{ __('Edit Indicator') }}"
                                                        class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ __('Edit') }}"><i
                                                            class="ti ti-pencil"></i></a>
                                                @endcan
                                                @can('Delete Indicator')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
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
    {{ __('Manage Indicator') }}
@endsection
{{-- @push('css-page')
    <style>
        @import url({{ asset('css/font-awesome.css') }});

    </style>
@endpush --}}


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Indicator') }}</li>
@endsection

@section('action-button')
    @can('Create Indicator')
        <a href="#" data-url="{{ route('indicator.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Indicator') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
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
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Designation') }}</th>
                                <th>{{ __('Overall Rating') }}</th>
                                <th>{{ __('Added By') }}</th>
                                <th>{{ __('Created At') }}</th>
                                @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($indicators as $indicator)
                                @php
                                    if (!empty($indicator->rating)) {
                                        $rating = json_decode($indicator->rating, true);
                                        if (!empty($rating)) {
                                            $starsum = array_sum($rating);
                                            $overallrating = $starsum / count($rating);
                                        } else {
                                            $overallrating = 0;
                                        }
                                    } else {
                                        $overallrating = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ !empty($indicator->branches) ? $indicator->branches->name : '' }}</td>
                                    <td>{{ !empty($indicator->departments) ? $indicator->departments->name : '' }}
                                    </td>
                                    <td>{{ !empty($indicator->designations) ? $indicator->designations->name : '' }}
                                    </td>
                                    <td>

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($overallrating < $i)
                                                @if (is_float($overallrating) && round($overallrating) == $i)
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{ number_format($overallrating, 1) }})</span>
                                    </td>
                                    <td>{{ !empty($indicator->user) ? $indicator->user->name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($indicator->created_at) }}</td>
                                    @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                        <td class="text-right action-btns">
                                            @can('Show Indicator')
                                                <a href="#" data-url="{{ route('indicator.show', $indicator->id) }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Indicator Detail') }}" class="edit-icon bg-success"
                                                    data-toggle="tooltip" data-original-title="{{ __('View Detail') }}"><i
                                                        class="fas fa-eye"></i></a>
                                            @endcan
                                            @can('Edit Indicator')
                                                <a href="#" data-url="{{ route('indicator.edit', $indicator->id) }}"
                                                    data-size="lg" data-ajax-popup="true"
                                                    data-title="{{ __('Edit Indicator') }}" class="edit-icon"
                                                    data-toggle="tooltip" data-original-title="{{ __('Edit') }}"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('Delete Indicator')
                                                <a href="#" class="delete-icon"
                                                    data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                                    data-confirm-yes="document.getElementById('delete-form-{{ $indicator->id }}').submit();"><i
                                                        class="fas fa-trash"></i></a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach --}}

                            @foreach ($indicators as $indicator)
                                @php
                                    if (!empty($indicator->rating)) {
                                        $rating = json_decode($indicator->rating, true);
                                        if (!empty($rating)) {
                                            $starsum = array_sum($rating);
                                            $overallrating = $starsum / count($rating);
                                        } else {
                                            $overallrating = 0;
                                        }
                                    } else {
                                        $overallrating = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>{{ !empty($indicator->branches) ? $indicator->branches->name : '' }}</td>
                                    <td>{{ !empty($indicator->departments) ? $indicator->departments->name : '' }}
                                    </td>
                                    <td>{{ !empty($indicator->designations) ? $indicator->designations->name : '' }}
                                    </td>
                                    <td>

                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($overallrating < $i)
                                                @if (is_float($overallrating) && round($overallrating) == $i)
                                                    <i class="text-warning fas fa-star-half-alt"></i>
                                                @else
                                                    <i class="fas fa-star"></i>
                                                @endif
                                            @else
                                                <i class="text-warning fas fa-star"></i>
                                            @endif
                                        @endfor
                                        <span class="theme-text-color">({{ number_format($overallrating, 1) }})</span>
                                    </td>
                                    <td>{{ !empty($indicator->user) ? $indicator->user->name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($indicator->created_at) }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Indicator') || Gate::check('Delete Indicator') || Gate::check('Show Indicator'))
                                            <span>


                                                @can('Show Indicator')

                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('indicator.show', $indicator->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Indicator Detail ') }}"
                                                            data-bs-original-title="{{ __('View') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan


                                                @can('Edit Indicator')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('indicator.edit', $indicator->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Indicator') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Indicator')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['indicator.destroy', $indicator->id], 'id' => 'delete-form-' . $indicator->id]) !!}
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

        $(document).ready(function() {
            var d_id = $('.department_id').val();
            getDesignation(d_id);
        });

        $(document).on('change', 'select[name=department]', function() {
            var department_id = $(this).val();
            getDesignation(department_id);
        });

        function getDesignation(did) {
            $.ajax({
                url: '{{ route('employee.json') }}',
                type: 'POST',
                data: {
                    "department_id": did,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    // $('#designation_id').empty();
                    // $('#designation_id').append('<option value="">{{ __('Select Designation') }}</option>');
                    // $.each(data, function(key, value) {
                    //     $('#designation_id').append('<option value="' + key + '">' + value +
                    //         '</option>');
                    // });


                    $('.designation_id').empty();
                    var emp_selct = ` <select class="form-control  designation_id" name="designation" id="choices-multiple"
                                            placeholder="Select Designation" >
                                            </select>`;
                    $('.designation_div').html(emp_selct);

                    $('.designation_id').append('<option value="0"> {{ __('All') }} </option>');
                    $.each(data, function(key, value) {
                        $('.designation_id').append('<option value="' + key + '">' + value +
                            '</option>');
                    });
                    new Choices('#choices-multiple', {
                        removeItemButton: true,
                    });

                }
            });
        }
    </script>
@endpush
