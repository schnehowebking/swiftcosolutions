{{ Form::model($ducumentUpload, ['route' => ['document-upload.update', $ducumentUpload->id],'method' => 'PUT','enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Company Policy Title')]) }}
                </div>

            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('document', __('Document'), ['class' => 'col-form-label']) }}
                <div class="choose-files ">
                    <label for="document">
                        <div class=" bg-primary document "> <i
                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                        </div>
                        @php
                            $documentPath=\App\Models\Utility::get_file('uploads/documentUpload/');
                            $logo=\App\Models\Utility::get_file('uploads/uploadDocument');
                        @endphp
                        <input style="margin-top: -50px" type="file" class="form-control file" name="documents"  onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img id="blah" class="mt-3" alt="your image" width="100" src="@if($ducumentUpload->document){{$documentPath.$ducumentUpload->document}} @else {{$logo.'document.png'}} @endif"/>
                    </label>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="form-group">
                {{ Form::label('role', __('Role'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::select('role', $roles, null, ['class' => 'form-control select2', 'required' => 'required']) }}
                </div>
            </div>
        </div>

        

        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="form-group">
                {{ Form::label('description', __('Description'), ['class' => 'form-label']) }}
                <div class="form-icon-user">
                    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '3']) }}
                </div>
            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}
