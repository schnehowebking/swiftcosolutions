@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Job On-Boarding') }}
@endsection
@section('action-button')


    @can('Create Interview Schedule')
        <a href="#" data-url="{{ route('job.on.board.create', 0) }}" data-ajax-popup="true"
            data-title="{{ __('Create New Job On-Boarding') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
    @endcan
@endsection


@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Job On-Boarding') }}</li>
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Job') }}</th>
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Applied at') }}</th>
                                <th>{{ __('Joining at') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobOnBoards as $job)
                                <tr>
                                    <td>{{ !empty($job->applications) ? $job->applications->name : '-' }}</td>
                                    <td>{{ !empty($job->applications) ? (!empty($job->applications->jobs) ? $job->applications->jobs->title : '-') : '-' }}
                                    </td>
                                    <td>{{ !empty($job->applications) ? (!empty($job->applications->jobs) ? (!empty($job->applications->jobs) ? (!empty($job->applications->jobs->branches) ? $job->applications->jobs->branches->name : '-') : '-') : '-') : '-' }}
                                    </td>
                                    <td>{{ \Auth::user()->dateFormat(!empty($job->applications) ? $job->applications->created_at : '-') }}
                                    </td>
                                    <td>{{ \Auth::user()->dateFormat($job->joining_date) }}</td>
                                    <td>
                                        @if ($job->status == 'pending')
                                            <span
                                                class="badge bg-warning p-2 px-3 rounded">{{ \App\Models\JobOnBoard::$status[$job->status] }}</span>
                                        @elseif($job->status == 'cancel')
                                            <span
                                                class="badge bg-danger p-2 px-3 rounded">{{ \App\models\JobOnBoard::$status[$job->status] }}</span>
                                        @else
                                            <span
                                                class="badge bg-success p-2 px-3 rounded">{{ \App\models\JobOnBoard::$status[$job->status] }}</span>
                                        @endif
                                    </td>

                                    <td class="Action">
                                        <span>
                                            {{-- @if ($job->status == 'confirm' && $job->convert_to_employee == 0)
                                            <a href="{{ route('job.on.board.convert', $job->id) }}"
                                                class="edit-icon bg-info" data-toggle="tooltip"
                                                data-original-title="{{ __('Convert to Employee') }}"><i
                                                    class="fas fa-exchange-alt"></i></a>
                                        @elseif($job->status == 'confirm' && $job->convert_to_employee != 0)
                                            <a href="{{ route('employee.show', \Crypt::encrypt($job->convert_to_employee)) }}"
                                                class="edit-icon bg-info" data-toggle="tooltip"
                                                data-original-title="{{ __('Employee Detail') }}"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif

                                        <a href="#" data-url="{{ route('job.on.board.edit', $job->id) }}"
                                            data-ajax-popup="true" class="edit-icon" data-toggle="tooltip"
                                            data-original-title="{{ __('Edit') }}"><i class="fas fa-pencil-alt"></i></a>

                                        <a href="#" class="delete-icon" data-toggle="tooltip"
                                            data-original-title="{{ __('Delete') }}"
                                            data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}"
                                            data-confirm-yes="document.getElementById('delete-form-{{ $job->id }}').submit();"><i
                                                class="fas fa-trash"></i></a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['job.on.board.delete', $job->id], 'id' => 'delete-form-' . $job->id]) !!}
                                        {!! Form::close() !!} --}}

                                            @if ($job->status == 'confirm' && $job->convert_to_employee == 0)
                                                <div class="action-btn bg-dark ms-2">
                                                    <a href="{{ route('job.on.board.convert', $job->id) }}"
                                                        class="mx-3 btn btn-sm  align-items-center" data-ajax-popup="true"
                                                        data-title="{{ __('Convert to Employee ') }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Convert to Employee') }}">
                                                        <i class="ti ti-arrows-right-left text-white"></i>
                                                    </a>
                                                </div>
                                            @elseif($job->status == 'confirm' && $job->convert_to_employee != 0)
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="{{ route('employee.show', \Crypt::encrypt($job->convert_to_employee)) }}"
                                                        class="mx-3 btn btn-sm  align-items-center" data-ajax-popup="true"
                                                        data-title="{{ __('Employee Detail ') }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Employee Detail') }}">
                                                        <i class="ti ti-eye text-white"></i>
                                                    </a>
                                                </div>
                                            @endif



                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                    data-url="{{ route('job.on.board.edit', $job->id) }}"
                                                    data-ajax-popup="true" data-title="{{ __('Edit Job On-Boarding') }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>



                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['job.on.board.delete', $job->id], 'id' => 'delete-form-' . $job->id]) !!}
                                                <a href="#!" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete') }}">
                                                    <i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                            </div>

                                            @if ($job->status == 'confirm' )
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="{{route('offerlatter.download.pdf',$job->id)}}" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('OfferLetter PDF')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                            </div>
                                            <div class="action-btn bg-primary ms-2">
                                                <a href="{{route('offerlatter.download.doc',$job->id)}}" class="mx-3 btn btn-sm  align-items-center " data-bs-toggle="tooltip" data-bs-placement="top" title="{{__('OfferLetter DOC')}}" target="_blanks"><i class="ti ti-download text-white"></i></a>
                                            </div>
                                        @endif

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
