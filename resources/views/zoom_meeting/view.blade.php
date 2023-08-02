<div class="col-lg-12 col-md-12 col-xl-12">

    <dl class="row p-3">
        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Name') }}</span></dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm">{{ $ZoomMeeting->title }}</span></dd>


        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Meeting Id') }}</span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm">{{ $ZoomMeeting->meeting_id }}</span></dd>


        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('User') }}</span></dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span
                class="text-sm">{{ !empty($ZoomMeeting->getUserInfo) ? $ZoomMeeting->getUserInfo->name : '' }}</span>
        </dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Start Date') }}</span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span
                class="text-sm">{{ \Auth::user()->dateFormat($ZoomMeeting->start_date) }}</span>
        </dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Duration') }}</span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm">{{ $ZoomMeeting->duration }}</span></dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Start URl') }}</span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8"><span class="text-sm">
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
            </span></dd>

        <dt class="col-sm-4 col-md-4 col-lg-4 col-xl-4"><span class="h6 text-sm mb-0">{{ __('Status') }}</span>
        </dt>
        <dd class="col-sm-8 col-md-8 col-lg-8 col-xl-8">
    
            @if ($ZoomMeeting->checkDateTime())
                @if ($ZoomMeeting->status == 'waiting')
                    <span class="badge bg-info p-2 px-3 rounded">{{ ucfirst($ZoomMeeting->status) }}</span>
                @else
                    <span class="badge bg-success p-2 px-3 rounded">{{ ucfirst($ZoomMeeting->status) }}</span>
                @endif
            @else
                <span class="badge bg-danger p-2 px-3 rounded">{{ __('End') }}</span>
            @endif

        </dd>

    </dl>

</div>
