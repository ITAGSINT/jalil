<!--@auth()-->
    <!--@if (Auth::user()->role_id == 1)-->
    @extends('layouts.Dashboard.main')
    @section('title', 'Electro admin | Users Types')
@section('additional_styles')

    <style>
        .store_div {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper tab-one">
        <div class="row  add-category" style="display: none;">

            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title "> {{ __('dashboard/users.new_user') }}</h4>
                        <form style="padding:2em;" action="{{ route('dashboard.users.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class=" col-sm-12 col-lg-6 grid-margin">

                                    <div>

                                        <label>Name</label>
                                        <input type="text" style=" " class="form-control" name="name"
                                            value="{{ is_null(old('name')) ? '' : old('name') }}"><br>

                                        @error('name')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                        <label>Avatar</label>
                                        <input type="file" style=" " class="form-control" name="avatar"
                                            value="{{ is_null(old('avatar')) ? '' : old('avatar') }}"><br>

                                        @error('avatar')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                        {{-- <label> {{ __('dashboard/users.l_name') }} </label>
                                        <input type="text" style=" " class="form-control" name="last_name"
                                            value="{{ is_null(old('last_name')) ? '' : old('last_name') }}"><br>

                                        @error('last_name')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror --}}

                                        <label> {{ __('dashboard/users.email') }} </label>
                                        <input type="text" style="" class="form-control" name="email"
                                            value="{{ is_null(old('email')) ? '' : old('email') }}"><br>
                                        @error('email')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror
                                        <label> {{ __('dashboard/users.phone') }} </label>
                                        <input type="text" style="" class="form-control" name="phone"
                                            value="{{ is_null(old('phone')) ? '' : old('phone') }}"><br>
                                        @error('phone')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                    </div>



                                </div>
                                <div class="col-sm-12 col-lg-6  grid-margin">

                                    <div>


                                        <label> {{ __('dashboard/users.password') }} </label>
                                        <input type="text" style="" class="form-control" name="password"
                                            value=""><br>
                                        @error('password')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror
                                        <label> {{ __('dashboard/users.conf_password') }} </label>
                                        <input type="text" style="" class="form-control" name="confirm_password"
                                            value=""><br>
                                        @error('confirm_password')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                        <input type="text" style="display:none" class="form-control" name="role"
                                            value="{{ $users_type[0]->id }}">

                                        @if ($users_type[0]->id == 12 || $users_type[0]->id == 14 || $users_type[0]->id == 15)
                                            <br>
                                            <label> POS :</label>
                                            <select class="form-control" name="pos" id="pos">
                                                @foreach ($pos as $po)
                                                    <option value="{{ $po->id }}">{{ $po->name }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                        @if ($users_type[0]->id == 17 || $users_type[0]->id == 18 || $users_type[0]->id == 19)
                                            <br>
                                            <label> Store :</label>
                                            <select class="form-control" name="store" id="store">
                                                @foreach ($stores as $store)
                                                    <option value="{{ $store->id }}">{{ $store->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('store')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                        @endif

                                        @if ($users_type[0]->id == 4)
                                            <br>
                                            <label> Job :</label>
                                            <select class="form-control h-100" name="job[]" id="job" multiple>
                                                @foreach ($jobs as $job)
                                                    <option value="{{ $job->id }}">{{ $job->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('job')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                        @endif
                                    </div>



                                </div>



                            </div>

                            <div style="margin:2em 0">
                                <button type="submit" class="btn btn-outline-warning btn-fw">
                                    {{ __('dashboard/users.add') }} </button>
                                <button type="button" class="btn btn-outline-warning btn-fw" id="exit-cat-btn">
                                    {{ __('dashboard/users.cancel') }} </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">

            <div class="col-12 grid-margin">
                <div class="card" style="">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h4 class="card-title " style="">{{ $users_type[0]->name }}
                            </h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">
                                {{ __('dashboard/users.add_new_user') }}</button>
                        </div>
                        <div class="table-responsive mt-3 table-striped">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th> {{ __('dashboard/users.id') }} </th>
                                        <th>Avatar</th>
                                        <th> {{ __('dashboard/users.name') }}</th>
                                        <th>Phone</th>
                                        @if ($users_type[0]->id == 4)
                                            <th>Jobs</th>
                                            <th> {{ __('dashboard/sidebar.orders') }} </th>
                                        @endif
                                        @if ($users_type[0]->id == 12 || $users_type[0]->id == 14 || $users_type[0]->id == 15)
                                            <th> POS name </th>
                                        @endif
                                        @if ($users_type[0]->id == 17 || $users_type[0]->id == 18 || $users_type[0]->id == 19)
                                            <th> Store name </th>
                                        @endif
                                        <th> </th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>





                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>
                                                <img src=" {{ $admin->avatar }}" alt="">
                                            </td>
                                            <td>{{ $admin->name }}</td>
                                            <td>{{ $admin->phone }}</td>

                                            @if ($users_type[0]->id == 4)
                                                <th>
                                                    @foreach ($admin->jobs as $job)
                                                        <p class="m-0">{{ $job->name }}</p>
                                                    @endforeach

                                                </th>
                                                <th> <a
                                                        href="{{ route('dashboard.drivers.getdriverOrders', ['driver' => $admin]) }}">

                                                        {{ __('dashboard/users.show-orders') }}
                                                    </a> </th>
                                            @endif

                                            @if ($users_type[0]->id == 12 || $users_type[0]->id == 14 || $users_type[0]->id == 15)
                                                <td>{{ $admin->pos_user[0]->pos[0]->name }}</td>
                                            @endif
                                            @if ($users_type[0]->id == 17 || $users_type[0]->id == 18 || $users_type[0]->id == 19)
                                                <td>{{ $admin->store_user[0]->stores[0]->name }}</td>
                                            @endif
                                            <td>

                                                <label class="custom-switch mt-2">
                                                    <input type="checkbox" id="checkbox_{{ $admin->id }}"
                                                        onchange="active_fun({{ $admin->id }})"
                                                        class="custom-switch-input"
                                                        @if ($admin->is_active == 1) checked @endif>
                                                    <span class="custom-switch-indicator"></span>
                                                    <span class="custom-switch-description">
                                                        {{ __('dashboard/users.Is_Active') }}</span>
                                                </label>



                                            </td>
                                            <td>
                                                <a href="{{route('dashboard.users.edit',['user'=>$admin->id])}}" class="btn btn-outline-primary">Edit</a>
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
@section('additional_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function active_fun(id) {

            if ($('#checkbox_' + id).is(":checked") == true) {

                $.post("./" + id + "/update", {
                    val: 1,
                    id: id,
                    _token: "{{ csrf_token() }}"
                }, function(data) {


                    if (data.code == 0) {


                        alert(data.error);
                    } else {
                        // console.log(data)
                        //  alert('data.msg');
                        //  location.reload();

                    }
                }, 'json');
            } else {
                $.post("./" + id + "/update", {
                    val: 0,
                    id: id,
                    _token: "{{ csrf_token() }}"
                }, function(data) {


                    if (data.code == 0) {


                        alert(data.error);
                    } else {
                        // console.log(data)
                        //  alert('data.msg');
                        //  location.reload();

                    }
                }, 'json');
            }
        }

        function show_store() {
            if ($('#role').val() == 3) {
                $('.store_div').show();
            } else {
                $('.store_div').hide();
            }
        }
        $(function() {
            @if (Session::get('errors'))
                {

                    $('.add-category').slideDown(800);

                }
            @endif
            $(".chosen-select").chosen({
                rtl: true,
                width: "100%"
            });
            $('#add-cat-btn').click(function() {
                $('.add-category').slideDown(800);
            });
            $('#add-cat-btn1').click(function() {
                $('.add-category').slideDown(800);
            });
            $('#add-u-btn').click(function() {
                $('.add-category').slideDown(800);
            });
            $('#exit-cat-btn').click(function() {
                $('.add-category').slideUp(800);
            });


        });
    </script>
@endsection
<!--@endif-->
<!--@endauth-->
