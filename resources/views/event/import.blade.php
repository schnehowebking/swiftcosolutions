<div class="col-form-label">
    {{ Form::open(['route' => ['event.import'], 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
    <div class="row">
        <div class="col-md-12 mb-2 d-flex align-items-center justify-content-between">
            {{ Form::label('file', __('Download sample customer CSV file'), ['class' => 'col-form-label']) }}
            <a href="{{ asset(Storage::url('uploads/sample')) . '/sample-event.csv' }}"
            data-bs-toggle="tooltip" data-bs-placement="bottom"
            title="{{ __('Download') }}"  class="action-btn btn-primary me-1 btn btn-sm d-inline-flex align-items-center">
                <i class="fa fa-download"></i> {{ __('Download') }}
            </a>
        </div>
        <div class="col-md-12">
            {{ Form::label('file', __('Select CSV File'), ['class' => 'col-form-label']) }}
            <div class="choose-file form-group">
                <label for="file" class="col-form-label">
                    <div>{{ __('Choose file here') }}</div>
                    <input type="file" class="form-control" name="file" id="file" data-filename="upload_file" required>
                </label>
                <p class="upload_file"></p>
            </div>
        </div>
        <div class="col-md-12 mt-2 text-right">
            <input type="submit" value="{{ __('Upload') }}"
                class="btn color_blue line_height_auto text-white border-none">
            <input type="button" value="{{ __('Cancel') }}"
                class="btn color_secondary line_height_auto border-none text-white" data-bs-dismiss="modal">
        </div>
    </div>
    {{ Form::close() }}
</div>
