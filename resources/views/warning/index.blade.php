@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Warning') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Warning') }}</li>
@endsection

@section('action-button')
    @can('Create Warning')
        <a href="#" data-url="{{ route('warning.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Warning') }}" data-size="lg" data-bs-toggle="tooltip" title=""
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
                                <th>{{ __('Warning By') }}</th>
                                <th>{{ __('Warning To') }}</th>
                                <th>{{ __('Subject') }}</th>
                                <th>{{ __('Warning Date') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Warning') || Gate::check('Delete Warning'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($warnings as $warning)
                                <tr>
                                    <td>{{ !empty($warning->WarningBy($warning->warning_by)) ? $warning->WarningBy($warning->warning_by)->name : '' }}
                                    </td>
                                    <td>{{ !empty($warning->warningTo($warning->warning_to)) ? $warning->warningTo($warning->warning_to)->name : '' }}
                                    </td>
                                    <td>{{ $warning->subject }}</td>
                                    <td>{{ \Auth::user()->dateFormat($warning->warning_date) }}</td>
                                    <td>{{ $warning->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Warning') || Gate::check('Delete Warning'))
                                            <span>
                                                @can('Edit Warning')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('warning/' . $warning->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Warning') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Warning')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['warning.destroy', $warning->id], 'id' => 'delete-form-' . $warning->id]) !!}
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
