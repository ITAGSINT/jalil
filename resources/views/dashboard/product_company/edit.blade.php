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
        <div class="row add-category">
            <div class="col-12 grid-margin">
                <div class="card" style="background-color: white;">
                    <div class="card-body">
                        <div style="display: flex;justify-content: space-between;">
                            <h6 class="card-title ">Edit</h6>
                        </div>
                        <hr>
                        <form action="{{ route('dashboard.product_company.update', $brand->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div>
                                <div>
                                    <input type="hidden" name="id" value="{{$brand->id}}">
                                    <label>Name </label><br>
                                    <input type="text" style="margin-bottom: 2em;" name="name"
                                        value="{{ is_null(old('name')) ? $brand->name : old('name') }}">
                                    @error('name')
                                        <div style="color:red">{{ $message }}</div><br>
                                    @enderror
                                    <br>
                                
                                     <br>
                                    <br>
                                </div>
                            </div>

                            <div style="margin:2em 0">
                                <button type="submit"
                                    class="btn btn-outline-warning btn-fw">{{ __('dashboard/categories.update') }}</button>
                                <a class="btn btn-outline-warning btn-fw" href={{ route('dashboard.product_brand.index') }}
                                    id="exit-client-btn">{{ __('dashboard/categories.cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script>
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
