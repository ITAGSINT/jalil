@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class=''>
        <div class=>

            <div class="row ">
                <div class="col-12">

                    <form class="bg-white rounded shadow" style=" color:black;margin-bottom: 2em;padding:2em;" method=POST
                        action="{{ route('dashboard.coupons.update', $coupon->coupans_id) }}">
                        @csrf
                        <div class="row">


                            <div class="col-12 grid-margin">
                                <div class="card" style="background-color: white;">
                                    <div class="card-body">

                                        <label>
                                            {{ __('dashboard/coupons.code') }}
                                        </label>
                                        <input class="form-control" type="text" name="code"
                                            value="{{ is_null(old('code')) ? $coupon->code : old('code') }}"><br>
                                        <!--<label style="font-size:10px;margin-bottom:2em">الكود الخاص بالكوبون</label><br>-->
                                        @error('code')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label> {{ __('dashboard/coupons.desc') }} </label>
                                        <textarea class="form-control" name="description" cols="24" rows="5"
                                            placeholder="{{ __('dashboard/coupons.desc') }} ">{{ is_null(old('description')) ? $coupon->description : old('description') }}</textarea>
                                        @error('description')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label class="col-form-label">{{ __('dashboard/coupons.dis-type') }} </label>

                                        <select class="form-control" name="discount_type">

                                            <option value="1" @if ($coupon->coupon_type == 1) selected @endif>
                                                Fixed
                                            </option>
                                            <option value="2" @if ($coupon->coupon_type == 2) selected @endif>
                                                Percent
                                            </option>



                                        </select>
                                        <!--<label style="font-size:10px"> نوع الحسم الذي سيطبق على العناصر </label><br>-->
                                        <!--<br>-->
                                        @error('discount_type')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label>{{ __('dashboard/coupons.amount') }} </label>
                                        <input class="form-control" type="text" name="amount"
                                            value=" {{ is_null(old('amount')) ? $coupon->amount : old('amount') }}"><br>
                                        <!--<label style="font-size:10px"> قيمة الحسم الذي سيطبق على العناصر </label><br>-->
                                        @error('amount')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        {{-- <input type="checkbox" style="margin: 2em 0;" name="free_shipping"
                                            @if ($coupon->free_shipping == '1') checked @endif>
                                        <label style="font-size:13px">
                                            {{ __('dashboard/coupons.free-ship') }}
                                        </label><br> --}}

                                        <label> {{ __('dashboard/coupons.expiry') }} </label>
                                        <br>
                                        @if (Carbon\Carbon::parse($coupon->expiry_date)->lt(now()))
                                            منتهي/expired
                                        @else
                                            {{ $coupon->expiry_date }}
                                        @endif

                                        <br>
                                        <input class="form-control" type="date"
                                            style="margin: 2em 0;padding: 7px;background-color:
                                                                                                            #f0f1f1;width: 100%;border:none"
                                            name="expiry_date"><br>
                                        @error('expiry_date')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror


                                    </div>

                                </div>

                            </div>


                        </div>

                        <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-outline-warning btn-fw"
                            id="exit-cat-btn">
                            {{ __('dashboard/coupons.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-outline-warning btn-fw">
                            {{ __('dashboard/coupons.edit') }}
                        </button>




                    </form>
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
        $(function() {
            $(".chosen-select").chosen({
                rtl: true,
                width: "100%"
            });



        });
    </script>
@endsection
