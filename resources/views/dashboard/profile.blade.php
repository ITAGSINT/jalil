  @extends('layouts.Dashboard.main')
  @section('content')
      <style>
          .profile-widget .profile-widget-items .profile-widget-item:last-child {
              border-right: none;
              text-align: left;
              padding-left: 4%;
          }
      </style>
      <section class="section">
          <div class="section-header">
              <h1>{{ __('dashboard/users.Profile') }}</h1>

          </div>
          <div class="section-body">


              <div class="row mt-sm-4">
                  <div class="col-12 col-md-12 col-lg-12">
                      <div class="card profile-widget">
                          <div class="profile-widget-header">
                              <img alt="image" src="{{ Auth::user()->avatar }}"
                                  class="rounded-circle profile-widget-picture">
                              <div class="profile-widget-items">
                                  <div class="profile-widget-item">
                                      <div class="profile-widget-item-label">{{ __('dashboard/users.name') }}</div>
                                      <div class="profile-widget-item-value">
                                          <div class="profile-widget-name">
                                              {{ Auth::user()->name }}
                                              <div class="text-muted d-inline font-weight-normal">
                                                  <div class="slash"></div>{{ Auth::user()->user_types->user_types_name }}
                                              </div>
                                          </div>
                                      </div>
                                  </div>

                              </div>
                          </div>
                          <div class="profile-widget-description">

                              <form action="{{ route('dashboard.update_user') }}" method="POST"
                                  enctype="multipart/form-data">
                                  @csrf
                                  <div class="needs-validation">
                                      <div class="row">
                                          <div class="form-group col-md-4 col-12">
                                              <label>{{ __('dashboard/users.User_Name') }}</label>
                                              <input type="text" class="form-control" name="name"
                                                  value="{{ Auth::user()->name }}">
                                              @error('name')
                                                  <div style="color:red">{{ $message }}</div><br>
                                              @enderror
                                          </div>

                                          <div class="form-group col-md-4 col-12">
                                              <label>Avatar</label>
                                              <input type="file" style=" " class="form-control" name="avatar"
                                                  value="{{ is_null(old('avatar')) ? $user->avatar : old('avatar') }}"><br>

                                              @error('avatar')
                                                  <div style="color:red">{{ $message }}</div><br>
                                              @enderror
                                          </div>
                                          {{-- <div class="form-group col-md-4 col-12">
                            <label>{{ __('dashboard/users.f_name') }}</label>
                            <input type="text" class="form-control" name="first_name" value="{{Auth::user()->first_name}}">
                            @error('first_name')
                              <div style="color:red">{{ $message }}</div><br>
                            @enderror
                          </div> --}}
                                          {{-- <div class="form-group col-md-4 col-12">
                            <label>{{ __('dashboard/users.l_name') }}</label>
                            <input type="text" class="form-control" name="last_name" value="{{Auth::user()->last_name}}">

                          </div> --}}
                                      </div>
                                      <div class="row">
                                          <div class="form-group col-md-6 col-12">
                                              <label>{{ __('dashboard/users.email') }}</label>
                                              <input type="email" name="email" class="form-control"
                                                  value="{{ Auth::user()->email }}">
                                              @error('email')
                                                  <div style="color:red">{{ $message }}</div><br>
                                              @enderror
                                          </div>
                                          <div class="form-group col-md-6 col-12">
                                              <label>{{ __('dashboard/users.phone') }}</label>
                                              <input type="tel" name="phone" class="form-control"
                                                  value="{{ Auth::user()->phone }}">
                                              @error('phone')
                                                  <div style="color:red">{{ $message }}</div><br>
                                              @enderror
                                          </div>
                                      </div>


                                  </div>
                                  <div class="card-footer text-right">
                                      <button class="btn btn-primary">{{ __('dashboard/users.Save_Changes') }}</button>
                                  </div>
                              </form>
                          </div>

                      </div>
                  </div>

              </div>
          </div>
      </section>
  @endsection
