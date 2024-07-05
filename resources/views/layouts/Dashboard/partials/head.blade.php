 <meta charset="UTF-8">
 <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
 <title>Ecommerce Dashboard</title>
 <meta name="csrf-token" content="{{ csrf_token() }}" />
 <!-- General CSS Files -->
 <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
     integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
 <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
     integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

 <!-- CSS Libraries -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqvmap/1.5.1/jqvmap.min.css"
     integrity="sha512-RPxGl20NcAUAq1+Tfj8VjurpvkZaep2DeCgOfQ6afXSEgcvrLE6XxDG2aacvwjdyheM/bkwaLVc7kk82+mafkQ=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css"
     integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css"
     integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css"
     integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.1/css/flag-icon.min.css"
     integrity="sha512-CuS4zs2ykPlBmzf9QRrYl8TPIBjgimlVuq7mwFOvNn+NcTlMPmfCj6+UCFuF74UAPwfNht9TXFiT0ib5ABzT/A=="
     crossorigin="anonymous" referrerpolicy="no-referrer" />

 <!-- sweet alert -->
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

 <!-- Template CSS -->

 <link rel="stylesheet" href="{{ asset('assets/css_d/style.css') }}">
 @if (LaravelLocalization::getCurrentLocale() == 'ar')
     <link rel="stylesheet" href="{{ asset('assets/css_d/rtl.css') }}">
 @endif

 <link rel="stylesheet" href="{{ asset('assets/css_d/components.css') }}">
 @yield('additional_styles')
