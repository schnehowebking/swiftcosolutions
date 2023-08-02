@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Transfer') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Transfer') }}</li>
@endsection


@section('action-button')
    @can('Create Transfer')
        <a href="#" data-url="{{ route('transfer.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Transfer') }}" data-size="lg" data-bs-toggle="tooltip" title=""
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
                                @role('company')
                                    <th>{{ __('Employee Name') }}</th>
                                @endrole
                                <th>{{ __('Branch') }}</th>
                                <th>{{ __('Department') }}</th>
                                <th>{{ __('Transfer Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Transfer') || Gate::check('Delete Transfer'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="">

                            @foreach ($transfers as $transfer)
                                <tr>
                                    @role('company')
                                        <td>{{ !empty($transfer->employee()) ? $transfer->employee()->name : '' }}</td>
                                    @endrole
                                    <td>{{ !empty($transfer->branch()) ? $transfer->branch()->name : '' }}</td>
                                    <td>{{ !empty($transfer->department()) ? $transfer->department()->name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($transfer->transfer_date) }}</td>
                                    <td>{{ $transfer->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Transfer') || Gate::check('Delete Transfer'))
                                            <span>
                                                @can('Edit Transfer')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('transfer/' . $transfer->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Transfer') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Transfer')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['transfer.destroy', $transfer->id], 'id' => 'delete-form-' . $transfer->id]) !!}
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
