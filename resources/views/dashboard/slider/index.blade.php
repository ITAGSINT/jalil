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
                        <h4 class="card-title ">Sliders</h4>
                        <br>
                        <hr>
                        <form action="{{ route('dashboard.slider.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-12  grid-margin">

                                    <div>
                                        <div class="form-group">
                                            <label>Title </label><br>
                                            <input type="text" class="form-control" style="margin-bottom: 2em;"
                                                name="title" value="{{ is_null(old('title')) ? '' : old('title') }}">
                                            @error('title')
                                                <div style="color:red">{{ $message }}</div><br>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Image </label>
                                            <div class="col-sm-3 imgUp">
                                                <div class="imagePreview"></div>
                                                <label class="btn btn-primary">
                                                    Upload
                                                    <input type="file" class="uploadFile img" value="Upload Photo"
                                                        id="main_image" name="main_image"
                                                        style="width: 0px;height: 0px;overflow: hidden;" accept=image/*>
                                                </label>
                                            </div>
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
                            <h4 class="card-title ">Sliders</h4>
                            <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">
                                Add</button>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table class="table" id="cat">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th> Title </th>
                                        <th>{{ __('dashboard/categories.image') }}</th>
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
                ajax: "{{ route('dashboard.slider.dataTable') }}",

                columns: [

                    {
                        "render": function(data, type, JsonResultRow, meta) {

                            return "<span class='pl-2 mr-3'>" + JsonResultRow.id +
                                "</span>";
                        }
                    },
                    {
                        data: 'title'
                    },
                    {
                        "render": function(data, type, JsonResultRow, meta) {

                            return "<img src='" + JsonResultRow.image +
                                "' alt='image'/>";
                        }
                    },


                    {
                        data: 'action'
                    }

                ]
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    ,
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                    }
                @endif

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
