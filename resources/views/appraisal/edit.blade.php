{{ Form::model($appraisal, ['route' => ['appraisal.update', $appraisal->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('branch', __('Branch*'), ['class' => 'col-form-label']) }}
                <select name="brances" id="brances" required class="form-control ">
                    @foreach ($brances as $value)
                        <option  value="{{ $value->id   }}" @if ($appraisal->branch == $value->id) selected @endif>{{ $value->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('employees', __('Employee*'), ['class' => 'col-form-label']) }}
                <div class="employee_div">
                    <select name="employees" id="employee" class="form-control " required>
                        
                    </select>
                 </div>

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('appraisal_date', __('Select Month*'), ['class' => 'col-form-label']) }}
                {{ Form::text('appraisal_date', null, ['class' => 'form-control d_filter' ,'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('remark', __('Remarks'), ['class' => 'col-form-label']) }}
                {{ Form::textarea('remark', null, ['class' => 'form-control', 'rows' => '3']) }}
            </div>
        </div>
    </div>
    <div class="row"  id="stares">
   
</div>



<div class="modal-footer">
    <input type="button" value="Cancel" class="btn btn-light" data-bs-dismiss="modal">
<input type="submit" value="{{ __('Update') }}" class="btn btn-primary">
</div>
{{ Form::close() }}



<script>
        
    $('#employee').change(function(){
        
        var emp_id = $('#employee').val();
        $.ajax({
            url: "{{ route('empByStar') }}",
            type: "post",
            data:{
                "employee": emp_id,
                "_token": "{{ csrf_token() }}",
            },
            
            cache: false,
            success: function(data) {
                
                $('#stares').html(data.html);
            }
        })
    });
</script>

<script>
    var branch_ids = '{{ $appraisal->branch}}';
    var employee_id = '{{ $appraisal->employee}}';
    var appraisal_id = '{{ $appraisal->id}}';



    $( document ).ready(function() {
        $.ajax({
                url: "{{ route('getemployee') }}",
                type: "post",
                data:{
                    "branch_id": branch_ids,
                    "_token": "{{ csrf_token() }}",
                },

                cache: false,
                success: function(data) {

                    $('#employee').html('<option value="">Select Employee</option>');
                    $.each(data.employee, function (key, value) {
                        if(value.id == {{ $appraisal->employee }}){
                            $("#employee").append('<option  selected value="' + value.id + '">' + value.name + '</option>');
                        }else{
                            $("#employee").append('<option value="' + value.id + '">' + value.name + '</option>');
                        }
                    });
                }
            })

            $.ajax({
                url: "{{ route('empByStar1') }}",
                type: "post",
                data:{
                    "employee": employee_id,
                    "appraisal": appraisal_id,

                    "_token": "{{ csrf_token() }}",
                },
                
                cache: false,
                success: function(data) {
                    
                    $('#stares').html(data.html);
                }
            })

        });

    $('#brances').on('change', function() {
        var branch_id = this.value;

        $.ajax({
                url: "{{ route('getemployee') }}",
                type: "post",
                data:{
                    "branch_id": branch_id,
                    "_token": "{{ csrf_token() }}",
                },

                cache: false,
                success: function(data) {

                    $('#employee').html('<option value="">Select Employee</option>');
                    $.each(data.employee, function (key, value) {
                        $("#employee").append('<option value="' + value.id + '">' + value.name + '</option>');
                    });

                }
            })
        });


</script>
