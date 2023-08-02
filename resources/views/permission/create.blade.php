{{Form::open(array('url'=>'permissions','method'=>'post'))}}
<div class="card-body p-0">
    <div class="form-group">
        {{Form::label('name',__('Name'))}}
        {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Permission Name')))}}
        @error('name')
        <span class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
        @enderror
    </div>
    <div class="form-group">
        @if(!$roles->isEmpty())
            <h6>{{__('Assign Permission to Roles')}}</h6>
            @foreach ($roles as $role)
                <div class="custom-control custom-checkbox">
                    {{Form::checkbox('roles[]',$role->id,false, ['class'=>'custom-control-input','id' =>'role'.$role->id])}}
                    {{Form::label('role'.$role->id, __(ucfirst($role->name)),['class'=>'custom-control-label '])}}
                </div>
            @endforeach
        @endif
        @error('roles')
        <span class="invalid-roles" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="modal-footer pr-0">
    <button type="button" class="btn dark btn-outline" data-bs-dismiss="modal">{{__('Cancel')}}</button>
    {{Form::submit(__('Create'),array('class'=>'btn btn-primary'))}}
</div>
{{Form::close()}}
