@extends('layouts.Dashboard.main')
@section('additional_styles')
    <style>
        .datepicker table tr td span {
            display: block;
            width: 23% !important;
            height: 28px !important;
            line-height: 30px !important;
            float: left;
            margin: 1%;
            cursor: pointer;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            font-size: 14px !important;
        }

        .tickets-list .ticket-item {
            text-decoration: none;
            display: inline-block;
            width: 100%;
            padding: 13px !important;
            border-bottom: 1px solid #f9f9f9;
        }
    </style>
@endsection
@section('content')
    <section class="section">
        {{-- <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-stats">
                        <div class="card-stats-title">{{ __('dashboard/statistics.Order_Statistics') }}

                        </div>
                        <div class="card-stats-items">
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">
                                     @php
                                        if (array_key_exists(1, $Orderstatus)) {
                                            echo $Orderstatus[1];
                                        } else {
                                            echo 0;
                                        }
                                    @endphp
                                </div>
                                <div class="card-stats-item-label">{{ __('dashboard/statistics.Pending') }}</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">
                                     @php
                                        if (array_key_exists(3, $Orderstatus)) {
                                            echo $Orderstatus[3];
                                        } else {
                                            echo 0;
                                        }
                                    @endphp
                                </div>
                                <div class="card-stats-item-label">{{ __('dashboard/statistics.Canceled') }}</div>
                            </div>
                            <div class="card-stats-item">
                                <div class="card-stats-item-count">
                                     @php
                                        if (array_key_exists(5, $Orderstatus)) {
                                            echo $Orderstatus[5];
                                        } else {
                                            echo 0;
                                        }
                                    @endphp
                                </div>
                                <div class="card-stats-item-label">{{ __('dashboard/statistics.Completed') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-archive"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('dashboard/statistics.Total_Orders') }}</h4>
                        </div>
                        <div class="card-body">
                             {{ $orders }}

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="balance-chart" height="80"></canvas>

                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('dashboard/statistics.Incomes') }} </h4>
                        </div>
                        <div class="card-body" id="total_inc">

                        </div>
                    </div>
                </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-chart">
                        <canvas id="sales-chart" height="80"></canvas>
                    </div>
                    <div class="card-icon shadow-primary bg-primary">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>{{ __('dashboard/statistics.Expenses') }}</h4>
                        </div>
                        <div class="card-body">
                            {{ $total_expenses }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
             <div class="col-lg-8">
                <div class="card">
                    <div class="card-header d-flex" style="justify-content: space-between;">
                        <h4>{{ __('dashboard/statistics.Incomes_vs_Expenses') }}</h4>
                        <div style="display: flex;align-items: center;">
                            <lable class="mr-2">{{ __('dashboard/statistics.Year') }}:</lable>
                            <input id="datepicker" class="form-control" style="width:100%; " type="text" min="1900"
                                max="2099" step="1" value="2023" onchange="change_st()" />
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="d-flex mb-4 " style="    flex-wrap: wrap;">
                            <div class="custom-control custom-radio mr-4">
                                <input type="radio" id="customRadio0" name="customRadio" value="0"
                                    onchange="change_st()" class="custom-control-input" checked>
                                <label class="custom-control-label" for="customRadio0">{{ __('dashboard/sidebar.all') }}</label>
                            </div>
                            @foreach ($POS as $pos)
                                <div class="custom-control custom-radio mr-4">
                                    <input type="radio" id="customRadio{{ $pos->id }}" name="customRadio"
                                        value="{{ $pos->store_id }}" onchange="change_st()" class="custom-control-input">
                                    <label class="custom-control-label"
                                        for="customRadio{{ $pos->id }}">{{ $pos->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        <canvas id="myChart" height="158"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card gradient-bottom" style="    height: 94%;">
                    <div class="card-header">
                        <h4>{{ __('dashboard/statistics.Top_Products') }}</h4>
                        <div class="card-header-action dropdown">

                        </div>
                    </div>
                     <div class="card-body" id="top-5-scroll" style="height: 345px !important;">
                        <ul class="list-unstyled list-unstyled-border">
                            @foreach ($topProducts as $top)
                                <li class="media">
                                    <img class="mr-3 rounded" width="55" src="{{ URL::asset($top->image) }}"
                                        alt="product">

                                    <div class="media-body">
                                        <div class="float-right">
                                            <div class="font-weight-600 text-muted text-small">{{ $top->top }} {{ __('dashboard/statistics.Sales') }}
                                            </div>
                                        </div>
                                        <div class="media-title">{{ $top->p_name }}</div>
                                        <div class="mt-4">
                                            <div class="budget-price">
                                                <div class="budget-price-square bg-primary" data-width="64%"></div>
                                                <div class="budget-price-label">${{ $top->price }}</div>
                                            </div>

                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
             <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('dashboard/statistics.Alerts') }}</h4>

                    </div>
                    <div class="card-body">
                        <div id="edit_div"
                            style="display:none;border: 1px solid #f4f6f9;padding: 25px;margin-bottom: 22px;position: relative;">
                            <a
                                style="    position: absolute; right: 6px;top: 0px;    padding: 3px;cursor: pointer;color: gray;">x</a>
                                {{ __('dashboard/statistics.Edit_product_quantity') }}:
                            <div class="d-flex"><input style="height: 35px;"class="form-control mr-2" type="text">
                                <a href="#" class="btn btn-primary">{{ __('dashboard/statistics.Save') }}</a>
                            </div>
                        </div>
                        <div class="table-responsive table-invoice">
                            <table class=" table-striped" id="quantity">
                                <thead>
                                    <tr>
                                        <th>{{ __('dashboard/statistics.Product_Name') }}</th>
                                        <th>{{ __('dashboard/statistics.Store_Name') }}</th>
                                        <th>{{ __('dashboard/statistics.Status') }}</th>
                                        <th>{{ __('dashboard/statistics.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($store_product as $s_product)
                                        <tr>


                                            <td class="font-weight-600">{{ $s_product->pr_name }}<br>
                                                @foreach ($s_product->product_variations_group as $productgroup)
                                                    <small>{{ $productgroup->option_name }} :
                                                        {{ $productgroup->option_value }} |</small>
                                                @endforeach
                                            </td>
                                            <td>{{ $s_product->stores->name }}</td>
                                            <td>
                                                @if ($s_product->quantity < 5)
                                                    <div class="badge badge-danger">{{ __('dashboard/statistics.very_low') }} ({{ $s_product->quantity }})
                                                    </div>
                                                @else
                                                    <div class="badge badge-warning">{{ __('dashboard/statistics.low') }} ({{ $s_product->quantity }})
                                                    </div>
                                                @endif
                                            </td>
                                            <td>

                                                <a target="_blank" href="{{ route('dashboard.show',$s_product->poss->id) }}"
                                                    class="btn btn-primary">{{ __('dashboard/statistics.Edit') }}</a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-md-4">
                <div class="card card-hero" style="    height: 94%;">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h4 style="    font-size: 25px;">
                            @php $tpday_total=0; @endphp
                            @foreach ($Dailyprofits as $Dailyprofit)
                                @php
                                    $tpday_total += (float) $Dailyprofit->total_incom - (float) $Dailyprofit->total_expenses;
                                @endphp
                            @endforeach
                            {{ __('dashboard/statistics.Total') }} : {{ $tpday_total }} $
                        </h4>
                        <div class="card-description">{{ __('dashboard/statistics.Daily_profits_per_POS') }}</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="tickets-list">
                            @foreach ($Dailyprofits as $Dailyprofit)
                                <a href="{{ route('dashboard.finance.index') }}" class="ticket-item">
                                    <div class="ticket-title " style="display: flex;justify-content: space-between;">
                                        <h4>{{ $Dailyprofit->name }}</h4>
                                        <div>
                                            <span class="text-muted mr-3">
                                                <span class="text-danger">
                                                    <i class="fas fa-caret-down"></i>
                                                </span>
                                                {{ $Dailyprofit->total_expenses }}$
                                            </span>
                                            <span class="text-muted">
                                                <span class="text-primary">
                                                    <i class="fas fa-caret-up"></i>
                                                </span>
                                                {{ $Dailyprofit->total_incom }}$
                                            </span>
                                        </div>
                                    </div>

                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </section>
@endsection
@section('additional_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
    <script>
        $(document).ready(function() {

            $('#quantity').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, "desc"]
                ],
                pagingType: 'full_numbers'
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    ,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                    }
                @endif

            });
        });
        $(function() {

            $("#datepicker").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years"
            });
        });

        function open_edit() {
            $('#edit_div').slideDown(800);
        }

        function close_edit() {
            $('#edit_div').slideUp(800);
        }

    </script>
@endsection
