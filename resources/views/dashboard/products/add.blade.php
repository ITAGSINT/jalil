@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        element.style {}

        .table:not(.table-sm):not(.table-md):not(.dataTable) td,
        .table:not(.table-sm):not(.table-md):not(.dataTable) th {
            padding: 0 15px;
            height: 60px;
            vertical-align: middle;
        }

        .card .card-body {
            padding: 2rem;
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
        <form action="{{ route('dashboard.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row  add-product">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title " style="padding-bottom: 0;margin-bottom: 0;">
                                {{ __('dashboard/products.add_product') }}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class=" card mb-4">
                        <div class="card-body">


                            <div class="row" style="width:100%!important;">
                                <div class="col-12">
                                    {{-- <div class="row">
                                        <div class="col-12">
                                            <h6>Product type :</h6>
                                        </div>
                                        <div class="col-12">

                                            <input type="radio" id="1" name="type" value="1">
                                            <label for="html">Battery</label><br>
                                            <input type="radio" id="2" name="type" value="2">
                                            <label for="css">Tyre</label><br>
                                            <input type="radio" id="2" name="type" value="2">
                                            <label for="css">CarWash</label><br>



                                        </div>
                                    </div> --}}
                                    <div class="row">
                                        <div class="col-12">
                                            <h6>{{ __('dashboard/products.product_name') }} :</h6>
                                        </div>

                                        <div class="col-lg-12 col-12">

                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ is_null(old('name')) ? '' : old('name') }}">
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

                                            <textarea name="description" class="form-control" cols="30" rows="5">{{ is_null(old('description')) ? '' : old('description') }}</textarea>
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
                                                value="{{ is_null(old('selling_price')) ? '' : old('selling_price') }}">
                                            @error('selling_price')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror

                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <label for="discount_price">Discount Price</label><br>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" value="{{ is_null(old('discount_price')) ? 0 : old('discount_price') }}">
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
                                    <input type="text" class="form-control" name="quantity" id="quantity"
                                        value="{{ is_null(old('quantity')) ? '' : old('quantity') }}">
                                    @error('quantity')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                                <div class="col-lg-6 col-12">
                                    <label>Size</label>
                                    <input type="text" class="form-control" name="size" id="size"
                                        value="{{ is_null(old('size')) ? '' : old('size') }}">
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
                                            <option value="{{ $product_company->id }}"
                                                 @selected((is_null(old('company')) ? '' : old('company'))==$product_company->id)>
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
                                            <option value="{{ $product_brand->id }}"
                                                @selected((is_null(old('brand')) ? '' : old('brand'))==$product_brand->id)>
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
                                            <option value="{{ $product_manufacturers->id }}"
                                                @selected((is_null(old('manufacturer')) ? '' : old('manufacturer'))==$product_manufacturers->id)>
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
                                        <option value="">country</option>
                                        <option value="Afghanistan">Afghanistan</option>
                                        <option value="Åland Islands">Åland Islands</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Algeria">Algeria</option>
                                        <option value="American Samoa">American Samoa</option>
                                        <option value="Andorra">Andorra</option>
                                        <option value="Angola">Angola</option>
                                        <option value="Anguilla">Anguilla</option>
                                        <option value="Antarctica">Antarctica</option>
                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Armenia">Armenia</option>
                                        <option value="Aruba">Aruba</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Azerbaijan">Azerbaijan</option>
                                        <option value="Bahamas">Bahamas</option>
                                        <option value="Bahrain">Bahrain</option>
                                        <option value="Bangladesh">Bangladesh</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belarus">Belarus</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Belize">Belize</option>
                                        <option value="Benin">Benin</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Bhutan">Bhutan</option>
                                        <option value="Bolivia (Plurinational State of)">Bolivia (Plurinational State of)
                                        </option>
                                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                        <option value="Botswana">Botswana</option>
                                        <option value="Bouvet Island">Bouvet Island</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory
                                        </option>
                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Burkina Faso">Burkina Faso</option>
                                        <option value="Burundi">Burundi</option>
                                        <option value="Cabo Verde">Cabo Verde</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Cameroon">Cameroon</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Caribbean Netherlands">Caribbean Netherlands</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Central African Republic">Central African Republic</option>
                                        <option value="Chad">Chad</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China">China</option>
                                        <option value="Christmas Island">Christmas Island</option>
                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Comoros">Comoros</option>
                                        <option value="Congo">Congo</option>
                                        <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the
                                        </option>
                                        <option value="Cook Islands">Cook Islands</option>
                                        <option value="Costa Rica">Costa Rica</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cuba">Cuba</option>
                                        <option value="Curaçao">Curaçao</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Côte d'Ivoire">Côte d'Ivoire</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Djibouti">Djibouti</option>
                                        <option value="Dominica">Dominica</option>
                                        <option value="Dominican Republic">Dominican Republic</option>
                                        <option value="Ecuador">Ecuador</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="El Salvador">El Salvador</option>
                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                        <option value="Eritrea">Eritrea</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Eswatini (Swaziland)">Eswatini (Swaziland)</option>
                                        <option value="Ethiopia">Ethiopia</option>
                                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                        <option value="Faroe Islands">Faroe Islands</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="French Guiana">French Guiana</option>
                                        <option value="French Polynesia">French Polynesia</option>
                                        <option value="French Southern Territories">French Southern Territories</option>
                                        <option value="Gabon">Gabon</option>
                                        <option value="Gambia">Gambia</option>
                                        <option value="Georgia">Georgia</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Greenland">Greenland</option>
                                        <option value="Grenada">Grenada</option>
                                        <option value="Guadeloupe">Guadeloupe</option>
                                        <option value="Guam">Guam</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Guernsey">Guernsey</option>
                                        <option value="Guinea">Guinea</option>
                                        <option value="Guinea-Bissau">Guinea-Bissau</option>
                                        <option value="Guyana">Guyana</option>
                                        <option value="Haiti">Haiti</option>
                                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands
                                        </option>
                                        <option value="Honduras">Honduras</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Iran">Iran</option>
                                        <option value="Iraq">Iraq</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Jersey">Jersey</option>
                                        <option value="Jordan">Jordan</option>
                                        <option value="Kazakhstan">Kazakhstan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kiribati">Kiribati</option>
                                        <option value="Korea, North">Korea, North</option>
                                        <option value="Korea, South">Korea, South</option>
                                        <option value="Kosovo">Kosovo</option>
                                        <option value="Kuwait">Kuwait</option>
                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic
                                        </option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Lebanon">Lebanon</option>
                                        <option value="Lesotho">Lesotho</option>
                                        <option value="Liberia">Liberia</option>
                                        <option value="Libya">Libya</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macao">Macao</option>
                                        <option value="Macedonia North">Macedonia North</option>
                                        <option value="Madagascar">Madagascar</option>
                                        <option value="Malawi">Malawi</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Maldives">Maldives</option>
                                        <option value="Mali">Mali</option>
                                        <option value="Malta">Malta</option>
                                        <option value="Marshall Islands">Marshall Islands</option>
                                        <option value="Martinique">Martinique</option>
                                        <option value="Mauritania">Mauritania</option>
                                        <option value="Mauritius">Mauritius</option>
                                        <option value="Mayotte">Mayotte</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Micronesia">Micronesia</option>
                                        <option value="Moldova">Moldova</option>
                                        <option value="Monaco">Monaco</option>
                                        <option value="Mongolia">Mongolia</option>
                                        <option value="Montenegro">Montenegro</option>
                                        <option value="Montserrat">Montserrat</option>
                                        <option value="Morocco">Morocco</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar (Burma)">Myanmar (Burma)</option>
                                        <option value="Namibia">Namibia</option>
                                        <option value="Nauru">Nauru</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                        <option value="New Caledonia">New Caledonia</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nicaragua">Nicaragua</option>
                                        <option value="Niger">Niger</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Niue">Niue</option>
                                        <option value="Norfolk Island">Norfolk Island</option>
                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Oman">Oman</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Palau">Palau</option>
                                        <option value="Palestine">Palestine</option>
                                        <option value="Panama">Panama</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="Paraguay">Paraguay</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Philippines">Philippines</option>
                                        <option value="Pitcairn Islands">Pitcairn Islands</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Puerto Rico">Puerto Rico</option>
                                        <option value="Qatar">Qatar</option>
                                        <option value="Reunion">Reunion</option>
                                        <option value="Romania">Romania</option>
                                        <option value="Russian Federation">Russian Federation</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Saint Barthelemy">Saint Barthelemy</option>
                                        <option value="Saint Helena">Saint Helena</option>
                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                        <option value="Saint Lucia">Saint Lucia</option>
                                        <option value="Saint Martin">Saint Martin</option>
                                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines
                                        </option>
                                        <option value="Samoa">Samoa</option>
                                        <option value="San Marino">San Marino</option>
                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Senegal">Senegal</option>
                                        <option value="Serbia">Serbia</option>
                                        <option value="Serbia and Montenegro">Serbia and Montenegro</option>
                                        <option value="Seychelles">Seychelles</option>
                                        <option value="Sierra Leone">Sierra Leone</option>
                                        <option value="Singapore">Singapore</option>
                                        <option value="Sint Maarten">Sint Maarten</option>
                                        <option value="Slovakia">Slovakia</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Solomon Islands">Solomon Islands</option>
                                        <option value="Somalia">Somalia</option>
                                        <option value="South Africa">South Africa</option>
                                        <option value="South Georgia and the South Sandwich Islands">South Georgia and the
                                            South Sandwich Islands</option>
                                        <option value="South Sudan">South Sudan</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="Sudan">Sudan</option>
                                        <option value="Suriname">Suriname</option>
                                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Syria">Syria</option>
                                        <option value="Taiwan">Taiwan</option>
                                        <option value="Tajikistan">Tajikistan</option>
                                        <option value="Tanzania">Tanzania</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="Timor-Leste">Timor-Leste</option>
                                        <option value="Togo">Togo</option>
                                        <option value="Tokelau">Tokelau</option>
                                        <option value="Tonga">Tonga</option>
                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                        <option value="Tunisia">Tunisia</option>
                                        <option value="Turkey (Türkiye)">Turkey (Türkiye)</option>
                                        <option value="Turkmenistan">Turkmenistan</option>
                                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                        <option value="Tuvalu">Tuvalu</option>
                                        <option value="U.S. Outlying Islands">U.S. Outlying Islands</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="United States">United States</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="Uzbekistan">Uzbekistan</option>
                                        <option value="Vanuatu">Vanuatu</option>
                                        <option value="Vatican City Holy See">Vatican City Holy See</option>
                                        <option value="Venezuela">Venezuela</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                                        <option value="Virgin Islands, U.S">Virgin Islands, U.S</option>
                                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                                        <option value="Western Sahara">Western Sahara</option>
                                        <option value="Yemen">Yemen</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
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
                                        value="{{ is_null(old('code')) ? '' : old('code') }}">

                                    @error('code')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>promotional text</label>
                                    <input type="text" class="form-control" name="promotional_text"
                                        value="{{ is_null(old('promotional_text')) ? '' : old('promotional_text') }}">
                                    @error('promotional_text')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>capacity</label>
                                    <input type="text" class="form-control" name="capacity" id="capacity"
                                        value="{{ is_null(old('capacity')) ? '' : old('capacity') }}">
                                    @error('capacity')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>capacity Unit</label>
                                    <select class="form-control" name="capacity_u" id="capacity_u">

                                        <option value="mah"
                                        @selected((is_null(old('capacity_u')) ? '' : old('capacity_u'))=='mah')
                                        >mAh </option>


                                    </select> @error('capacity_u')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>netWeight</label>
                                    <input type="text" class="form-control" name="netWeight" id="netWeight"
                                        value="{{ is_null(old('netWeight')) ? '' : old('netWeight') }}">
                                    @error('netWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>netWeight Unit</label>
                                    <select class="form-control" name="netWeight_u" id="netWeight_u">

                                        <option value="kg"
                                           @selected((is_null(old('netWeight_u')) ? '' : old('netWeight_u'))=='kg')>Kg </option>
                                        <option value="g"
                                         @selected((is_null(old('netWeight_u')) ? '' : old('netWeight_u'))=='g')>g </option>

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
                                        value="{{ is_null(old('grossWeight')) ? '' : old('grossWeight') }}">
                                    @error('grossWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>grossWeight Unit</label>
                                    <select class="form-control" name="grossWeight_u" id="grossWeight_u">

                                        <option value="kg"
                                           @selected((is_null(old('grossWeight_u')) ? '' : old('grossWeight_u'))=='kg')>Kg </option>
                                        <option value="g"
                                         @selected((is_null(old('grossWeight_u')) ? '' : old('grossWeight_u'))=='g')>g </option>

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
                                        value="{{ is_null(old('width')) ? '' : old('width') }}">
                                    @error('width')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>width Unit</label>
                                    <select class="form-control" name="width_u" id="width_u">
                                        <option value="mm"
                                        @selected((is_null(old('width_u')) ? '' : old('width_u'))=='mm')
                                        >mm </option>
                                        <option value="Cm"
                                        @selected((is_null(old('width_u')) ? '' : old('width_u'))=='Cm')>Cm </option>
                                        <option value="m"
                                        @selected((is_null(old('width_u')) ? '' : old('width_u'))=='m')>m </option>

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
                                        value="{{ is_null(old('length')) ? '' : old('length') }}">
                                    @error('length')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>length Unit</label>
                                    <select class="form-control" name="length_u" id="length_u">
                                        <option value="mm"
                                        @selected((is_null(old('length_u')) ? '' : old('length_u'))=='mm')
                                        >mm </option>
                                        <option value="Cm"
                                        @selected((is_null(old('length_u')) ? '' : old('length_u'))=='Cm')>Cm </option>
                                        <option value="m"
                                        @selected((is_null(old('length_u')) ? '' : old('length_u'))=='m')>m </option>

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
                                        value="{{ is_null(old('height')) ? '' : old('height') }}">
                                    @error('height')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>height Unit</label>
                                    <select class="form-control" name="height_u" id="height_u">
                                        <option value="mm"
                                        @selected((is_null(old('height_u')) ? '' : old('height_u'))=='mm')
                                        >mm </option>
                                        <option value="Cm"
                                        @selected((is_null(old('height_u')) ? '' : old('height_u'))=='Cm')>Cm </option>
                                        <option value="m"
                                        @selected((is_null(old('height_u')) ? '' : old('height_u'))=='m')>m </option>


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
                                        value="{{ is_null(old('warrantyPeriod')) ? '' : old('warrantyPeriod') }}">
                                    @error('warrantyPeriod')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>warranty Type</label>
                                    <input type="text" class="form-control" name="warrantyType"
                                        value="{{ is_null(old('warrantyType')) ? '' : old('warrantyType') }}">
                                    @error('warrantyType')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>


                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>shipping Weight</label>
                                    <input type="text" class="form-control" name="shippingWeight" id="shippingWeight"
                                        value="{{ is_null(old('shippingWeight')) ? '' : old('shippingWeight') }}">
                                    @error('shippingWeight')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>shipping Dimensions</label>
                                    <input type="text" class="form-control" name="shippingDimensions"
                                        value="{{ is_null(old('shippingDimensions')) ? '' : old('shippingDimensions') }}">
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
                                        value="{{ is_null(old('sku')) ? '' : old('sku') }}">
                                    @error('sku')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Warranty information</label>
                                          <textarea name="warranty_information" class="form-control" cols="30" rows="5">
                                            {{ is_null(old('warranty_information')) ? '' : old('warranty_information') }}</textarea>

                                    @error('warranty_information')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <label>Specifications</label>
                                    <input type="text" class="form-control" name="specifications"
                                        value="{{ is_null(old('specifications')) ? '' : old('specifications') }}">
                                    @error('specifications')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>
                                <div class="col-lg-6 col-12">
                                    <label>Benefits</label>
                                    <input type="text" class="form-control" name="benefits"
                                        value="{{ is_null(old('benefits')) ? '' : old('benefits') }}">
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
                                class="btn btn-outline-warning btn-fw">{{ __('dashboard/products.Add') }}</button>
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
                                                            value="{{ $category->id }}">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            @endif
                                            {{-- <input class="form-check-input" type="checkbox" name='category_id'
                                                    value="{{ $category->id }}" id={{ 'flexCheckDefault' . ++$i }} />
                                                <label class="form-check-label mr-3"
                                                    for={{ 'flexCheckDefault' . $i }}>{{ $category->name }}</label> --}}
                                        @endforeach
                                    </div>

                                    @error('categories')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                            </div>
                        </div>
                    </div>
                    {{-- <div class=" card mb-4">
                        <div class="card-body">


                            <div class="row">

                                <div class="col-12">
                                    <label>{{ __('dashboard/products.ask_visible') }}
                                        :</label>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" name='visible'
                                            id={{ 'flexCheckDefault' }} />
                                        <label class="form-check-label mr-3"
                                            for={{ 'flexCheckDefault' }}>{{ __('dashboard/products.yes') }}</label>
                                    </div>

                                </div>

                                <div class="col-12">
                                    <label>{{ __('dashboard/products.is_feature') }}
                                        :</label>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" name='is_feature'
                                            id={{ 'flexCheckDefault' }} />
                                        <label class="form-check-label mr-3"
                                            for={{ 'flexCheckDefault' }}>{{ __('dashboard/products.yes') }}</label>
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label>{{ __('dashboard/products.is_new_collection') }}
                                        :</label>
                                    <div class="form-check ">
                                        <input class="form-check-input" type="checkbox" name='new_collection'
                                            id={{ 'flexCheckDefault' }} />
                                        <label class="form-check-label mr-3"
                                            for={{ 'flexCheckDefault' }}>{{ __('dashboard/products.yes') }}</label>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div> --}}

                    <div class=" card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <label class="col-12">Vehicle Models
                                            :</label><br>
                                        @php
                                            $j = 0;
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
                                                    value="{{ $model->id }}" id={{ 'flexRadioDefault' . ++$j }} />
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

                                <input class="form-file-input col-12 form-control" type="file" name="main_image"
                                    id="" />
                                @error('main_image')
                                    <div style="color:red">{{ $message }}</div><br><br>
                                @enderror

                            </div>
                            {{-- <hr class="col-12">
                            <div class="row" style="/*margin:50px 0 50px 0!important ;*/">


                                <div class="col-md-12 p-0">
                                    <label>{{ __('dashboard/products.images') }} :</label>
                                    <!-- make a drop images zone -->
                                    <div id='drop-zone'>
                                        <label class='d-flex justify-content-center' for="img-input">
                                            <span
                                                style="border:dashed #6C7293 2px;padding:5px;width:400px;height:200px;text-align:center;padding-top:15%">
                                                {{ __('dashboard/products.Drop_images_Here') }} </span>
                                        </label>

                                        <input id="img-input" type=file name="images[]" class="form-control" hidden
                                            multiple onchange="showImages()">
                                    </div>

                                    <div class="d-flex justify-content-center" id='img_show'>
                                    </div>
                                    @error('images.*')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror
                                </div>
                            </div> --}}
                        </div>
                    </div>
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

            $('.delete_row').on("click", function() {
                $(this).closest('tr').remove();
                alert('d')
            });
            $(".chosen-select").chosen({
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    rtl: true,
                @else
                    rtl: false,
                @endif

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

        function showImages() {

            document.getElementById('img_show').innerHTML = "";
            Array.from(document.getElementById('img-input').files).forEach(file => {
                console.log(file.type);
                if (file.type.startsWith('image/')) {
                    let url = URL.createObjectURL(file);
                    let img = new Image();
                    img.src = url;
                    img.style = "width:100px;height:100px;border:solid green 1px;;margin:1px";
                    document.getElementById('img_show').appendChild(img);
                    img.onload = function() {
                        URL.revokeObjectURL(this.src);
                    }
                }
            });
        }
    </script>
@endsection
