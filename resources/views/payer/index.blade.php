@extends('layouts.admin')
@section('page-title')
    {{ __('Payer') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Payer') }}</li>
@endsection

@section('action-button')
    @can('Create Payer')
        <a href="#" data-url="{{ route('payer.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Payer') }}"
            data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary" data-bs-original-title="{{ __('Create') }}">
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
                        <tr>
                            <th>{{ __('Payer Name') }}</th>
                            <th>{{ __('Contact Number') }}</th>
                            <th width="200px">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($payers as $payer)
                                <tr>
                                    <td>{{ $payer->payer_name }}</td>
                                    <td>{{ $payer->contact_number }}</td>
                                    <td class="Action">

                                        <span>
                                            @can('Edit Payer')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{ URL::to('payer/' . $payer->id . '/edit') }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Payer') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('Delete Payer')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['payer.destroy', $payer->id], 'id' => 'delete-form-' . $payer->id]) !!}
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
                                                        data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"
                                                        aria-label="Delete"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    </form>
                                                </div>
                                            @endcan
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
