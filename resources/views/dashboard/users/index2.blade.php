@auth()
    @if (Auth::user()->role_id == 1)
        @extends('layouts.Dashboard.main')
        @section('title', 'Electro admin | Users Types')
    @section('additional_styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
            integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
            <style>
                .store_div{display:none;}
            </style>
    @endsection
    @section('content')
    <div class="content-wrapper tab-one"  >
        <div class="row  add-category" style="display: none;">

            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title " >  {{ __('dashboard/users.new_user') }}</h4>
                        <form style="margin-bottom: 2em;padding:2em;"
                            action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class=" col-sm-12 col-lg-6 grid-margin">
                                    <div class="card" style="background-color: white;">
                                        <div class="card-body">

                                            <label>{{ __('dashboard/users.f_name') }}</label>
                                            <input type="text" style="margin-bottom: 2em; " name="first_name"
                                                value="{{ is_null(old('first_name')) ? '' : old('first_name') }}"><br>

                                            @error('first_name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror


                                            <label>  {{ __('dashboard/users.l_name') }} </label>
                                            <input type="text" style="margin-bottom: 2em; " name="last_name"
                                                value="{{ is_null(old('last_name')) ? '' : old('last_name') }}"><br>

                                            @error('last_name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                            <label> {{ __('dashboard/users.email') }} </label>
                                            <input type="text" style="margin-bottom: 2em;" name="email"
                                                value="{{ is_null(old('email')) ? '' : old('email') }}"><br>
                                            @error('email')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <label>  {{ __('dashboard/users.phone') }} </label>
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


                                            <label>  {{ __('dashboard/users.password') }} </label>
                                            <input type="text" style="margin-bottom: 2em;" name="password" value=""><br>
                                            @error('password')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <label>    {{ __('dashboard/users.conf_password') }}  </label>
                                            <input type="text" style="margin-bottom: 2em;" name="confirm_password"
                                                value=""><br>
                                            @error('confirm_password')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <label>  {{ __('dashboard/users.user_type') }}  :</label>
                                            <select style="margin-bottom: 2em;" name="role" id="role" onchange="show_store()">
                                                <option value=""> </option>
                                                @foreach ($users_type as $type)
                                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('role')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <br>
                                            <label class="store_div">  Store  :</label>
                                            <select style="margin-bottom: 2em;" name="store" id="store" class="store_div">
                                            
                                            </select>
                                            @error('store')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>

                                    </div>

                                </div>



                            </div>

                            <div style="margin:2em 0">
                                <button type="submit" class="btn btn-outline-warning btn-fw">  {{ __('dashboard/users.add') }} </button>
                                <button type="button" class="btn btn-outline-warning btn-fw"
                                    id="exit-cat-btn">  {{ __('dashboard/users.cancel') }} </button>
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
                            <h4 class="card-title " style="">{{ __('dashboard/users.users') }}
                            </h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">  
                                {{ __('dashboard/users.add_new_user') }}</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th>  {{ __('dashboard/users.id') }} </th>
                                        <th>  {{ __('dashboard/users.name') }}</th>
                                        <th>  {{ __('dashboard/users.enail') }} </th>
                                        <th>  </th>
                                    </tr>
                                </thead>
                                <tbody>





                                    @foreach ($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>
                                                <form action="{{ route('dashboard.users.update', $admin->id) }}"
                                                    method=POST style="display: inline">
                                                    @csrf

                                                    <select style="margin-bottom: 2em;" name="role">

                                                        @foreach ($users_type as $type)
                                                         @if($type->id!=3)
                                                            <option value="{{ $type->id }}"
                                                                @if ($admin->role_id == $type->id) selected @endif>
                                                                {{ $type->name }}
                                                            </option>
                                                            @endif
                                                        @endforeach

                                                    </select>

                                                    <button type="submit"
                                                        class="btn btn-outline-warning btn-fw"> {{ __('dashboard/users.edit') }}</button>

                                                </form>


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
        <div class="row ">

            <div class="col-12 grid-margin">
                <div class="card" style="">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h4 class="card-title " style="">Vendors
                            </h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn1">  
                                {{ __('dashboard/users.add_new_user') }}</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th>  {{ __('dashboard/users.id') }} </th>
                                        <th>  {{ __('dashboard/users.name') }}</th>
                                        <th>  {{ __('dashboard/users.enail') }} </th>
                                         <th>  Store name </th>
                                        <th>  </th>
                                    </tr>
                                </thead>
                                <tbody>





                                    @foreach ($vendors as $admin)
                                        <tr>
                                            <td>{{ $admin->id }}</td>
                                            <td>{{ $admin->first_name . ' ' . $admin->last_name }}</td>
                                            <td>{{ $admin->email }}</td>
                                            <td>{{ $admin->store_user[0]->stores[0]->name }}</td>
                                            <td>
                                                <form action="{{ route('dashboard.users.update', $admin->id) }}"
                                                    method=POST style="display: inline">
                                                    @csrf

                                                    <select style="margin-bottom: 2em;" name="role">

                                                        @foreach ($users_type as $type)
                                                         @if($type->id!=3)
                                                            <option value="{{ $type->id }}"
                                                                @if ($admin->role_id == $type->id) selected @endif>
                                                                {{ $type->name }}
                                                            </option>
                                                            @endif
                                                        @endforeach

                                                    </select>

                                                    <button type="submit"
                                                        class="btn btn-outline-warning btn-fw"> {{ __('dashboard/users.edit') }}</button>

                                                </form>


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
        <div class="row ">

            <div class="col-12 grid-margin">
                <div class="card" style="">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h4 class="card-title " style="">  {{ __('dashboard/users.data_entry') }}
                            </h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-u-btn">   
                               {{ __('dashboard/users.add_data_entry') }} </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>

                                        <th> {{ __('dashboard/users.id') }} </th>
                                        <th> {{ __('dashboard/users.name') }}</th>
                                        <th> {{ __('dashboard/users.email') }} </th>
                                        <th>  </th>
                                    </tr>
                                </thead>
                                <tbody>



                                    @foreach ($data_entry as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>

                                                <form action="{{ route('dashboard.users.update', $user->id) }}"
                                                    method=POST style="display: inline">
                                                    @csrf

                                                    <select style="margin-bottom: 2em;" name="role">

                                                        @foreach ($users_type as $type)
                                                        @if($type->id!=3)
                                                            <option value="{{ $type->id }}"
                                                                @if ($user->role_id == $type->id) selected @endif>
                                                                {{ $type->name }}
                                                            </option>
                                                        @endif
                                                        @endforeach

                                                    </select>

                                                    <button type="submit"
                                                        class="btn btn-outline-warning btn-fw">{{ __('dashboard/users.edit') }}</button>

                                                </form>


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
        function show_store(){
            if($('#role').val()==3)
            {
               $('.store_div').show(); 
            }
            else{
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
@endif
@endauth
