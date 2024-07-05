@extends('layouts.Dashboard.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>{{ __('dashboard/users.users') }}</h1>

        </div>

        <div class="section-body">


            <div class="row">
                @foreach ($users_type as $type)
                    <div class="col-lg-6">
                        <div class="card card-large-icons">
                            <div class="card-icon bg-primary text-white">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="card-body">
                                <h4>{{ $type->name }}</h4>
                                {{-- <p>{{ __('dashboard/users.super_Admin_des') }}</p> --}}
                                <a href="{{ route('dashboard.users.users', $type->id) }}"
                                    class="card-cta">{{ __('dashboard/users.See_more') }} <i
                                        class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach




            </div>
        </div>
    </section>
@endsection
