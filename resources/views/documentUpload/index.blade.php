@extends('layouts.admin')

@section('page-title')
   {{ __('Manage Document') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item">{{ __('Document') }}</li>
@endsection

@section('action-button')
   @can('Create Document')
        <a href="#" data-url="{{ route('document-upload.create') }}" data-ajax-popup="true"
            data-title="{{ __('Create New  Document Type') }}" data-size="lg" data-bs-toggle="tooltip" title="" class="btn btn-sm btn-primary"
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
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Document') }}</th>
                                <th>{{ __('Role') }}</th>
                                <th>{{ __('Description') }}</th>
                                @if (Gate::check('Edit Document') || Gate::check('Delete Document'))
                                    <th width="200px">{{ __('Action') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documents as $document)
                               
                                <tr>
                                    <td>{{ $document->name }}</td>
                                    <td>
                                        @php
                                            $documentPath=\App\Models\Utility::get_file('uploads/documentUpload');
                                            $roles = \Spatie\Permission\Models\Role::find($document->role);
                                       @endphp
                                        @if (!empty($document->document))
                                        <div class="action-btn bg-primary ms-2">
                                            <a class="mx-3 btn btn-sm align-items-center" href="{{ $documentPath . '/' . $document->document }}" download>
                                                <i class="ti ti-download text-white"></i>
                                            </a>
                                        </div>
                                            <div class="action-btn bg-secondary ms-2">
                                                <a class="mx-3 btn btn-sm align-items-center" href="{{ $documentPath . '/' . $document->document }}" target="_blank"  >
                                                    <i class="ti ti-crosshair text-white" data-bs-toggle="tooltip" data-bs-original-title="{{ __('Preview') }}"></i>
                                                </a>
                                            </div>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </td>
                                    <td>{{ !empty($roles) ? $roles->name : 'All' }}</td>
                                    <td>
                                        <p style="white-space: nowrap;
                                            width: 200px;
                                            overflow: hidden;
                                            text-overflow: ellipsis;">{{ $document->description }}
                                        </p>
                                    </td>
                                    <td class="Action">
                                        <span>
                                            @can('Edit Document')
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm  align-items-center"
                                                        data-url="{{  route('document-upload.edit', $document->id) }}"
                                                        data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Document') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil text-white"></i>
                                                    </a>
                                                </div>
                                            @endcan

                                            @can('Delete Document')
                                                <div class="action-btn bg-danger ms-2">
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['document-upload.destroy', $document->id], 'id' => 'delete-form-' . $document->id]) !!}
                                                    <a href="#" data-size="lg" class="mx-3 btn btn-sm  align-items-center bs-pass-para"
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
