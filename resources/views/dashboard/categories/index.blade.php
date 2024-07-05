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
    <div class="content-wrapper tab-one">
        <div class="row  add-category" style="display: none;">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title ">{{ __('dashboard/categories.new_cat') }}</h4>
                        <br>
                        <hr>
                        <form action="{{ route('dashboard.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12  grid-margin">

                                    <div>
                                        <div>
                                            <label>Name </label><br>
                                            <input type="text" class="form-control" style="margin-bottom: 2em;"
                                                name="name" value="{{ is_null(old('name')) ? '' : old('name') }}">
                                            @error('name')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <br>

                                            <label>{{ __('dashboard/categories.parent_category') }}</label>
                                            <select name="parent_id" class="form-control" id="cars"
                                                style="margin-bottom: 2em;">
                                                <option value="0" selected>Parent</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ is_null(old('parent_id')) ? '' : (old('parent_id') == $category->id ? 'selected' : '') }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('parent_id')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                            <div class="col-12">
                                                <h6>{{ __('dashboard/categories.image') }}:</h6>
                                            </div>
                                            <br>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-sm-3 imgUp">
                                                        <div class="imagePreview"></div>
                                                        <label class="btn btn-primary">
                                                            Upload
                                                            <input type="file" class="uploadFile img"
                                                                value="Upload Photo" id="main_image" name="main_image"
                                                                style="width: 0px;height: 0px;overflow: hidden;"
                                                                accept=image/*>
                                                        </label>
                                                    </div><!-- col-2 -->
                                                    <!--<i class="fa fa-plus imgAdd"></i>-->
                                                </div><!-- row -->
                                            </div><!-- container -->

                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div style="margin:2em 0">
                                <button type="submit"
                                    class="btn btn-outline-warning btn-fw">{{ __('dashboard/categories.add') }}</button>
                                <button type="button" class="btn btn-outline-warning btn-fw"
                                    id="exit-cat-btn">{{ __('dashboard/categories.cancel') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row ">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h4 class="card-title "> {{ __('dashboard/categories.categories') }}</h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">
                                {{ __('dashboard/categories.add_category') }} </button>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table class="table" id="cat">
                                <thead>
                                    <tr>
                                        <th> {{ __('dashboard/categories.category_id') }}</th>
                                        <th>{{ __('dashboard/categories.image') }}</th>
                                        <th> {{ __('dashboard/categories.category_name') }} </th>
                                        <th>{{ __('dashboard/categories.parent_category') }} </th>
                                        <th>{{ __('dashboard/categories.action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
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
            });
            $('#exit-cat-btn').click(function() {
                $('.add-category').slideUp(800);
            });


        });


        $(document).ready(function() {

            $('#cat').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('dashboard.categories.dataTable') }}",

                columns: [

                    {
                        "render": function(data, type, JsonResultRow, meta) {

                            return "<span class='pl-2 mr-3'>" + JsonResultRow.id +
                                "</span>";
                        }
                    },

                    {
                        "render": function(data, type, JsonResultRow, meta) {

                            return "<img src='" + JsonResultRow.image +
                                "' alt='image'/>";
                        }
                    },
                    {
                        data: 'name'
                    },
                    {
                        "render": function(data, type, JsonResultRow, meta) {
                            if (JsonResultRow.parent_category)
                                return JsonResultRow.parent_category.name;

                            else
                                return "_";
                        }
                    },
                    {
                        data: 'action'
                    }

                ]
               

            });
        });





        // $(".imgAdd").click(function(){
        //   $(this).closest(".row").find('.imgAdd').before('<div class="col-sm-2 imgUp"><div class="imagePreview"></div><label class="btn btn-primary">Upload<input type="file" class="uploadFile img" value="Upload Photo" style="width:0px;height:0px;overflow:hidden;"></label><i class="fa fa-times del"></i></div>');
        // });
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
