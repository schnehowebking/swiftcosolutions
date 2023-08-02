@extends('layouts.admin')
@section('page-title')
    {{ __('Payslip') }}
@endsection

@section('action-button')
    @can('Create Pay Slip')
        {{ Form::open(['route' => ['payslip.store'], 'method' => 'POST', 'class' => 'w-50 float-left', 'id' => 'payslip_form']) }}
        <div class="row d-flex justify-content-end">
            <div class="col-xl-3 col-lg-3 col-md-6">
                <div class="btn-box">
                    {{ Form::label('month', __('Select Month'), ['class' => 'text-type col-form-label ']) }}
                    {{ Form::select('month', $month, null, ['class' => 'form-control month ']) }}
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6">
                <div class="btn-box">
                    {{ Form::label('year', __('Select Year'), ['class' => 'text-type col-form-label']) }}
                    {{ Form::select('year', $year, null, ['class' => 'form-control year ']) }}
                </div>
            </div>
            <div class="col-auto text-right payslip-btn">
                <a href="#" class="btn btn_width  btn-primary "
                    onclick="document.getElementById('payslip_form').submit(); return false;">
                    {{ __('Generate Payslip') }}
                </a>
            </div>
        </div>
        {{ Form::close() }}
    @endcan
@endsection
@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form>
                        <div class="d-flex justify-content-between w-100">
                            <h5>{{ __('Find Employee Payslip') }}</h5>
                            <div class="float-right col-4">
                                <select class="form-control month_date " name="year" tabindex="-1" aria-hidden="true">
                                    <option value="--">--</option>
                                    @foreach ($month as $k => $mon)
                                        <option value="{{ $k }}">{{ $mon }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="float-right col-4">
                                {{ Form::select('year', $year, null, ['class' => 'form-control year_date ']) }}
                            </div>
                            @can('Create Pay Slip')
                                <input type="button" value="{{ __('Bulk Payment') }}" class="btn btn-primary"
                                    id="bulk_payment">
                            @endcan
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-render-column-cells">
                            <thead>
                                <tr>
                                    <th>{{ __('Id') }}</th>
                                    <th>{{ __('Employee Id') }}</th>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Payroll Type') }}</th>
                                    <th>{{ __('Salary') }}</th>
                                    <th>{{ __('Net Salary') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ basic-table ] end -->
    </div>
@endsection

@push('script-page')
    <script>
        $(document).ready(function() {

            function callback() {
                var month = $(".month_date").val();
                var year = $(".year_date").val();

                var datePicker = year + '-' + month;

                $.ajax({
                    url: '{{ route('payslip.search_json') }}',
                    type: 'POST',
                    data: {
                        "datePicker": datePicker,
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function(data) {
                       

                        var datatable_data = {
                            data: data
                        };

                        function renderstatus(data, cell, row) {
                            if (data == 'Paid')
                                return '<div class="badge bg-success p-2 px-3 rounded"><a href="#" class="text-white">' +
                                    data + '</a></div>';
                            else
                                return '<div class="badge bg-danger p-2 px-3 rounded"><a href="#" class="text-white">' +
                                    data + '</a></div>';
                        }

                        function renderButton(data, cell, row) {

                            var $div = $(row);
                            employee_id = $div.find('td:eq(0)').text();
                            status = $div.find('td:eq(6)').text();

                            var month = $(".month_date").val();
                            var year = $(".year_date").val();
                            var id = employee_id;
                            var payslip_id = data;


                            var clickToPaid = '';
                            var payslip = '';
                            var view = '';
                            var edit = '';
                            var deleted = '';
                            var form = '';

                            if (data != 0) {
                                var payslip =
                                    '<a href="#" data-url="{{ url('payslip/pdf/') }}/' + id +
                                    '/' + datePicker +
                                    '" data-size="md-pdf"  data-ajax-popup="true" class="view-btn yellow-bg" data-title="{{ __('Employee Payslip') }}">' +
                                    '{{ __('Payslip') }}' + '</a> ';
                            }

                            if (status == "UnPaid" && data != 0) {
                                clickToPaid = '<a href="{{ url('payslip/paysalary/') }}/' + id +
                                    '/' + datePicker + '"  class="view-btn green-bg">' +
                                    '{{ __('Click To Paid') }}' + '</a>  ';
                            }

                            if (data != 0) {
                                view =
                                    '<a href="#" data-url="{{ url('payslip/showemployee/') }}/' +
                                    payslip_id +
                                    '"  data-ajax-popup="true" class="view-btn gray-bg" data-title="{{ __('View Employee Detail') }}">' +
                                    '{{ __('View') }}' + '</a>';
                            }

                            if (data != 0 && status == "UnPaid") {
                                edit =
                                    '<a href="#" data-url="{{ url('payslip/editemployee/') }}/' +
                                    payslip_id +
                                    '"  data-ajax-popup="true" class="view-btn blue-bg" data-title="{{ __('Edit Employee salary') }}">' +
                                    '{{ __('Edit') }}' + '</a>';
                            }

                            var url = '{{ route('payslip.delete', ':id') }}';
                            url = url.replace(':id', payslip_id);

                            @if (\Auth::user()->type != 'employee')
                                if (data != 0) {
                                    deleted = '<a href="#"  data-url="' + url +
                                        '" class="payslip_delete view-btn red-bg" >' +
                                        '{{ __('Delete') }}' + '</a>';
                                }
                            @endif

                            return view + payslip + clickToPaid + edit + deleted + form;
                        }

                        console.log(data);
                        $('#pc-dt-render-column-cells').remove();

                        if (data.length > 0) {
                            var dataTable = new simpleDatatables.DataTable(
                                "#pc-dt-render-column-cells", {
                                    data: datatable_data,
                                    perPage: 25,
                                    columns: [{
                                            select: 0,
                                            hidden: true
                                        },
                                        {
                                            select: 6,
                                            render: renderstatus
                                        },
                                        {
                                            select: 7,
                                            render: renderButton
                                        }
                                    ]
                                }
                            );


                            $('[data-toggle="tooltip"]').tooltip();

                            if (!(data)) {
                                show_toastr('error',
                                    'Employee payslip not found ! please generate first.',
                                    'error');
                            }
                        } else {

                            var dataTable = new simpleDatatables.DataTable(
                                "#pc-dt-render-column-cells", {
                                    data: ''
                                }
                            );

                        }
                        dataTable.on("datatable.init");


                    },
                    error: function(data) {

                    }

                });

            }

            $(document).on("change", ".month_date,.year_date", function() {
                callback();
            });

            //bulkpayment Click
            $(document).on("click", "#bulk_payment", function() {
                var month = $(".month_date").val();
                var year = $(".year_date").val();
                var datePicker = year + '_' + month;


            });
            $(document).on('click', '#bulk_payment',
                'a[data-ajax-popup="true"], button[data-ajax-popup="true"], div[data-ajax-popup="true"]',
                function() {
                    var month = $(".month_date").val();
                    var year = $(".year_date").val();
                    var datePicker = year + '-' + month;

                    var title = 'Bulk Payment';
                    var size = 'md';
                    var url = 'payslip/bulk_pay_create/' + datePicker;

                    // return false;

                    $("#commonModal .modal-title").html(title);
                    $("#commonModal .modal-dialog").addClass('modal-' + size);
                    $.ajax({
                        url: url,
                        success: function(data) {

                            // alert(data);
                            // return false;
                            if (data.length) {
                                $('#commonModal .modal-body').html(data);
                                $("#commonModal").modal('show');
                                // common_bind();
                            } else {
                                show_toastr('Error', 'Permission denied.');
                                $("#commonModal").modal('hide');
                            }
                        },
                        error: function(data) {
                            data = data.responseJSON;
                            show_toastr('Error', data.error);
                        }
                    });
                });

            $(document).on("click", ".payslip_delete", function() {
                var confirmation = confirm("are you sure you want to delete this payslip?");
                var url = $(this).data('url');
                if (confirmation) {
                    $.ajax({
                        type: "GET",
                        url: url,
                        dataType: "JSON",
                        success: function(data) {

                            show_toastr('Success', 'Payslip successfully deleted', 'success');

                            setTimeout(function() {
                                location.reload();
                            }, 800)


                        },

                    });

                }
            });
        });
        // const data = {
        //     headings: ['ID', 'Drink', 'Price', 'Caffeinated', 'Profit'],
        //     // data: [
        //     //     [574, 'latte', 4.00, false, 0.00],
        //     //     [984, 'herbal tea', 3.00, false, 0.56],
        //     //     [312, 'green tea', 3.00, true, 1.72],
        //     //     [312, 'latte', 3.00, true, -1.21],
        //     //     [312, 'green tea', 3.00, false, 0.00],
        //     //     [312, 'green tea', 3.00, false, 0.00],
        //     //     [312, 'green tea', 3.00, true, 1.72],
        //     //     [312, 'latte', 3.00, true, 1.72],
        //     //     [312, 'green tea', 3.00, true, -1.21],
        //     //     [312, 'green tea', 3.00, false, 0.00],
        //     //     [312, 'green tea', 3.00, true, 1.72],
        //     //     [312, 'green tea', 3.00, true, 1.72],
        //     //     [312, 'latte', 3.00, false, 0.00],
        //     //     [312, 'latte', 3.00, true, 1.72],
        //     //     [312, 'green tea', 3.00, false, 0.00],
        //     //     [312, 'green tea', 3.00, true, 1.72],
        //     //     [312, 'latte', 3.00, false, 0.00],
        //     //     [312, 'latte', 3.00, true, -1.21],
        //     //     [312, 'latte', 3.00, true, 1.72],
        //     //     [312, 'latte', 3.00, false, 0.00],
        //     //     [312, 'latte', 3.00, false, 0.00],
        //     //     [312, 'latte', 3.00, true, 1.72],
        //     //     [312, 'green tea', 3.00, true, -1.21],
        //     //     [312, 'green tea', 3.00, true, -1.21],
        //     //     [312, 'green tea', 3.00, true, -1.21],
        //     // ]
        // };

        // Add Icon


        // Price column cell manipulation
        // function renderButton(data, cell, row) {
        //     return `${data}<button class="btn btn-success btn-sm ms-3" data-row="${row.dataIndex}">Buy Now</button>`;
        // }

        // Caffeinated column cell manipulation
        // function renderYesNo(data, cell, row) {
        //     if (data == 'true') {
        //         return row.classList.add("text-success"), `<b>Yes</b>`;
        //     } else if (data == 'false') {
        //         return row.classList.add("text-danger"), `<b>No</b>`;
        //     }
        // }

        // numbers
        // function renderHighLow(data, type, full) {
        //     if (data < 0) {
        //         return `<span class="text-danger">${data}</span>`;
        //     } else if (data > 0) {
        //         return `<span class="text-success">${data}</span>`;
        //     } else if (data == 0) {
        //         return `<span class="text-body">${data}</span>`;
        //     }


        // }

        // var table = new simpleDatatables.DataTable("#pc-dt-render-column-cells", {
        //     // data: data,
        //     perPage: 25,
        //     columns: [{
        //             select: 0,
        //             hidden: true
        //         },
        //         {
        //             select: 1,
        //             // render: renderIcon
        //         },
        //         {
        //             select: 2,
        //             // render: renderButton
        //         },
        //         {
        //             select: 3,
        //             // render: renderYesNo
        //         },
        //         {
        //             select: 4,
        //             // render: renderHighLow
        //         } 


        //     ]
        // });
    </script>
@endpush
