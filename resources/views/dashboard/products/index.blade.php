@extends('layouts.Dashboard.main')
@section('additional_styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection
@section('content')
<div class="content-wrapper tab-one"  >


<div class="row ">

  <div class="col-12 grid-margin">
      <div class="card">
          <div class="card-body">
              <div style="display: flex;justify-content: space-between;">
                  <h4 class="card-title mb-0" style=""> {{ __('dashboard/products.products') }}</h4>
                  <a  type="button" class="btn btn-warning btn-fw "
                   href="{{ route('dashboard.products.Add') }}">{{ __('dashboard/products.add_product') }}</a>

              </div>
              <hr>
              <div class="table-responsive mt-3">
                  <table class="table display  " id="cat">

                      <thead>
                          <tr>
                              <th></th>
                              <th> {{ __('dashboard/products.product_id') }} </th>
                              <th> {{ __('dashboard/products.product_name') }}</th>
                              <th> {{ __('dashboard/products.product_categories') }}</th>
                              <th> {{ __('dashboard/products.price') }}</th>
                              {{-- <th> Original_price</th> --}}

                          </tr>
                      </thead>
                      <tbody >

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>  <script>
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
            $(".chosen-select").chosen({rtl: true,width:"100%"});
            var table = $('#cat').DataTable({
                processing: true,
                info: true,
                lengthMenu: [5, 10, 50],
                order: [
                    [0, "desc"]
                ],
                ajax: "{{ route('dashboard.products.dataTable') }}",
                columns: [{
                        "className": 'dt-control',
                        "orderable": false,
                        "data": null,
                        "defaultContent": ''
                    }, {

                        "render": function(data, type, JsonResultRow, meta) {
                            if (JsonResultRow.main_image)
                                return "<img src='" + JsonResultRow.main_image +
                                    "' alt='image'/>" +
                                    "<span class='pl-2 mr-3'>" + JsonResultRow.id +
                                    "</span>";
                            else
                                return "<img style='width=15px;hieght:15px;border:solid ;border-radius:100%' />" +

                                    "<span class='pl-2 mr-3'>" + JsonResultRow.id +
                                    "</span>";
                        }
                    },

                    {
                        data: 'name'
                    },
                    {
                        data:'category.name'
                    },
                    {
                        data: 'price'
                    },
                    //  {
                    //     data: 'original_price'
                    // },

                ],

                order: [1, 'desc']
                @if (LaravelLocalization::getCurrentLocale() == 'ar')
                    ,
                    language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Arabic.json"
                    }
                @endif
            });
            // Add event listener for opening and closing details
            $('#cat tbody').on('click', 'td.dt-control', function() {
                var tr = $(this).closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
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
