@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
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

        <div class="content-wrapper tab-one">
            <div class="row  add-category" style="display: none;">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">

                            <br>
                            <hr>
                            <form action="{{ route('dashboard.manufacturer.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12  grid-margin">

                                        <div>
                                            <div class="form-group">
                                                <label>Name </label><br>
                                                <input class="form-control w-50" type="text" style="margin-bottom: 2em;"
                                                    name="name" value="{{ is_null(old('name')) ? '' : old('name') }}"
                                                    required>
                                                @error('name')
                                                    <div style="color:red">{{ $message }}</div><br>
                                                @enderror


                                            </div>

                                            <div class="form-group">
                                                <label>Type </label><br>
                                                <div class="form-group">
                                                    <label for="car_yes">
                                                        <input type="radio" class="form-radio" name="is_car"
                                                            id="car_yes" value="1">
                                                        Car</label>

                                                </div>
                                                <div class="form-group">
                                                    <label for="car_no">
                                                        <input type="radio" class="form-radio" name="is_car"
                                                            id="car_no" value="2">
                                                        Motorcycle
                                                    </label>

                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="">Logo</label>
                                                <div class="col-sm-3 imgUp">
                                                    <div class="imagePreview"></div>
                                                    <label class="btn btn-primary">
                                                        Upload
                                                        <input type="file" class="uploadFile img" value="Upload Photo"
                                                            id="main_image" name="logo"
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
                                <h4 class="card-title mb-0" style=""> Manufacturers</h4>
                                <div style="display: flex;justify-content: space-between;">

                                    <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">Add Manufacturer
                                    </button>
                                </div>

                            </div>
                            <hr>
                            <div class="table-responsive mt-3">
                                <table class="table display  " id="cat">

                                    <thead>
                                        <tr>
                                            <th>Manufacturer Id</th>
                                            <th>Manufacturer Logo</th>
                                            <th> Manufacturer Name </th>
                                            <th> </th>


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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
            integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(function() {

                $('#add-cat-btn').click(function() {
                    $('.add-category').slideDown(800);
                });
                $('#exit-cat-btn').click(function() {
                    $('.add-category').slideUp(800);
                });


            });
            $(function() {

                $('#add-product-btn').click(function() {
                    $('.add-product').slideDown(800);
                });
                $('#exit-product-btn').click(function() {
                    $('.add-product').slideUp(800);
                });


            });
            // @if (Session::get('errors'))
            //     {

            //         $('.add-product').slideDown(800);

            //     }
            // @endif

            // /* Formatting function for row details - modify as you need */
            // function format(d) {
            //     // `d` is the original data object for the row
            //     return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

            //         '<tr>' +
            //         "<td>{{ __('dashboard/products.action') }}</td>" +
            //         '<td>' + d.action + '</td>' +
            //         '</tr>' +
            //         '</table>';
            // }


            $(document).ready(function() {

                $('#cat').DataTable({
                    processing: true,
                    info: true,
                    lengthMenu: [5, 10, 50],
                    order: [
                        [0, "desc"]
                    ],
                    ajax: "{{ route('dashboard.manufacturer.dataTable') }}",

                    columns: [

                        {
                            data: 'id'
                        }

                        ,
                        {
                            "render": function(data, type, row) {
                                var color = row.logo;
                                var str =
                                    "<img class='w-50 p-3 border rounded shadow' src='" +
                                    color +
                                    "' ></img>"

                                return str;
                            }
                        },
                        {
                            data: 'name'
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
            // drp = document.getElementById('drop-zone');
            // drp.addEventListener('dragover', e => {
            //     e.preventDefault();
            // });
            // drp.addEventListener('drop', e => {
            //     e.preventDefault();
            //     document.getElementById('img-input').files = e.dataTransfer.files;

            //     showImages();
            // });

            // function showImages() {

            //     document.getElementById('img_show').innerHTML = "";
            //     Array.from(document.getElementById('img-input').files).forEach(file => {
            //         console.log(file.type);
            //         if (file.type.startsWith('image/')) {
            //             let url = URL.createObjectURL(file);
            //             let img = new Image();
            //             img.src = url;
            //             img.style = "width:100px;height:100px;border:solid green 1px;;margin:1px";
            //             document.getElementById('img_show').appendChild(img);
            //             img.onload = function() {
            //                 URL.revokeObjectURL(this.src);
            //             }
            //         }
            //     });
            // }

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
