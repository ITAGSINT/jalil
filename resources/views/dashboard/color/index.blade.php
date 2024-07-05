@extends('layouts.Dashboard.main')
@section('additional_styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css"
        integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
    <div class="content-wrapper tab-one">

        <div class="content-wrapper tab-one">
            <div class="row  add-category" style="display: none;">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">

                            <br>
                            <hr>
                            <form action="{{ route('dashboard.color.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12  grid-margin">

                                        <div>
                                            <div class="form-group">
                                                <label>Name </label><br>
                                                <input class="form-control w-50" type="text" style="margin-bottom: 2em;"
                                                    name="name" value="{{ is_null(old('name')) ? '' : old('name') }}">
                                                @error('name')
                                                    <div style="color:red">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label>Color </label><br>
                                                <input class="form-control w-50" type="color" style="margin-bottom: 2em;"
                                                    name="hex_code" value="{{ is_null(old('hex_code')) ? '' : old('hex_code') }}">
                                                @error('hex_code')
                                                    <div style="color:red">{{ $message }}</div>
                                                @enderror
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
                                <h4 class="card-title mb-0" style=""> Colors</h4>
                                <div style="display: flex;justify-content: space-between;">

                                    <button type="button" class="btn btn-warning btn-fw " id="add-cat-btn">Add Color
                                    </button>
                                </div>

                            </div>
                            <hr>
                            <div class="table-responsive mt-3">
                                <table class="table display  " id="cat">

                                    <thead>
                                        <tr>
                                            <th>Color Id</th>

                                            <th> Color Name </th>
                                            <th>Color </th>
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
            @if (Session::get('errors'))
                {

                    $('.add-product').slideDown(800);

                }
            @endif

            /* Formatting function for row details - modify as you need */
            function format(d) {
                // `d` is the original data object for the row
                return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +

                    '<tr>' +
                    "<td>{{ __('dashboard/products.action') }}</td>" +
                    '<td>' + d.action + '</td>' +
                    '</tr>' +
                    '</table>';
            }


            $(document).ready(function() {

                $('#cat').DataTable({
                    processing: true,
                    info: true,
                    lengthMenu: [5, 10, 50],
                    order: [
                        [0, "desc"]
                    ],
                    ajax: "{{ route('dashboard.color.dataTable') }}",

                    columns: [

                        {
                            data: 'id'
                        },

                        {

                            data: 'name'
                        },
                        {
                            "render": function(data, type, row) {
                                var color = row.hex_code;
                                var str =
                                    "<button class='w-100 p-3 border rounded shadow' style='background:" +
                                    color +
                                    "' disabled></button>"

                                return str;
                            }
                            // data: 'hex_code'
                        }

                        ,
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