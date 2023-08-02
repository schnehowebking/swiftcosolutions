@extends('layouts.admin')

@section('page-title')
    {{ __('Zoom Metting') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Zoom Metting') }}</li>
@endsection

@section('action-button')
    <a href="{{ route('zoom_meeting.calender') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
        data-bs-original-title="{{ __('Calender View') }}">
        <i class="ti ti-calendar"></i>
    </a>
    @if (\Auth::user()->type == 'company')
        <a href="#" data-url="{{ route('zoom-meeting.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Zoom Meeting') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endif
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5> --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Meeting Time') }}</th>
                                <th>{{ __('Duration') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Join URL') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ZoomMeetings as $ZoomMeeting)
                                <tr>
                                    <td>{{ $ZoomMeeting->title }}</td>
                                    <td>{{ $ZoomMeeting->start_date }}</td>
                                    <td>{{ $ZoomMeeting->duration }} {{ __(' Minute') }}</td>
                                    <td>
                                        <div class="user-group">
                                            @foreach($ZoomMeeting->users($ZoomMeeting->user_id) as $projectUser)
                                            <img alt="image" data-bs-toggle="tooltip" data-bs-placement="top" title="{{$projectUser->name}}" @if($projectUser->avatar) src="{{asset(Storage::url('uploads/avatar/')).'/'.$projectUser->avatar}}" @else src="{{asset(Storage::url('uploads/avatar/'))}}" @endif class="rounded-circle " width="25" height="25">
                                    @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        @if ($ZoomMeeting->created_by == \Auth::user()->id && $ZoomMeeting->checkDateTime())
                                            <a href="{{ $ZoomMeeting->start_url }}" class="text-secondary">
                                                <p class="mb-0"><b>{{ __('Start meeting') }}</b> <i
                                                        class="ti ti-external-link"></i></p>
                                            </a>
                                        @elseif($ZoomMeeting->checkDateTime())
                                            <a href="{{ $ZoomMeeting->join_url }}" class="text-secondary">
                                                <p class="mb-0"><b>{{ __('Join meeting') }}</b> <i
                                                        class="ti ti-external-link"></i></p>
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($ZoomMeeting->checkDateTime())
                                            @if ($ZoomMeeting->status == 'waiting')
                                                <span
                                                    class="badge bg-info p-2 px-3 rounded">{{ ucfirst($ZoomMeeting->status) }}</span>
                                            @else
                                                <span
                                                    class="badge bg-success p-2 px-3 rounded">{{ ucfirst($ZoomMeeting->status) }}</span>
                                            @endif
                                        @else
                                            <span class="badge bg-danger p-2 px-3 rounded">{{ __('End') }}</span>
                                        @endif

                                    </td>
                                    <td class="Action">
                                        <span>
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['zoom-meeting.destroy', $ZoomMeeting->id], 'id' => 'delete-form-' . $ZoomMeeting->id]) !!}
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                    aria-label="Delete"><i
                                                        class="ti ti-trash text-white text-white"></i></a>
                                                </form>
                                            </div>

                                        </span>
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
{{-- @push('script-page')
    <script>
        function ddatetime_range() {
            $('.datetime_class_start_date').daterangepicker({
                "singleDatePicker": true,
                "timePicker": true,
                "autoApply": false,
                "locale": {
                    "format": 'YYYY-MM-DD H:mm'
                },
                "timePicker24Hour": true,
            }, function(start, end, label) {
                $('.start_date').val(start.format('YYYY-MM-DD H:mm'));
            });
        }
    </script>
@endpush --}}
