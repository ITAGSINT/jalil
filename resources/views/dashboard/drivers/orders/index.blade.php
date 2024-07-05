@extends('layouts.Dashboard.main')

@section('additional_styles')
    <style>
        #cat_length label,
        #cat_length select,
        #cat_filter,
        #cat_filter input {
            color: #6C7293;
            background-color: white;
        }

        #cat_paginate * {
            color: #6C7293;
            background-color: white;
        }



        .paginate_button.active .page-link {
            background-color: #373a41 !important;
            color: white !important;
            border-color: #373a41 !important;
        }

        #cat_length {
            direction: ltr;
        }

    </style>
@endsection
@section('content')
    <div class="row ">
        <div class="col-12 grid-margin">
            <div class="card" style="background-color: white;">
                <div class="card-body">
                    <div style="display: flex;justify-content: space-between;">

                        <h4 class="card-title " style="color: black;"> {{ 'طلبات السائق  '.$driver->first_name }}</h4>

                       {{--  <button type="button" class="btn btn-warning btn-fw "
                            id="add-product-btn">{{ __('dashboard/orders.add_order') }}</button> --}}
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table display" id="cat">

                            <thead>
<th></th>
                                    <th> {{ __('dashboard/orders.order_id') }} </th>
                                    <th> {{ __('dashboard/orders.client_name') }}</th>
                                    <th> {{ __('dashboard/orders.date_pur') }} </th>
                                    <th> {{ __('dashboard/orders.payment_method') }}</th>
                                    <th>{{ __('dashboard/orders.total') }}</th>
                                    <th> {{ __('dashboard/orders.status') }}</th>







                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('additional_scripts')
    <script>
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

        /* Formatting function for row details - modify as you need */
        // function format(d) {
        //     var table = `
        //     <table class="table p-2" style='background-color: white;box-shadow: 0px 0px 0px 2px rgb(253, 106, 0);'>

        //             <thead>
        //                 <tr>
        //                     <th colspan=4 class=table-dark style='color:white;text-align:center;'>
        //                         <a href="./orders/show/${d.id}" target="_blank" class='btn btn-warning btn-fw '>
        //                             {{ __('dashboard/orders.order_details') }}  </a>
        //                             // <input type=text hidden name="order_id" value=${d.id} >
        //                             //  <button type='submit' class='btn btn-outline-warning btn-icon-text'>
        //                             // <i class='mdi  btn-icon-prepend'></i>تفاصيل الطلب</button>
        //                         </form>
        //                     </th>
        //                 </tr>
        //                 <tr>
        //                     <th colspan=4 class=table-dark style='color:white;text-align:center;'>معلومات العميل</th>
        //                 </tr>
        //                 <tr>
        //                     <td colspan=2>
        //                         الاسم :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.name}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                         <td colspan=2>
        //                         المدينة :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.customers_city}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                       <td colspan=2>
        //                         البريد الالكتروني :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.email}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                     <td colspan=2>
        //                         الهاتف :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.phone}
        //                     </td>
        //                 </tr>
        //                 <tr>
        //                     <th colspan=4 class=table-dark style='color:white;text-align:center;'>معلومات الشحن</th>
        //                 </tr>
        //                 <tr>
        //                     <td colspan=2>
        //                         الاسم :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.delivery_name}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                         <td colspan=2>
        //                         المدينة :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.delivery_city}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                       <td colspan=2>
        //                          العنوان :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.delivery_street_address}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                     <td colspan=2>
        //                         الهاتف :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.delivery_phone}
        //                     </td>
        //                 </tr>
        //                 <tr>
        //                     <th colspan=4 class=table-dark style='color:white;text-align:center;'>معلومات الفاتورة</th>
        //                 </tr>
        //                 <tr>
        //                     <td colspan=2>
        //                         الاسم :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.billing_name}
        //                     </td>
        //                     </tr>
        //                     <tr>
        //                         <td colspan=2>
        //                         العنوان :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.billing_street_address}
        //                     </td>
        //                     </tr>

        //                     <tr>
        //                     <td colspan=2>
        //                         الهاتف :
        //                     </td>
        //                     <td colspan=2>
        //                         ${d.billing_phone}
        //                     </td>
        //                 </tr>
        //                 <tr>
        //                     <th colspan=4 class=table-dark style='color:white;text-align:center;'>تغيير الحالة</th>
        //                 </tr>
        //                 <tr>
        //                     <td colspan=4>
        //                         <form action={{ route('dashboard.orders.updateStatus') }} method=post >
        //                             @csrf
        //                             <input hidden name='orders_id' value=${d.id}>
        //                             <label>اختيار الحالة :</label>
        //                                     <select name='orders_status' style='background-color:white;color:grey'>
        //                                         @foreach ($orders_status as $status)
        //                                         <option value={{$status->id}}
        //                                             @once
        //                                                 {{ 'selected' }}
        //                                             @endonce>
        //                                             {{ $status->name }}</option>
        //                                         @endforeach
        //                                     </select>
        //                                     <br>
        //                                 <label>اترك تعليق :</label><br>
        //                                     <input  type=text name='comments' ><br>
        //                             <button type='submit' class='btn btn-outline-warning btn-icon-text'>
        //                             <i class='mdi mdi-pencil btn-icon-prepend'></i>update</button>
        //                         </form>
        //                     </td>
        //                 </tr>
        //                 <tr>
        //                     <th colspan=4 class='table-dark' style='text-align:center;color:white'> تاريخ حالة الطلب</th>
        //                 </tr>
        //                 <tr>
        //                 <th scope="col">#</th>
        //                 <th scope="col">التاريخ</th>
        //                 <th scope="col">الحالة</th>
        //                 <th scope="col">تعليق</th>
        //                 </tr>
        //             </thead>
        //             <tbody>
        //                 `;
        //     var i = 1;
        //     d.status_history.forEach(element => {
        //         table +=
        //             `
        //                     <tr>
        //                         <th scope="row">${i++}</th>
        //                         <td>${element.pivot.date_added}</td>
        //                         <td>${element.description.orders_status_name}</td><td>
        //                         `;
        //         if (element.pivot.comments != null)
        //             table += ` ${element.pivot.comments}`;


        //         table += `</td>
        //                     </tr>`;
        //     });

        //     ;
        //     table += `
        //             </tbody>
        //             </table> `;
        //     return table;
        // }

  function open_add(id) {
            $('#div_' + id).slideDown(800);
        }

        function cancel_add(id) {
            $('#div_' + id).slideUp(800);
        }

    function format(d) {
            // console.log(d);
            var table = `

           <a href="../../orders/show/${d.id}" target="_blank" class='btn btn-warning btn-fw '>
                                    {{ __('dashboard/orders.order_details') }}  </a>
                                    <button  class='btn btn-outline-warning btn-icon-text' onclick="open_add(${d.id})">{{ __('dashboard/orders.change_status') }}</button>`




                      table +=     ` <div class="row" id="div_${d.id}" style="display:none">
                            <div class="col-sm-12">

                                <form style="  background: white;  border: 1px solid #e4e6fc;padding: 20px;margin-top: 20px;" action={{ route('dashboard.orders.updateStatus') }} method=post >
                                    @csrf
                                    <input hidden name='orders_id' value=${d.id}>
                                     <div class="row">
                            <div class="col-sm-6">
                            <label>{{ __('dashboard/orders.choose_status') }}  :</label>
                                            <select  class="form-control" name='orders_status' style='background-color:white;color:grey'>
                                                @foreach ($orders_status as $status)
                                                <option value={{ $status->id }}
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



            return table;
        }



        $(document).ready(function() {
            var table = $('#cat').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 50, 100, 150],
                order: [
                    [0, "desc"]
                ],
                serverSide: true,
                ajax: "{{ route('dashboard.drivers.orders.dataTable',['driver_id'=>$driver->id]) }}",
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
                        data: 'payment_method'
                    },
                    {
                        data: 'order_price'
                    },

                    {
                       data:'currents.status_desc.name'

                    },



                ],



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
        });
    </script>
@endsection
