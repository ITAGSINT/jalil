@extends('layouts.dashboard.main')
@section('title', 'Electro | edit')
@section('content')
    <div class="card" style="background-color: white;box-shadow: 0px 0px 0px 2px rgb(253, 106, 0);">
        <div class="card-body">
            <div style="display: flex;justify-content: space-between;direction: rtl;">
                <h6 class="card-title " style="color: black;"> تعديل معلومات العميل</h6>
                @if (!is_null($user->image))
                    <img class='ml-4' src="{{ URL::asset('assets/uploads/images/users/' . $user->image) }}" />
                @endif

            </div>
            <form style=" color:black;margin-bottom: 2em;padding:2em;"
                action="{{ route('dashboard.clients.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6 grid-margin">
                        <div class="card" style="background-color: white;">
                            <div class="card-body">

                                <label> الاسم </label>
                                <input type="text" style="margin-bottom: 2em;" name="name"
                                    value="{{ is_null(old('name')) ? $user->name : old('name') }}"><br>

                                @error('name')
                                    <div style="color:red">{{ $message }}</div><br>
                                @enderror
                                <label> الايميل </label>
                                <input type="text" style="margin-bottom: 2em;" name="email"
                                    value="{{ is_null(old('email')) ? $user->email : old('email') }}"><br>
                                @error('email')
                                    <div style="color:red">{{ $message }}</div><br>
                                @enderror
                                <label> رقم الهاتف </label>
                                <input type="text" style="margin-bottom: 2em;" name="phone"
                                    value="{{ is_null(old('phone')) ? $user->phone : old('phone') }}"><br>
                                @error('phone')
                                    <div style="color:red">{{ $message }}</div><br>
                                @enderror

                            </div>

                        </div>

                    </div>
                    <div class="col-6 grid-margin">
                        <div class="card" style="background-color: white;">
                            <div class="card-body">

                                <label> العنوان </label>
                                <input type="text" style="margin-bottom: 2em;" name="address"
                                    value="{{ is_null(old('address')) ? $user->address : old('address') }}"><br>
                                @error('address')
                                    <div style="color:red">{{ $message }}</div><br>
                                @enderror
                                <label>الحالة</label>

                                <select class="custom-select" name="cars" id="cars" style="margin-bottom: 2em;">
                                    <option value="volvo">inactive</option>
                                    <option value="saab">active</option>

                                </select><br>
                                <label for="myfile">تعديل الصورة</label>
                                <input type="file" id="myfile" name="image">


                            </div>

                        </div>

                    </div>



                </div>

                <div style="margin:2em 0">
                    <button type="submit" class="btn btn-outline-warning btn-fw">تعديل</button>
                    <a href={{route('dashboard.clients.index')}} class="btn btn-outline-warning btn-fw" id="exit-client-btn">الغاء</a>
                </div>

            </form>

        </div>
    </div>
@endsection
