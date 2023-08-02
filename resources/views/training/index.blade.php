@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Training') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Training List') }}</li>
@endsection


@section('action-button')
    <a href="{{ route('training.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
        data-bs-original-title="{{ __('Export') }}">
        <i class="ti ti-file-export"></i>
    </a>



    @can('Create Training')
        <a href="#" data-url="{{ route('training.create') }}" data-ajax-popup="true" data-size="lg"
            data-title="{{ __('Create New Training') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
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
                                <th>{{ __('Training Type') }}</th>
                                <th>{{ __('Status')}}</th>
                                <th>{{ __('Employee') }}</th>
                                <th>{{ __('Trainer') }}</th>
                                <th>{{ __('Training Duration') }}</th>
                                <th>{{ __('Cost') }}</th>
                                @if (Gate::check('Edit Training') || Gate::check('Delete Training') || Gate::check('Show Training'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                           

                            @foreach ($trainings as $training)
                                <tr>
                                    <td>{{ !empty($training->branches) ? $training->branches->name : '' }}</td>
                                    <td>{{ !empty($training->types) ? $training->types->name : '' }} <br></td>
                                    <td>
                                         @if ($training->status == 0)
                                            <span class="badge bg-warning p-2 px-3 rounded mt-1 status-badge6">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 1)
                                            <span class="badge bg-primary p-2 px-3 rounded mt-1 status-badge6">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 2)
                                            <span class="badge bg-success p-2 px-3 rounded mt-1 status-badge6">{{ __($status[$training->status]) }}</span>
                                        @elseif($training->status == 3)
                                            <span class="badge bg-danger p-2 px-3 rounded mt-1 status-badge6">{{ __($status[$training->status]) }}</span>
                                        @endif

                                    </td>
                                    <td>{{ !empty($training->employees) ? $training->employees->name : '' }} </td>
                                    <td>{{ !empty($training->trainers) ? $training->trainers->firstname : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($training->start_date) . ' to ' . \Auth::user()->dateFormat($training->end_date) }}
                                    </td>
                                    <td>{{ \Auth::user()->priceFormat($training->training_cost) }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Training') || Gate::check('Delete Training') || Gate::check('Show Training'))
                                            <span>

                                                @can('Show Training')
                                                    <div class="action-btn bg-warning ms-2">
                                                        <a href="{{ route('training.show', \Illuminate\Support\Facades\Crypt::encrypt($training->id)) }}" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url=""
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Show Trainer') }}"
                                                            data-bs-original-title="{{ __('Show') }}">
                                                            <i class="ti ti-eye text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan


                                                @can('Edit Training')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ route('training.edit', $training->id) }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Training') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Training')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['training.destroy', $training->id], 'id' => 'delete-form-' . $training->id]) !!}
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
