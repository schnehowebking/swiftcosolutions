@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Award') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Award') }}</li>
@endsection

@section('action-button')
    
    @can('Create Award')
        <a href="#" data-url="{{ route('award.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Award') }}" data-size="lg"
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
                        <thead>
                            <tr>
                                @role('company')
                                    <th>{{ __('Employee') }}</th>
                                @endrole
                                <th>{{ __('Award Type') }}</th>
                                <th>{{ __('Date') }}</th>
                                <th>{{ __('Gift') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Award') || Gate::check('Delete Award'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($awards as $award)
                                <tr>
                                    @role('company')
                                        <td>{{ !empty($award->employee()) ? $award->employee()->name : '' }}</td>
                                    @endrole
                                    <td>{{ !empty($award->awardType()) ? $award->awardType()->name : '' }}</td>
                                    <td>{{ \Auth::user()->dateFormat($award->date) }}</td>
                                    <td>{{ $award->gift }}</td>
                                    <td>{{ $award->description }}</td>
                                    <td class="Action">
                                        @if (Gate::check('Edit Award') || Gate::check('Delete Award'))
                                            <span>
                                                @can('Edit Award')
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="#" class="mx-3 btn btn-sm  align-items-center" data-size="lg"
                                                            data-url="{{ URL::to('award/' . $award->id . '/edit') }}"
                                                            data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                            title="" data-title="{{ __('Edit Award') }}"
                                                            data-bs-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                @endcan

                                                @can('Delete Award')
                                                    <div class="action-btn bg-danger ms-2">
                                                        {!! Form::open(['method' => 'DELETE', 'route' => ['award.destroy', $award->id], 'id' => 'delete-form-' . $award->id]) !!}
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
