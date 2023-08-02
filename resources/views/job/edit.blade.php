@extends('layouts.admin')
@section('page-title')
    {{ __('Edit Job') }}
@endsection
@push('css-page')

    <link href="{{ asset('public//libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
@endpush
@push('script-page')
<script src='{{ asset('assets/js/plugins/tinymce/tinymce.min.js') }}'></script>
    <script src="{{ asset('public/libs/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>

    <script>
        var e = $('[data-toggle="tags"]');
        e.length && e.each(function() {
            $(this).tagsinput({
                tagClass: "badge badge-primary"
            })
        });
    </script>

@endpush



@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job.index') }}">{{ __('Manage Job') }}</a></li>
    <li class="breadcrumb-item">{{ __('Edit Job') }}</li>
@endsection

@section('content')
       {{Form::model($job,array('route' => array('job.update', $job->id), 'method' => 'PUT')) }}
    <div class="row">
        <div class="col-md-6 ">
            <div class="card card-fluid job2-card">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('title', __('Job Title'),['class'=>'form-label']) !!}
                            {!! Form::text('title', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('branch', __('Branch'),['class'=>'form-label']) !!}
                            {{ Form::select('branch', $branches,null, array('class' => 'form-control select','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('category', __('Job Category'),['class'=>'form-label']) !!}
                            {{ Form::select('category', $categories,null, array('class' => 'form-control select','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('position', __('No. of Positions*'),['class'=>'form-label']) !!}
                            {!! Form::text('position', null, ['class' => 'form-control','required' => 'required']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('status', __('Status'),['class'=>'form-label']) !!}
                            {{ Form::select('status', $status,null, array('class' => 'form-control select','required'=>'required')) }}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('start_date', __('Start Date'),['class'=>'form-label']) !!}
                            {!! Form::date('start_date', null, ['class' => 'form-control ', 'autocomplete' => 'off']) !!}
                        </div>
                        <div class="form-group col-md-6">
                            {!! Form::label('end_date', __('End Date'),['class'=>'form-label']) !!}
                            {!! Form::date('end_date', null, ['class' => 'form-control ', 'autocomplete' => 'off']) !!}
                        </div>

                        <div class="form-group col-md-12">
                             <label class="col-form-label" for="skill">{{ __('Skill Box') }}</label>
                            <input type="text" class="form-control" value="{{$job->skill}}" data-toggle="tags" name="skill" placeholder="Skill"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="card card-fluid job2-card">
                <div class="card-body ">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>{{__('Need to ask* ?')}}</h6>
                                <div class="my-4">
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="applicant[]" value="gender" id="check-gender" {{(in_array('gender',$job->applicant)?'checked':'')}}>
                                        <label class="form-check-label" for="check-gender">{{__('Gender')}} </label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="applicant[]" value="dob" id="check-dob" {{(in_array('dob',$job->applicant)?'checked':'')}}>
                                        <label class="form-check-label" for="check-dob">{{__('Date Of Birth')}}</label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="applicant[]" value="address" id="check-address" {{(in_array('address',$job->applicant)?'checked':'')}}>
                                        <label class="form-check-label" for="check-address">{{__('Address')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <h6>{{__('Need to show option* ?')}}</h6>
                                <div class="my-4">
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="visibility[]" value="profile" id="check-profile" {{(in_array('profile',$job->visibility)?'checked':'')}}>
                                        <label class="form-check-label" for="check-profile">{{__('Profile Image')}} </label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="visibility[]" value="resume" id="check-resume" {{(in_array('resume',$job->visibility)?'checked':'')}}>
                                        <label class="form-check-label" for="check-resume">{{__('Resume')}}</label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="visibility[]" value="letter" id="check-letter" {{(in_array('letter',$job->visibility)?'checked':'')}}>
                                        <label class="form-check-label" for="check-letter">{{__('Cover Letter')}}</label>
                                    </div>
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="visibility[]" value="terms" id="check-terms" {{(in_array('terms',$job->visibility)?'checked':'')}}>
                                        <label class="form-check-label" for="check-terms">{{__('Terms And Conditions')}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <h6>{{__('Custom Questions*')}}</h6>
                            <div class="my-4">
                                @foreach($customQuestion as $question)
                                    <div class="form-check custom-checkbox">
                                        <input type="checkbox" class="form-check-input" name="custom_question[]" value="{{$question->id}}" @if($question->is_required == 'yes') required @endif id="custom_question_{{$question->id}}" {{(in_array($question->id,$job->custom_question)?'checked':'')}}>
                                        <label class="form-check-label" for="custom_question_{{$question->id}}">{{$question->question}}@if ($question->is_required == 'yes')
                                            <span class="text-danger">*</span>
                                        @endif </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-fluid job2-card">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('description', __('Job Description'),['class'=>'form-label']) !!}
                            <textarea class="form-control editor " name="description" id="description" rows="17">{{$job->description}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-fluid job2-card">
                <div class="card-body ">
                    <div class="row">
                        <div class="form-group col-md-12">
                            {!! Form::label('requirement', __('Job Requirement'),['class'=>'form-label']) !!}
                            <textarea class="form-control editor " name="requirement" id="requirement" rows="10">{{$job->requirement}}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-end">
            <div class="form-group">
                <input type="submit" value="{{__('Update')}}" class="btn btn-primary">
            </div>
        </div>
        {{Form::close()}}
    </div>


@endsection
