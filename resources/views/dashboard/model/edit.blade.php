@extends('layouts.Dashboard.main')
@section('content')
    <style>
        .imagePreview {
            width: 100%;
            height: 180px;
            background-position: center center;
            background: url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
            background-color: #fff;
            background-size: cover;
            background-repeat: no-repeat;
            display: inline-block;
            box-shadow: 0px -3px 6px 2px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            display: block;
            border-radius: 0px;
            box-shadow: 0px 4px 6px 2px rgba(0, 0, 0, 0.2);
            margin-top: -5px;
        }

        .imgUp {
            margin-bottom: 15px;
        }

        .del {
            position: absolute;
            top: 0px;
            right: 15px;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            background-color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        /*.imgAdd*/
        /*{*/
        /*  width:30px;*/
        /*  height:30px;*/
        /*  border-radius:50%;*/
        /*  background-color:#4bd7ef;*/
        /*  color:#fff;*/
        /*  box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);*/
        /*  text-align:center;*/
        /*  line-height:30px;*/
        /*  margin-top:0px;*/
        /*  cursor:pointer;*/
        /*  font-size:15px;*/
        /*}    */
    </style>
    <div class="content-wrapper  tab-one ">
        <div class="row ">

            <div class="col-12 grid-margin add-category" style="display: none;">
                <div class="card">
                    <div class="card-body">

                        <br>
                        <hr>
                        <form action="{{ route('dashboard.model_color.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12  grid-margin">

                                    <div>
                                        <input type="hidden" name="model_id" value="{{ $brand->id }}">
                                        <input  type="hidden"  name="color_id" id="color_id1" value="{{ $brand->id }}">
                                        <div class="form-group">
                                            <select class="form-control w-50" name="color_id" id="color_id">

                                                @foreach ($colors as $color)
                                                    <option value="{{ $color->id }}">{{ $color->name }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Image </label><br>
                                            <input class="form-control w-50" type="file" style="margin-bottom: 2em;"
                                                name="image" value="{{ is_null(old('image')) ? '' : old('image') }}">
                                            @error('image')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <br>


                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div style="margin:2em 0">
                                <button type="submit" class="btn btn-outline-warning btn-fw">submit</button>
                                <button type="button" class="btn btn-outline-warning btn-fw"
                                    id="exit-cat-btn">{{ __('dashboard/categories.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 grid-margin">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h6 class="card-title ">Edit</h6>
                        </div>
                        <hr>
                        <form action="{{ route('dashboard.model.update', $brand->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div>
                                <div class="form-group">
                                    <input type="hidden" name="id" value="{{ $brand->id }}">
                                    <label>Name </label><br>
                                    <input class="form-control w-50" type="text" style="margin-bottom: 2em;"
                                        name="name" value="{{ is_null(old('name')) ? $brand->name : old('name') }}">
                                    @error('name')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror

                                </div>

                                <div class="form-group">
                                    <select class="form-control w-50" name="manufacturer_id" id="manufacturer_id">

                                        @foreach ($manufacturers as $manufacturer)
                                            <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>


                            <div style="margin:2em 0">
                                <button type="submit"
                                    class="btn btn-outline-warning btn-fw">{{ __('dashboard/categories.update') }}</button>
                                <a class="btn btn-outline-warning btn-fw" href={{ route('dashboard.model.index') }}
                                    id="exit-client-btn">{{ __('dashboard/categories.cancel') }}</a>
                            </div>
                        </form>
                        <div>
                            <div class="w-100 mb-4">
                                <h4 class="d-inline">Color Variations</h4>


                                <button type="button" class="float-right btn btn-warning btn-fw " id="add-cat-btn">Add
                                    Color
                                    Variaton
                                </button>
                            </div>
                            <table class="table table-bordered shadow table-striped-columns">
                                <thead>
                                    {{-- <th>
                                    id
                                </th> --}}
                                    <th class="w-50">
                                        Color
                                    </th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                    @foreach ($brand->colors as $item)
                                        <tr>
                                            {{-- <td>{{ $item->id }}</td> --}}
                                            <td>{{ $item->name }}</td>
                                            <td><img src="{{ $item->pivot->image }}" class="w-50" alt="">
                                            </td>
                                            <td>
                                                <button type="button" class=" btn btn-warning btn-fw "
                                                    onclick="
                                                   console.log(  $('#color_id > option[value={{ $item->id }}]'));
                                                    $('#color_id > option[value={{ $item->id }}]').prop('selected', true);
                                                 $('#color_id').prop('disabled', true); 
                                                 $('#color_id1').val('{{ $item->id }}'); 
                                                    ;$('.add-category').slideDown(800);">
                                                    Edit
                                                </button>

                                              
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
    <script>

      
        $(function() {

            $('#add-cat-btn').click(function() {
                $('.add-category').slideDown(800);
                $('#color_id').prop('disabled', false);
            });
            $('#exit-cat-btn').click(function() {
                $('.add-category').slideUp(800);
                $('#color_id').prop('disabled', false);
            });


        });
        $(document).on("click", "i.del", function() {
            // 	to remove card
            $(this).parent().remove();
            // to clear image
            // $(this).parent().find('.imagePreview').css("background-image","url('')");
        });
        $(function() {
            $(document).on("change", ".uploadFile", function() {
                var uploadFile = $(this);
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader)
                    return; // no file selected, or no FileReader support

                if (/^image/.test(files[0].type)) { // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file

                    reader.onloadend = function() { // set image data as background of div
                        //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                        uploadFile.closest(".imgUp").find('.imagePreview').css("background-image",
                            "url(" + this.result + ")");
                    }
                }

            });
        });
    </script>
@endsection
