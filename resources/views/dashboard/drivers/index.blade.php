@extends('layouts.dashboard.main')
@section('title', 'Electro Admin | drivers')
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

  <div class="row  add-category" style="display: none;color: black;">

            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;box-shadow: 0px 0px 0px 2px rgb(253, 106, 0);">
                    <div class="card-body">
                        <h4 class="card-title " style="color: black;"> سائق جديد</h4>
                        <form style=" color:black;margin-bottom: 2em;padding:2em;"
                            action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class=" col-sm-12 col-lg-6 grid-margin">
                                    <div class="card" style="background-color: white;">
                                        <div class="card-body">

                                            <label> الاسم الاول </label>
                                            <input type="text" style="margin-bottom: 2em; " name="first_name"
                                                value="{{ is_null(old('first_name')) ? '' : old('first_name') }}"><br>

                                            @error('first_name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror


                                            <label> الاسم الثاني </label>
                                            <input type="text" style="margin-bottom: 2em; " name="last_name"
                                                value="{{ is_null(old('last_name')) ? '' : old('last_name') }}"><br>

                                            @error('last_name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                            <label> الايميل </label>
                                            <input type="text" style="margin-bottom: 2em;" name="email"
                                                value="{{ is_null(old('email')) ? '' : old('email') }}"><br>
                                            @error('email')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <label> رقم الهاتف </label>
                                            <input type="text" style="margin-bottom: 2em;" name="phone"
                                                value="{{ is_null(old('phone')) ? '' : old('phone') }}"><br>
                                            @error('phone')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>

                                    </div>

                                </div>
                                <div class="col-sm-12 col-lg-6  grid-margin">
                                    <div class="card" style="background-color: white;">
                                        <div class="card-body">


                                            <label> كلمة السر </label>
                                            <input type="text" style="margin-bottom: 2em;" name="password" value=""><br>
                                            @error('password')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <label> تأكيد كلمة السر </label>
                                            <input type="text" style="margin-bottom: 2em;" name="confirm_password"
                                                value=""><br>
                                            @error('confirm_password')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <!--<label>نمط المستخدم :</label>-->
                                            <select style="margin-bottom: 2em;" name="role" hidden >
                                                <option value="14" selected> Driver</option>
                                               

                                            </select>


                                            @error('role')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>

                                    </div>

                                </div>



                            </div>

                            <div style="margin:2em 0">
                                <button type="submit" class="btn btn-outline-warning btn-fw">اضافة</button>
                                <button type="button" class="btn btn-outline-warning btn-fw"
                                    id="exit-cat-btn">الغاء</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card" style="background-color: white;box-shadow: 0px 0px 0px 2px rgb(253, 106, 0);">
                <div class="card-body">

                    <div style="display: flex;justify-content: space-between;">
                        <h4 class="card-title " style="color: black;"> {{__('dashboard/drivers.drivers')}}</h4>
                        <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn"> اضافة سائق
                                جديد</button>

                    </div>
                    <div class="table-responsive mt-5">
                        <table class="table display" id="cat">
                            <thead>
                                <tr>

                                    <th>{{__('dashboard/drivers.id')}}</th>
                                    <th>{{__('dashboard/drivers.name')}}</th>
                                    <th> {{__('dashboard/drivers.phone')}} </th>
                                     <th> {{__('dashboard/drivers.email')}} </th>
                                    <th > {{__('dashboard/categories.action')}}</th>
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
    
        $(document).ready(function() {
            $('#cat').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('dashboard.drivers.dataTable') }}",
                columns: [
                    {
                        data: 'id'
                    },
                    {
                        data: 'name'
                    },
                    {
                        data:'phone'
                    },
                    {
                        data:'email'
                    },
                    {
                        data: 'action'
                    },


                ]
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                                    ,
                                    language: {
                                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                                    }
                                @endif
            });
        });
    </script>
    
      
        <script>
            $(function() {
                @if (Session::get('errors'))
                    {

                        $('.add-category').slideDown(800);

                    }
                @endif
            
                $('#add-cat-btn').click(function() {
                    $('.add-category').slideDown(800);
                });
               
                $('#exit-cat-btn').click(function() {
                    $('.add-category').slideUp(800);
                });


            });
        </script>
    
@endsection
