@extends('layouts.Dashboard.main')
@section('title', 'Electro admin | Users Types')

@section('content')
    <div class="content-wrapper tab-one">
        <div class="row  add-category">

            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title "> Edit User</h4>
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form style="padding:2em;" action="{{ route('dashboard.update_user2') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class=" col-sm-12 col-lg-6 grid-margin">

                                    <div>
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <label>Name</label>
                                        <input type="text" style=" " class="form-control" name="name"
                                            value="{{ is_null(old('name')) ? $user->name : old('name') }}"><br>

                                        @error('name')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                        <label>Avatar</label>
                                        <input type="file" style=" " class="form-control" name="avatar"
                                            value="{{ is_null(old('avatar')) ? $user->avatar : old('avatar') }}"><br>

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
                                            value="{{ is_null(old('email')) ? $user->email : old('email') }}"><br>
                                        @error('email')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror
                                        <label> {{ __('dashboard/users.phone') }} </label>
                                        <input type="text" style="" class="form-control" name="phone"
                                            value="{{ is_null(old('phone')) ? $user->phone : old('phone') }}"><br>
                                        @error('phone')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                    </div>



                                </div>
                                <div class="col-sm-12 col-lg-6  grid-margin">

                                    <div>


                                        {{-- <label> {{ __('dashboard/users.password') }} </label>
                                        <input type="text" style="" class="form-control" name="password"
                                            value=""><br>
                                        @error('password')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror
                                        <small>leave empty if you don't want to edit</small>
                                        <br>
                                        <label> {{ __('dashboard/users.conf_password') }} </label>
                                        <input type="text" style="" class="form-control" name="confirm_password"
                                            value=""><br>
                                        @error('confirm_password')
                                            <div style="color:red">{{ $message }}</div><br>
                                        @enderror

                                        <input type="text" style="display:none" class="form-control" name="role"
                                            value="{{ $user->role_id }}"> --}}



                                        @if ($user->role_id == 4)
                                            <br>
                                            <label> Job :</label>
                                            <select class="form-control h-100" name="job[]" id="job" multiple>
                                                @foreach ($jobs as $job)
                                                    <option value="{{ $job->id }}" @selected($user->jobs->contains('id', $job->id))>
                                                        {{ $job->name }}</option>
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
                                    Update</button>
                                <button type="button" class="btn btn-outline-warning btn-fw" id="exit-cat-btn">
                                    {{ __('dashboard/users.cancel') }} </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection
@section('additional_scripts')

@endsection
