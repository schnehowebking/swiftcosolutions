
    {{ Form::open(['url' => 'company-policy', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('branch', __('Branch'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::select('branch', $branch, null, ['class' => 'form-control select2', 'required' => 'required']) }}
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="form-group">
                    {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
                    <div class="form-icon-user">
                        {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Company Policy Title')]) }}
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

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    {{ Form::label('attachment', __('Attachment'), ['class' => 'col-form-label']) }}
                    <!-- <div class="form-icon-user">
                        <label for="attachment" class="form-label choose-files bg-primary "><i
                                class="ti ti-upload px-1"></i>{{ __('Choose file here') }}</label>
                        <input type="file" name="attachment" id="attachment" class="custom-input-file d-none">
                    </div> --> 
                    <div class="choose-files ">
                        <label for="attachment">
                            <div class=" bg-primary attachment "> <i
                                    class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                            </div>
                            <input type="file" class="form-control file" name="attachment" id="attachment" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <img id="blah"  width="100" src="" />
                        </label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
        <input type="submit" value="{{ __('Create') }}" class="btn btn-primary">
    </div>
    {{ Form::close() }}
