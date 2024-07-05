@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.css"
        integrity="sha512-9zs/lLgSiSdORbrR57c8R8SUoYvTPzM9qBVl9nSIQQgXeE3jD3PVCxUD5LijF4yD3FY+rs8oQfs44LRBk11/2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .order_details_table tr {
            background-color: #26292c;
        }

        table.dataTable.hover>tbody>tr:hover>*,
        table.dataTable.display>tbody>tr:hover>* {
            box-shadow: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper  tab-one ">
        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title "> {{ __('dashboard/orders.orders') }}</h4>
                        <div class="row">
                            <div class="col-sm-6 form-group">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control daterange-cus" id="date_id">
                                </div>
                            </div>

                        </div>
                        <div class="table-responsive">
                            <table class="table display " id="cat">

                                <thead>


                                    <th></th>
                                    <th> {{ __('dashboard/orders.order_id') }} </th>
                                    <th> {{ __('dashboard/orders.client_name') }}</th>
                                    <th> {{ __('dashboard/orders.date_pur') }} </th>
                                    <th> {{ __('dashboard/orders.payment_method') }}</th>
                                    <th>{{ __('dashboard/orders.total') }}</th>
                                    <th> {{ __('dashboard/orders.status') }}</th>
                                    <th>Assigned drivers</th>
                                    <th>Driver</th>
                                    {{-- <th>{{ __('dashboard/orders.Store_name') }}</th> --}}
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="display:none">
        <div style="background: white;margin: 46px;padding: 50px;margin-top: 0;" id="receipt_id">
            <div style="    display: flex;flex-direction: row;justify-content: space-between;">
                <div><img style="width: 70px;" src="{{ URL::asset('assets/images_site/LOGO.png') }}" alt=""><b>TAD
                        Center</b></div>
                <div style="    display: flex;flex-direction: column;align-items: flex-end;align-items: center;">

                    <span>helo@TADCenter.com</span>
                    <span>+90 (000)000 00 0</span>
                </div>
            </div>
            <hr>


            <div class="order_div" id="inv_prouct">



            </div>



            <hr>
            <div class="order_total" style="    color: red;display: flex;justify-content: space-between;">
                <span style="">Total</span><span id="inv_total"></span>
            </div>
            <div style="text-align: center;margin-top: 100px;"><span id="inv_created"></span></div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.js"
        integrity="sha512-Fd3EQng6gZYBGzHbKd52pV76dXZZravPY7lxfg01nPx5mdekqS8kX4o1NfTtWiHqQyKhEGaReSf4BrtfKc+D5w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.3/daterangepicker.min.js"
        integrity="sha512-RVw+XaWNydMuPjPzSi5GlclhfvA0eAl+BbqRO0Q/IO3+bMB3NWdN6e/q/BYJrhPsHXNnxae4acHVaAOPtCphQA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--<script src="{{ URL::asset('assets/js_d/page/forms-advanced-forms.js') }}"></script>-->
    <script>
        function receipt_fun(id) {

            $.get('{{ route('dashboard.orders.getInvoice') }}', {
                order_id: id
            }, function(data) {
                console.log(data);
                //   var total=0;
                var str = ""
                for (var i = 0; i < data.length; i++) {
                    for (var i1 = 0; i1 < data[i].orders_products.length; i1++) {
                        str += `<div style="display: flex;justify-content: space-between;">
                        <span class="show_description_div" style="cursor: pointer;   width: 65%;">
                            ` + data[i].orders_products[i1].products_name + `<br>
                            <div style="    display: flex;font-size: 14px; ">`;
                        for (var i2 = 0; i2 < data[i].orders_products[i1].orders_products_att.length; i2++) {
                            str += `<small> ` + data[i].orders_products[i1].orders_products_att[i2].option + ' : ' +
                                data[i].orders_products[i1].orders_products_att[i2].val + ` |  </small> `;
                        }
                        str += `</div>
                        </span>
                        <span style="    color: #007bff;margin-left: 10px;font-size: 14px;">` + data[i]
                            .orders_products[i1].final_price + `X ` + data[i].orders_products[i1]
                            .products_quantity + `</span>
                    </div>`;
                    }
                    $('#inv_total').html(data[i].order_price);
                    $('#inv_created').html(data[i].created_at);

                }
                $('#inv_prouct').html(str);


                $("#receipt_id").printThis({
                    importCSSL: true,
                    importStyle: true,
                });
            }, 'json');
        }
        $(function() {

            $('#add-product-btn').click(function() {
                $('.add-product').slideDown(800);
            });
            $('#exit-product-btn').click(function() {
                $('.add-product').slideUp(800);
            });


        });
        @if (Session::get('errors'))
            {

                $('.add-product').slideDown(800);

            }
        @endif
        function open_add(id) {
            $('#div_' + id).slideDown(800);
        }

        function cancel_add(id) {
            $('#div_' + id).slideUp(800);
        }

        function open_driver(id) {
            $('#div_d_' + id).slideDown(800);
        }

        function cancel_driver(id) {
            $('#div_d_' + id).slideUp(800);
        }
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // console.log(d);
            var table =
                `

           <a href="./orders/show/${d.id}" target="_blank" class='btn btn-warning btn-fw '>
                                    {{ __('dashboard/orders.order_details') }}  </a>
                                    <button  class='btn btn-outline-warning btn-icon-text' onclick="open_add(${d.id})">{{ __('dashboard/orders.change_status') }}</button>`


            if (d.currents.status_id == 1)
                table += `       <button  class='btn btn-outline-warning btn-icon-text' onclick="open_driver(${d.id})">
                             {{ __('dashboard/driver.driv-select') }}

                               </button>`;



            table += ` <div class="row" id="div_${d.id}" style="display:none">
                            <div class="col-sm-12">

                                <form style="  background: white;  border: 1px solid #e4e6fc;padding: 20px;margin-top: 20px;" action={{ route('dashboard.orders.updateStatus') }} method=post >
                                    @csrf
                                    <input hidden name='id' value=${d.id}>
                                     <div class="row">
                            <div class="col-sm-6">
                            <label>{{ __('dashboard/orders.choose_status') }}  :</label>
                                            <select  class="form-control" name='orders_status' style='background-color:white;color:grey'>
                                                @foreach ($orders_status as $status)
                                                <option value="{{ $status->id }}"
                                                    @once
{{ 'selected' }} @endonce>
                                                    {{ $status->name }}</option>
                                                @endforeach
                                            </select>
                             </div>
                            <div class="col-sm-6">
                            <label>{{ __('dashboard/orders.comment') }}:</label><br>
                                            <input class="form-control"  type=text name='comments' ><br>
                             </div>
                            </div>



                                    <button type='submit' class='btn btn-outline-warning btn-icon-text'>
                                    <i class='mdi mdi-pencil btn-icon-prepend'></i>{{ __('dashboard/orders.Update') }}</button>
                                    <a  class='btn btn-outline-warning btn-icon-text' onclick="cancel_add(${d.id})">{{ __('dashboard/orders.Cancel') }}</a>
                                </form>
                            </div>

                            </div>
                        `;

            table += ` <div class="row" id="div_d_${d.id}" style="display:none">
                            <div class="col-sm-12">

                                <form style="  background: white;  border: 1px solid #e4e6fc;padding: 20px;margin-top: 20px;" action={{ route('dashboard.orders.driver') }} method=post >
                                    @csrf
                                    <input hidden name='order_id' value=${d.id}>
                                     <div class="row">
                            <div class="col-sm-6">
                            <label>   {{ __('dashboard/driver.driv-select') }}</label>
                                            <select  class="form-control" name='driver_id[]' style='background-color:white;color:grey;height:80px;' multiple>
                                                @foreach ($drivers as $driver)
                                                <option value={{ $driver->id }}
                                                    @once
                                                     {{ 'selected' }} @endonce>
                                                    {{ $driver->name }}</option>
                                                @endforeach
                                            </select>
                             </div>

                            </div>



                                    <button type='submit' class='btn btn-outline-warning btn-icon-text'>
                                    <i class='mdi mdi-pencil btn-icon-prepend'></i>
                                     {{ __('dashboard/driver.driv-assign') }}
                                    </button>
                                    <a  class='btn btn-outline-warning btn-icon-text' onclick="cancel_driver(${d.id})">{{ __('dashboard/orders.Cancel') }}</a>
                                </form>
                            </div>

                            </div>
                        `;

            return table;
        }
        var startDate;
        var endDate;
        $(document).ready(function() {
            $('.daterange-cus').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                drops: 'down',
                opens: 'right'
            });

            var date = $('#date_id').data('daterangepicker').startDate.format('YYYY-MM-DD');
            var date2 = $('#date_id').data('daterangepicker').endDate.format('YYYY-MM-DD');
            console.log(date);




            var table = $('#cat').DataTable({
                processing: true,
                searchable: true,
                info: true,
                lengthMenu: [5, 50, 100, 150],
                order: [
                    [0, "desc"]
                ],

                ajax: {
                    url: "{{ route('dashboard.orders.dataTable') }}",
                    data: {
                        date: date,
                        date2: date2,

                    }
                },
                columnDefs: [{
                        orderable: true,
                        className: 'reorder',
                        targets: 1
                    },
                    {
                        orderable: false,
                        targets: '_all'
                    }
                ],
                columns: [{
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },

                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'payment.method.name'
                    },
                    {
                        data: 'order_price'
                    },

                    {
                        render: (data, type, JsonResultRow, meta) => {
                            if (JsonResultRow.currents)
                                return JsonResultRow.currents.status_desc.name;
                            return '';
                        }

                    },
                    {
                            data: 'drivers'
                        },
                    {
                        render: (data, type, JsonResultRow, meta) => {
                            if (JsonResultRow.driver_id)
                                return JsonResultRow.driver_name.name;
                            return ' {{ __('dashboard/driver.driv-none') }}';
                        }

                    },

                ],

                order: [1, 'desc']

            });
            // Add event listener for opening and closing details
            $('#cat tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
            $('#date_id').on('change', function() {

                var date = $('#date_id').data('daterangepicker').startDate.format('YYYY-MM-DD');
                var date2 = $('#date_id').data('daterangepicker').endDate.format('YYYY-MM-DD');
                var store = $('#store_id').val();
                console.log(date);
                table.destroy();
                table = $('#cat').DataTable({
                    processing: true,
                    searchable: true,
                    info: true,
                    lengthMenu: [5, 50, 100, 150],
                    order: [
                        [0, "desc"]
                    ],

                    ajax: {
                        url: "{{ route('dashboard.orders.dataTable') }}",
                        data: {
                            date: date,
                            date2: date2,
                            store_id: store
                        }
                    },
                    columnDefs: [{
                            orderable: true,
                            className: 'reorder',
                            targets: 1
                        },
                        {
                            orderable: false,
                            targets: '_all'
                        }
                    ],
                    columns: [{
                            "className": 'dt-control',
                            "orderable": false,
                            "data": null,
                            "defaultContent": ''
                        },

                        {
                            data: 'id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'payment.method.name'
                        },
                        {
                            data: 'order_price'
                        },

                        {
                            render: (data, type, JsonResultRow, meta) => {
                                if (JsonResultRow.currents)
                                    return JsonResultRow.currents.status_desc.name;
                                return '';
                            }

                        },
                        {
                            data: 'drivers'
                        },
                        {
                            render: (data, type, JsonResultRow, meta) => {
                                if (JsonResultRow.driver_id)
                                    return JsonResultRow.driver_name.name;
                                return ' {{ __('dashboard/driver.driv-none') }}';
                            }

                        },

                    ],

                    order: [1, 'desc']
                    @if (LaravelLocalization::getCurrentLocale() == 'ar')
                        ,
                        language: {
                            url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                        }
                    @endif
                });
            });

        });
    </script>
@endsection
