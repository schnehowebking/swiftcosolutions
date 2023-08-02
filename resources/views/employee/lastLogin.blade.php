    @extends('layouts.admin')

@section('page-title')
    {{ __('Last Login') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Last Login') }}</li>
@endsection

@section('content')
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header card-body table-border-style">
                {{-- <h5></h5>  --}}
                <div class="table-responsive">
                    <table class="table" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Last Login') }}</th>
                                <th>{{ __('Role') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                @php
                                    $emp = $user->getUSerEmployee($user->id);
                                    $emp_id = '-';
                                    if (!empty($emp)) {
                                        $emp_id = \Auth::user()->employeeIdFormat($emp->id);
                                    }
                                @endphp
                                <tr>
                                    @if ($user->type == 'employee')
                                        <td><a class="btn btn-primary" href="{{ route('show.employee.profile', \Illuminate\Support\Facades\Crypt::encrypt($user->id)) }}">{{ $emp_id }} </a></td>
                                    @else
                                        <td>{{ __('-') }}</td>
                                    @endif
                                    <td>{{ $user->name }}</td>
                                    <td>{{ !empty($user->last_login) ? $user->last_login : '-' }}</td>
                                    <td>{{ $user->type }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
