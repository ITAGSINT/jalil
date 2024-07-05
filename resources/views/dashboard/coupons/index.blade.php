@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="card" style="background-color: white;
            <!--box-shadow: 0px 0px 0px 2px rgb(253, 106, 0);-->
            ">
                <div class="card-body">
                    <div style="display: flex;justify-content: space-between;">
                        <h4 class="card-title " style="color: black;"> {{ 'الكوبونات' }}</h4>
                        <a href="{{ route('dashboard.coupons.create') }}" class="btn btn-warning btn-fw "
                            id="add-product-btn">{{ 'اضافة كوبون جديد' }}</a>
                    </div>
                    <div class="table-responsive mt-3">
                        <table class="table display" id="cat">

                            <thead>
                                <tr>
                                    <th></th>
                                    <th> معرف الكوبون </th>
                                    <th> الكود</th>
                                    <th> نوع الحسم </th>
                                    <th> قيمة الكوبون </th>
                                    <th> تاريخ الانتهاء </th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('additional_scripts')


    <script>
        /* Formatting function for row details - modify as you need */
        function format(d) {
            // `d` is the original data object for the row
            return `
            <table class="table p-2" style='background-color: white;'>

                    <thead>
                        <tr>
                            <th colspan=3 class=table-dark style='color:white;text-align:center;'> ${d.action}</th>
                        </tr>
                    </thead>
                </table>
            `;
        }

        $(document).ready(function() {

            var table = $('#cat').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('dashboard.coupons.dataTable') }}",
                columns: [{
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    },

                    {
                        data: 'coupans_id'
                    },
                    {
                        data: 'code'
                    },
                    {
                        data: 'type.name'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'expiry_date'
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
