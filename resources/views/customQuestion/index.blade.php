@extends('layouts.admin')

@section('page-title')
    {{ __('Manage Custom Question for interview') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Custom Question') }}</li>
@endsection

@section('action-button')
        @can('Create Custom Question')
                {{-- <a href="#" data-url="{{ route('custom-question.create') }}"
                    class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center" data-ajax-popup="true"
                    data-bs-toggle="tooltip" data-bs-placement="bottom"
                    title="{{ __('Create') }}"    data-title="{{ __('Create New Custom Question') }}">
                    <i class=" ti ti-plus"></i>
                </a> --}}


                <a href="#" data-url="{{route('custom-question.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New Custom Question') }}" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
            data-bs-original-title="{{ __('Create') }}">
            <i class="ti ti-plus"></i>
        </a>
        @endcan
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
                            <th>{{ __('Question') }}</th>
                            <th>{{ __('Is Required?*') }}</th>
                            <th width="200px">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($questions as $question)
                            <tr>
                                <td>{{ $question->question }}</td>
                                <td>
                                    @if ($question->is_required == 'yes')
                                        <span
                                            class="badge bg-success p-2 px-3 rounded">{{ \App\models\CustomQuestion::$is_required[$question->is_required] }}</span>
                                    @else
                                        <span
                                            class="badge bg-danger p-2 px-3 rounded">{{ \App\models\CustomQuestion::$is_required[$question->is_required] }}</span>
                                    @endif
                                </td>
                                <td class="Action">
                                    <span>
                                        @can('Edit Custom Question')
                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                    data-url="{{ route('custom-question.edit', $question->id)}}"
                                                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                    data-title="{{ __('Edit Custom Question') }}"
                                                    data-bs-original-title="{{ __('Edit') }}">
                                                    <i class="ti ti-pencil text-white"></i>
                                                </a>
                                            </div>
                                        @endcan

                                        @can('Delete Custom Question')
                                            <div class="action-btn bg-danger ms-2">
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['custom-question.destroy', $question->id], 'id' => 'delete-form-' . $question->id]) !!}
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

