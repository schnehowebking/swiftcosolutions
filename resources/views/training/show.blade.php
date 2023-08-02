 @extends('layouts.admin')
 @section('page-title')
     {{ __('Trainig Details') }}
 @endsection

 @section('breadcrumb')
     <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
     <li class="breadcrumb-item"><a href="{{ route('training.index') }}">{{ __('Training List') }}</a></li>
     <li class="breadcrumb-item">{{ __('Trainig Details') }}</li>
 @endsection
 @section('content')
     <div class="col-md-4">
         <div class="card">
             <div class="card-body table-border-style">
                 <div class="table-responsive ">
                     <table class="table ">
                         <tbody>
                             <tr>
                                 <td>{{ __('Training Type') }}</td>
                                 <td class="text-right">{{ !empty($training->types) ? $training->types->name : '' }}
                                 </td>
                             </tr>
                             <tr>
                                 <td>{{ __('Trainer') }}</td>
                                 <td class="text-right">
                                     {{ !empty($training->trainers) ? $training->trainers->firstname : '--' }}</td>
                             </tr>
                             <tr>
                                 <td>{{ __('Training Cost') }}</td>
                                 <td class="text-right">{{ \Auth::user()->priceFormat($training->training_cost) }}
                                 </td>
                             </tr>
                             <tr>
                                 <td>{{ __('Start Date') }}</td>
                                 <td class="text-right">{{ \Auth::user()->dateFormat($training->start_date) }}</td>
                             </tr>
                             <tr>
                                 <td>{{ __('End Date') }}</td>
                                 <td class="text-right">{{ \Auth::user()->dateFormat($training->end_date) }}</td>
                             </tr>
                             <tr>
                                 <td>{{ __('Date') }}</td>
                                 <td class="text-right">{{ \Auth::user()->dateFormat($training->created_at) }}</td>
                             </tr>
                         </tbody>
                     </table>
                     <div class="text-sm mt-4 p-2"> {{ $training->description }}</div>
                 </div>
             </div>
         </div>
     </div>
     <div class="col-md-8">
         <div class="card">
             <div class="card-header card-body">
                 <div class="row">
                     <div class="col-md-12">
                         <h6>{{ __('Training Employee') }}</h6>
                         <hr>
                         <ul class="list-group list-group-flush">
                             <li class="list-group-item" style="border:0px;">
                                 <div class="d-flex align-items-center">
                                     <a href="{{ !empty($training->employees) ? (!empty($training->employees->user->avatar) ? asset(Storage::url('uploads/avatar')) . '/' . $training->employees->user->avatar : asset(Storage::url('uploads/avatar')) . '/avatar.png') : asset(Storage::url('uploads/avatar')) . '/avatar.png' }}" target="_blank">
                                     <img src="{{ !empty($training->employees) ? (!empty($training->employees->user->avatar) ? asset(Storage::url('uploads/avatar')) . '/' . $training->employees->user->avatar : asset(Storage::url('uploads/avatar')) . '/avatar.png') : asset(Storage::url('uploads/avatar')) . '/avatar.png' }}"
                                         class="user-image-hr-prj ui-w-30 rounded-circle" width="50px" height="50px">
                                     </a>
                                     <div class="media-body px-2 text-sm">
                                         <a href="{{ route('employee.show', !empty($training->employees) ? \Illuminate\Support\Facades\Crypt::encrypt($training->employees->id) : 0) }}"
                                             class="text-dark">
                                             {{ !empty($training->employees) ? $training->employees->name : '' }}
                                        
                                         {{ !empty($training->employees) ? (!empty($training->employees->designation) ? $training->employees->designation->name : '') : '' }}
                                          </a>
                                         <br>
                                     </div>
                                 </div>
                             </li>
                         </ul>
                     </div>
                 </div>
                <div class="row">
                    {{ Form::model($training, ['route' => ['training.status', $training->id], 'method' => 'post']) }}
                         <h6>{{ __('Update Status') }}</h6>
                         <hr>
                        <div class="row col-md-12">
                            <div class="col-md-6">
                                <input type="hidden" value="{{ $training->id }}" name="id">
                                <div class="form-group">
                                 {{ Form::label('performance', __('Performance'), ['class' => 'col-form-label text-dark']) }}
                                 {{ Form::select('performance', $performance, null, ['class' => 'form-control select']) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                {{ Form::label('status', __('Status'), ['class' => 'col-form-label text-dark']) }}
                                {{ Form::select('status', $status, null, ['class' => 'form-control select']) }}
                                </div>
                            </div>
                        </div>
                        <div class="row col-md-12">

                        <div class="form-group">
                             {{ Form::label('remarks', __('Remarks'), ['class' => 'col-form-label text-dark']) }}
                             {{ Form::textarea('remarks', null, ['class' => 'form-control', 'placeholder' => __('Remarks'), 'rows' => '3']) }}
                        </div>
                        <div class="form-group text-end">
                            <input type="submit" value="{{ __('Save') }}" class="btn  btn-primary">
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
 @endsection
