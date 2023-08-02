{!! Form::open(['route' => 'user.store', 'method' => 'post']) !!}
<div class="modal-body">
    <div class="row">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Enter Name']) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('email', __('Email'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::text('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder'=>'Enter Email']) !!}
            </div>
        </div>
        <div class="form-group">
            {{ Form::label('password', __('Password'), ['class' => 'form-label']) }}
            <div class="form-icon-user">
                {!! Form::password('password', ['class' => 'form-control', 'required' => 'required','placeholder'=>'Enter password']) !!}
            </div>
        </div>
        @if (\Auth::user()->type != 'super admin')
            <div class="form-group">
                {{ Form::label('role', __('User Role'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {!! Form::select('role', $roles, null, ['class' => 'form-control select2 ', 'required' => 'required']) !!}
                </div>
                @error('role')
                    <span class="invalid-role" role="alert">
                        <strong class="text-danger">{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Create') }}" class="btn  btn-primary">

</div>
{!! Form::close() !!}

