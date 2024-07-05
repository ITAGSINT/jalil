@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card .card-body {
            padding: 1rem 2rem;
            text-align: left;
            /* direction: rtl; */
        }

        label.col-12 {
            padding: 0;
        }

        a.remove_var {
            float: right;
            font-size: 20px;
            margin-top: 14px;
            width: 30px;
            height: 30px;
            border-radius: 10px;
            color: gray;
            display: flex;
            background: #f4f6f9;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper tab-one">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dashboard.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row  add-category" style="">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title " style="padding-bottom: 0;margin-bottom: 0;">
                                {{ __('dashboard/products.edit_product') }} </h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class=" card mb-4">
                        <div class="card-body">


                            <div class="row" style="width:100%!important;">
                                <div class="col-12">

                                    <div class="row">
                                        <div class="col-12">
                                            <h6>{{ __('dashboard/products.product_name') }} :</h6>
                                        </div>

                                        <div class="col-lg-12 col-12">

                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ is_null(old('name')) ? $product->name : old('name') }}">
                                            @error('name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>{{ __('dashboard/products.product_description') }} :</h6>
                                        </div>

                                        <div class="col-lg-12 col-12">

                                            <textarea name="description" class="form-control" cols="30" rows="5">{{ is_null(old('description')) ? $product->description : old('description') }}</textarea>
                                            @error('description')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>{{ __('dashboard/products.product_price') }} :</h6>
                                        </div>
                                        {{-- <div class="col-lg-6 col-12">
                                            <label for="orginal_price">{{ __('dashboard/products.orginal_price') }}
                                            </label><br>
                                            <input type="text" id="orginal_price" class="form-control"
                                                name="orginal_price"
                                                value="{{ is_null(old('orginal_price')) ? '' : old('orginal_price') }}">
                                            @error('orginal_price')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div> --}}
                                        <div class="col-lg-6 col-12">
                                            <label
                                                for="selling_price">{{ __('dashboard/products.selling_price') }}</label><br>
                                            <input type="text" id="selling_price" class="form-control"
                                                name="selling_price"
                                                value="{{ is_null(old('selling_price')) ? $product->products_price : old('selling_price') }}">
                                            @error('selling_price')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label for="discount_price">Discount Price</label><br>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" value="{{ $product->discount_price }}">
                                            @error('discount_price')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>
                                    </div>



                                </div>

                            </div>



                        </div>
                    </div>



                    <div class=" card mb-4">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>{{ __('dashboard/products.quantity') }}</label>
                                    <input type="text" class="form-control" name="products_quantity" id="products_quantity"
                                        value="{{ is_null(old('products_quantity')) ? $product->products_quantity : old('products_quantity') }}">
                                    @error('quantity')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                                <div class="col-lg-6 col-12">
                                    <label>Size</label>
                                    <input type="text" class="form-control" name="size" id="size"
                                        value="{{ is_null(old('size')) ? $product->size : old('size') }}">
                                    @error('size')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                {{-- <div class="col-lg-6 col-12">
                                    <label>{{ __('dashboard/products.Qr_code') }}</label>
                                    <input type="text" class="form-control" name="Qr_code"
                                        value="{{ is_null(old('Qr_code')) ? '' : old('Qr_code') }}">
                                    @error('Qr_code')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div> --}}
                                {{-- <div class="col-lg-6 col-12" style="display:none">
                                    <label>{{ __('dashboard/products.model') }}</label>
                                    <input class="form-control" type="text" name="model"
                                        value="{{ is_null(old('model')) ? '' : old('model') }}">
                                    @error('model')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror
                                </div> --}}

                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>company</label>
                                    <select class="form-control" name="company" id="company">
                                        @foreach ($product_company as $product_company)
                                            <option value="{{ $product_company->id }}" @selected($product_company->id == $product->company_id)>
                                                {{ $product_company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('company')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>brand</label>
                                    <select class="form-control" name="brand" id="brand">
                                        @foreach ($product_brand as $product_brand)
                                            <option value="{{ $product_brand->id }}" @selected($product_brand->id == $product->brand_id)>
                                                {{ $product_brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('brand')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>manufacturer</label>
                                    <select class="form-control" name="manufacturer" id="manufacturer">
                                        @foreach ($product_manufacturers as $product_manufacturers)
                                            <option value="{{ $product_manufacturers->id }}" @selected($product_manufacturers->id == $product->manufacturer_id)>
                                                {{ $product_manufacturers->name }} </option>
                                        @endforeach
                                    </select>
                                    @error('manufacturer')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Country</label>

                                    <!-- All countries -->
                                    <!-- country names and country-name -->
                                    <select class="form-control" id="country" name="country">
                                        @foreach (CI_COUNTRIES_ARRAY as $code => $country)
                                            <option value="{{ $country }}" @selected((is_null(old('country')) ? $product->country : old('country')) == $country)>
                                                {{ $country }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <!-- total - 252 -->

                                    @error('country')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>code</label>
                                    <input type="text" class="form-control" name="code"
                                        value="{{ is_null(old('code')) ? $product->code : old('code') }}">

                                    @error('code')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>promotional text</label>
                                    <input type="text" class="form-control" name="promotional_text"
                                        value="{{ is_null(old('promotional_text')) ? $product->promotional_text : old('promotional_text') }}">
                                    @error('promotional_text')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>capacity</label>
                                    <input type="text" class="form-control" name="capacity" id="capacity"
                                        value="{{ is_null(old('capacity')) ? $product->capacity : old('capacity') }}">
                                    @error('capacity')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>capacity Unit</label>
                                    <select class="form-control" name="capacity_u" id="capacity_u">

                                        <option value="mah" @selected($product->capacityUnit)>mAh </option>


                                    </select> @error('capacity_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>netWeight</label>
                                    <input type="text" class="form-control" name="netWeight" id="netWeight"
                                        value="{{ is_null(old('netWeight')) ? $product->netWeight : old('netWeight') }}">
                                    @error('netWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>netWeight Unit</label>
                                    <select class="form-control" name="netWeight_u" id="netWeight_u">

                                        <option value="kg">Kg </option>
                                        <option value="g">g </option>

                                    </select>
                                    @error('netWeight_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>grossWeight</label>
                                    <input type="text" class="form-control" name="grossWeight" id="grossWeight"
                                        value="{{ is_null(old('grossWeight')) ? $product->grossWeight : old('grossWeight') }}">
                                    @error('grossWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>grossWeight Unit</label>
                                    <select class="form-control" name="grossWeight_u" id="grossWeight_u">

                                        <option value="kg">Kg </option>
                                        <option value="g">g </option>

                                    </select>
                                    @error('grossWeight_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>width</label>
                                    <input type="text" class="form-control" name="width" id="width"
                                        value="{{ is_null(old('width')) ? $product->width : old('width') }}">
                                    @error('width')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>width Unit</label>
                                    <select class="form-control" name="width_u" id="width_u">
                                        <option value="mm">mm </option>
                                        <option value="Cm">Cm </option>
                                        <option value="m">m </option>

                                    </select>

                                    @error('width_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>length</label>
                                    <input type="text" class="form-control" name="length" id="length"
                                        value="{{ is_null(old('length')) ? $product->length : old('length') }}">
                                    @error('length')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>length Unit</label>
                                    <select class="form-control" name="length_u" id="length_u">
                                        <option value="mm">mm </option>
                                        <option value="Cm">Cm </option>
                                        <option value="m">m </option>

                                    </select>
                                    @error('length_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>height</label>
                                    <input type="text" class="form-control" name="height" id="height"
                                        value="{{ is_null(old('height')) ? $product->height : old('height') }}">
                                    @error('height')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>height Unit</label>
                                    <select class="form-control" name="height_u" id="height_u">
                                        <option value="mm">mm </option>
                                        <option value="Cm">Cm </option>
                                        <option value="m">m </option>

                                    </select>
                                    @error('height_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>warranty Period</label>
                                    <input type="text" class="form-control" name="warrantyPeriod" id="warrantyPeriod"
                                        value="{{ is_null(old('warrantyPeriod')) ? $product->warrantyPeriod : old('warrantyPeriod') }}">
                                    @error('warrantyPeriod')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>warranty Type</label>
                                    <input type="text" class="form-control" name="warrantyType"
                                        value="{{ is_null(old('warrantyType')) ? $product->warrantyType : old('warrantyType') }}">
                                    @error('warrantyType')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>shipping Weight</label>
                                    <input type="text" class="form-control" name="shippingWeight" id="shippingWeight"
                                        value="{{ is_null(old('shippingWeight')) ? $product->shippingWeight : old('shippingWeight') }}">
                                    @error('shippingWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>shipping Dimensions</label>
                                    <input type="text" class="form-control" name="shippingDimensions"
                                        value="{{ is_null(old('shippingDimensions')) ? $product->shippingDimensions : old('shippingDimensions') }}">
                                    @error('shippingDimensions')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            {{-- <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>features</label>
                                    <input type="text" class="form-control" name="features" id="features"
                                        value="{{ is_null(old('features')) ? '' : old('features') }}">
                                    @error('features')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>genericKeywords</label>
                                    <input type="text" class="form-control" name="genericKeywords"
                                        value="{{ is_null(old('genericKeywords')) ? '' : old('genericKeywords') }}">
                                    @error('genericKeywords')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div> --}}


                            {{-- <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>certifications</label>
                                    <input type="text" class="form-control" name="certifications" id="certifications"
                                        value="{{ is_null(old('certifications')) ? '' : old('certifications') }}">
                                    @error('certifications')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>returnPolicy</label>
                                    <input type="text" id="returnPolicy" class="form-control" name="returnPolicy"
                                        value="{{ is_null(old('returnPolicy')) ? '' : old('returnPolicy') }}">
                                    @error('returnPolicy')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div> --}}
                         

                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>sku</label>
                                    <input type="text" class="form-control" name="sku"
                                        value="{{ is_null(old('sku')) ? $product->sku : old('sku') }}">
                                    @error('sku')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Warranty information</label>
                                          <textarea name="warranty_information" class="form-control" cols="30" rows="5">
                                          {{ is_null(old('warranty_information')) ? $product->warranty_information : old('warranty_information') }}</textarea>
    
                                    @error('warranty_information')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>Specifications</label>
                                    <input type="text" class="form-control" name="specifications"
                                        value="{{ is_null(old('specifications')) ? $product->specifications : old('specifications') }}">
                                    @error('specifications')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Benefits</label>
                                    <input type="text" class="form-control" name="benefits"
                                        value="{{ is_null(old('benefits')) ? $product->benefits : old('benefits') }}">
                                    @error('benefits')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class=" card">
                        <div class="card-body">

                            <button type="submit"
                                class="btn btn-outline-warning btn-fw">{{ __('dashboard/products.Edit') }}</button>
                            <a type="button" class="btn btn-outline-warning btn-fw"
                                href="{{ route('dashboard.products.index') }}">{{ __('dashboard/products.Cancel') }}</a>

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class=" card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <label class="col-12">{{ __('dashboard/products.product_categories') }}
                                            :</label><br>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($categories as $category)
                                            @if ($category->id == 1)
                                            @else
                                                <div class="form-check ">

                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input" name="category_id"
                                                            id="{{ 'flexCheckDefault' . ++$i }}"
                                                            value="{{ $category->id }}" @checked($category->id == $product->category_id)>
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    @error('categories')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class=" card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <label class="col-12">Vehicle Models
                                            :</label><br>
                                        @php
                                            $j = 0;
                                            $arr = $product->models->pluck('id')->toArray();
                                        @endphp

                                        @foreach ($models as $model)
                                            {{-- <div class="form-check ">

                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="model_id"
                                                        id="{{ 'flexCheckDefault' . ++$j }}"
                                                        value="{{ $model->id }}">
                                                    {{ $model->name }}
                                                </label>
                                            </div> --}}


                                            <div class="form-check ">
                                                <input class="form-check-input" type="checkbox" name='model_id[]'
                                                    value="{{ $model->id }}" id={{ 'flexRadioDefault' . ++$j }}
                                                    @checked(in_array($model->id, $arr))>
                                                <label class="form-check-label mr-3"
                                                    for={{ 'flexRadioDefault' . $j }}>{{ $model->manufacture->name . ' | ' . $model->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>

                                    @error('categories')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class=" card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-12">{{ __('dashboard/products.main_image') }}
                                    :</label><br>

                                <input class="form-file-input" type="file" name="main_image" id="flexCheckDefault" />
                                <img style='width:100px;height:100px;border:solid green 1px;;margin:1px'
                                    src='{{ $product->main_image }}' />
                            </div>

                            @error('main_image')
                                <div style="color:red">{{ $message }}</div><br>
                            @enderror

                        </div>
                    </div>
                    {{-- <div class=" card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <label class="col-12">{{ __('dashboard/products.main_image') }}
                                    :</label><br>

                                <input class="form-file-input col-12 form-control" type="file" name="main_image"
                                    id="" />
                                @error('main_image')
                                    <div style="color:red">{{ $message }}</div><br><br>
                                @enderror

                            </div>

                        </div>
                    </div> --}}
                </div>


            </div>
        </form>
    </div>
@endsection
@section('additional_scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $(".chosen-select").chosen({
                width: "100%"
            });


        });
        drp = document.getElementById('drop-zone');
        drp.addEventListener('dragover', e => {
            e.preventDefault();
        });
        drp.addEventListener('drop', e => {
            e.preventDefault();
            document.getElementById('img-input').files = e.dataTransfer.files;

            showImages();
        });
    </script>
@endsection
