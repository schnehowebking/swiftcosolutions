<div class="col-form-label">
    <div class="row m-2">
        @foreach ($leaves as $leave)
            <div class="col text-center">
                <div class="card p-4 mb-4">
                    <h5 class="report-text gray-text mb-0">{{ $leave->title }} :</h5>
                    <h5 class="report-text mb-0">{{ $leave->total }}</h5>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row m-2">

        <div class="table-responsive">
            <table class="table" id="pc-dt-simple">
                <thead>
                    <tr>
                        <th>{{ __('Leave Type') }}</th>
                        <th>{{ __('Leave Date') }}</th>
                        <th>{{ __('Leave Days') }}</th>
                        <th>{{ __('Leave Reason') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leaveData as $leave)
                        @php
                            $startDate = new \DateTime($leave->start_date);
                            $endDate = new \DateTime($leave->end_date);
                            $total_leave_days = $startDate->diff($endDate)->days;
                        @endphp
                        <tr>
                            <td>{{ !empty($leave->leaveType) ? $leave->leaveType->title : '' }}</td>
                            <td>{{ $leave->start_date . ' to ' . $leave->end_date }}</td>
                            <td>{{ $total_leave_days }}</td>
                            <td>{{ $leave->leave_reason }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">{{ __('No Data Found.!') }}</td>
                        </tr>
                        
                        @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
