<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.website.partials.head')

</head>

<body class="goto-here">
    <!-- Start Top Nav -->



    @include('layouts.website.partials.header')


    @yield('content')




    @include('layouts.website.partials.footer')





    @include('layouts.website.partials.scripts')

    <!-- End Script -->
</body>

</html>
