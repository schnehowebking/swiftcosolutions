@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Complaint') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Complaint') }}</li>
@endsection

@section('action-button')
    @can('Create Complaint')
        <a href="#" data-url="{{ route('complaint.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Complaint') }}" data-size="lg" data-bs-toggle="tooltip" title=""
            class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
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
                                <th>{{ __('Complaint From') }}</th>
                                <th>{{ __('Complaint Against') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Complaint Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Complaint') || Gate::check('Delete Complaint'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($complaints as $complaint)
                                <tr>
                                    <td>{{ !empty($complaint->complaintFrom($complaint->complaint_from)) ? $complaint->complaintFrom($complaint->complaint_from)->name : '' }}
                                    </td>
                                    <td>{{ !empty($complaint->complaintAgainst($complaint->complaint_against)) ? $complaint->complaintAgainst($complaint->complaint_against)->name : '' }}
                                    </td>
                                    <td>{{ $complaint->title }}</td>
                                    <td>{{ \Auth::user()->dateFormat($complaint->complaint_date) }}</td>
                                    <td>{{ $complaint->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Complaint') || Gate::check('Delete Complaint'))
                                            <span>
                                                @can('Edit Complaint')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('complaint/' . $complaint->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Complaint') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Complaint')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['complaint.destroy', $complaint->id], 'id' => 'delete-form-' . $complaint->id]) !!}
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
