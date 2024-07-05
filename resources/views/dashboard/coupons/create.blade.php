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

                    <form class="shadow rounded"
                        style="
                     @if (LaravelLocalization::getCurrentLocale() == 'ar') direction:rtl; @endif
                    color:black;margin-bottom: 2em;padding:2em;background: white;"
                        method=POST action="{{ route('dashboard.coupons.store') }}">
                        @csrf
                        <div class="row">

                            {{-- <div class="col-6 grid-margin">
                                <div class="card" style="background-color: white;">

                                    <div class="card-body">




                                        <label>
                                            {{ __('dashboard/coupons.min-pro') }}

                                        </label>
                                        <input class="form-control" type="number" name="limit_usage_to_x_items"
                                            value=" {{ is_null(old('limit_usage_to_x_items')) ? '' : old('limit_usage_to_x_items') }}"><br>



                                        <!--<label style="font-size:10px"> عدد المنتجات المطلوب لتطبيق الكوبون      </label><br>-->

                                        @error('limit_usage_to_x_items')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror


                                        <label>

                                            {{ __('dashboard/coupons.max-use') }}
                                        </label>
                                        <input class="form-control" type="number" style="margin-bottom: 2em;"
                                            name="usage_limit"
                                            value="{{ is_null(old('usage_limit')) ? '' : old('usage_limit') }}"
                                            required><br>
                                        @error('usage_limit')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                            <label> عدد المرات الأدنى لاستخدام الكوبون </label>
                                           <input class="form-control" type="number" style="margin-bottom: 2em;" name="usage_limit"
                                                value="{{ is_null(old('usage_limit')) ? '' : old('usage_limit') }}"><br>
                                            @error('usage_limit')
                                                <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                                </label><br>
                                            @enderror


                                    </div>

                                </div>

                            </div> --}}
                            <div class="col-12 grid-margin">
                                <div class="card" style="background-color: white;">
                                    <div class="card-body">

                                        <label>
                                            {{ __('dashboard/coupons.code') }}

                                        </label>
                                        <input class="form-control" type="text" name="code"
                                            value="{{ is_null(old('code')) ? '' : old('code') }}"><br>
                                        <!--<label style="font-size:10px;margin-bottom:2em">الكود الخاص بالكوبون</label><br>-->
                                        @error('code')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label>
                                            {{ __('dashboard/coupons.desc') }}

                                        </label>
                                        <textarea name="description" cols="24" rows="5" class="form-control"
                                            placeholder="{{ __('dashboard/coupons.desc') }}">{{ is_null(old('description')) ? '' : old('description') }}</textarea>
                                        @error('description')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label class="col-form-label">
                                            {{ __('dashboard/coupons.dis-type') }}

                                        </label>

                                        <select class="custom-select chosen-select" name="discount_type"
                                            onchange='change_state($this.value())'>
                                            <option value="" selected></option>
                                            <option value="1">
                                                Fixed
                                            </option>
                                            <option value="2">
                                                Percent

                                            </option>
                                            {{-- <option value="3">
                                                {{ __('dashboard/coupons.fix-pro') }}

                                            </option>
                                            <option value="4">
                                                {{ __('dashboard/coupons.pre-pro') }}

                                            </option> --}}

                                        </select>
                                        <!--<label style="font-size:10px"> نوع الحسم الذي سيطبق على العناصر </label><br>-->
                                        <br>
                                        @error('discount_type')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        <label>
                                            {{ __('dashboard/coupons.amount') }}
                                        </label>
                                        <input class="form-control" type="text" name="amount"
                                            value=" {{ is_null(old('amount')) ? '' : old('amount') }}"><br>
                                        <!--<label style="font-size:10px"> قيمة الحسم الذي سيطبق على العناصر </label><br>-->
                                        @error('amount')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror



                                        {{-- <input class="form-check-inline" type="checkbox" style="margin: 2em 0;"
                                            name="free_shipping">
                                        <label style="font-size:13px">
                                            {{ __('dashboard/coupons.free-ship') }}

                                        </label><br> --}}

                                        <label>
                                            {{ __('dashboard/coupons.expiry') }}

                                        </label>
                                        <input class="form-control" type="date"
                                            style="margin: 2em 0;padding: 7px;background-color:
                                                                                            #f0f1f1;width: 100%;border:none"
                                            name="expiry_date"><br>
                                        @error('expiry_date')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror

                                        {{-- <label>
                                            {{ __('dashboard/coupons.max-price') }}

                                        </label>
                                        <input class="form-control" type="text" name="maximum_amount"
                                            value=" {{ is_null(old('maximum_amount')) ? '' : old('maximum_amount') }}"><br>
                                        <!--<label style="font-size:10px">-->
                                        <!--       {{ __('dashboard/coupons.amount') }}-->
                                        <!--     القيمة التي يجب انفاقها كحد اعظمي لتفعيل الكوبون-->

                                        <!--</label><br>-->
                                        @error('maximum_amount')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror
                                        <label>
                                            {{ __('dashboard/coupons.min-price') }}

                                        </label>
                                        <input class="form-control" type="text" name="minimum_amount"
                                            value=" {{ is_null(old('minimum_amount')) ? '' : old('minimum_amount') }}"><br>
                                        <!--<label style="font-size:10px"> -->
                                        <!--   {{ __('dashboard/coupons.amount') }}-->
                                        <!--القيمة التي يجب انفاقها كحد ادنى لتفعيل الكوبون-->
                                        <!--</label><br>-->
                                        @error('minimum_amount')
                                            <label style="font-size:10px;margin-bottom: 2em; color:red;"> الحقل غير صالح
                                            </label><br>
                                        @enderror --}}

                                        {{-- <input type="checkbox" style="margin: 2em 0;" name="individual_use">
                                        <label style="font-size:13px"> استخدام الكوبون من دون القدرة على استخدام كوبون آخر
                                        </label><br>
--}}
                                        {{-- <input type="checkbox" style="margin: 2em 0;" name="exclude_sale_items">
                                        <Label style="font-size:13px"> استخدام الكوبون فقط على العناصر دون خصم-<br>
                                            يعمل في حال البطاقة لا تحوي عناصر يشملها خصم</label> --}}

                                    </div>

                                </div>

                            </div>


                        </div>

                        <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-outline-warning btn-fw"
                            id="exit-cat-btn">
                            {{ __('dashboard/coupons.cancel') }}

                        </a>
                        <button type="submit" class="btn btn-outline-warning btn-fw">
                            {{ __('dashboard/coupons.add') }}

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
        function change_state(val) {
            alert(val);
        }
        $(function() {
            $(".chosen-select").chosen({
                rtl: true,
                width: "100%"
            });



        });
    </script>
@endsection
