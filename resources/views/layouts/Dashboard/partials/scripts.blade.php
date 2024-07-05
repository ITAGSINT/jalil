<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ asset('assets/js_d/stisla.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<!-- JS Libraies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"
    integrity="sha512-3PRVLmoBYuBDbCEojg5qdmd9UhkPiyoczSFYjnLhFb2KAFsWWEMlAPt0olX1Nv7zGhDfhGEVkXsu51a55nlYmw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"
    integrity="sha512-oaUGh3C8smdaT0kMeyQ7xS1UY60lko23ZRSnRljkh2cbB7GJHZjqe3novnhSNc+Qj21dwBE5dFBqhcUrFc9xIw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
    integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"
    integrity="sha512-ZESy0bnJYbtgTNGlAD+C2hIZCt4jKGF41T5jZnIXy4oP8CQqcrBGWyxNP16z70z/5Xy6TS/nUZ026WmvOcjNIQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chocolat/1.1.0/js/chocolat.min.js"
    integrity="sha512-f0RyyfsrXaAqNTCqDXt0A7GDr5YauTMYj42P7Y6DNNQ+KjU7cYZpxqLzqncnWMXPZy9h4XtpKPcvsQ/3C2PA1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js_d/scripts.js') }}"></script>
<script src="{{ asset('assets/js_d/custom.js') }}"></script>

<!-- Page Specific JS File -->
{{-- <script src="{{asset('assets/js_d/page/index.js')}}"></script> --}}
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>


<script>
    function get_notification() {


        $.get("{{ route('get_notification') }}", function(data) {

            $('#notification_id2').html(data[1]);
            // console.log(data);
            var st = '';
            for (var i1 = 0; i1 < data[0].length; i1++) {
                st += `<a href="`;
                if (data[0][i1].read_at == null)
                    st += `https://kit-platform.com/update_notifi?id=` + data[0][i1].id +
                    `" style="background: #04040417">`;
                else
                    st += data[0][i1].action + `" >`;


                // if(data[0][i1].is_read==0)
                // st+=``;

                //   st+=` >`;
                st += `   <div class=" px-3 border-top `
                if (data[0][i1].read_at == null) st += ` bg-light `;
                st += ` ">`;

                st += ` <p class=" m-0 text-title">`;

                p = JSON.parse(data[0][i1].data);
                // console.log(p);

                st += `` + p.title + `  </p>`;

                st += `  <p class="m-0 text-info">` + p.body + `</p>
                                        <small class=" text-time">` + data[0][i1].date1 + `</small>

                                        </div>
                                   </a>`;

            }
            $('#notif_center_id2').html(st);
        }, 'json');
    }

    // function get_messages() {


    //     $.get("{{ route('get_message') }}", function(data) {

    //         $('#notification_id').html(data.length);
    //         console.log(data);
    //         var st = '';
    //         for (var i1 = 0; i1 < data.length; i1++) {
    //             st += `<a href="#">
    //                                    <div class="notif-img">
    //                                        <img src="{{ asset('/assets/img/profile.png') }}" alt="Img Profile">
    //                                    </div>
    //                                    <div class="notif-content">
    //                                        <span class="subject"> ` + data[i1].user_name + `</span>
    //                                        <span class="block">

    //                                       ` + data[i1].message_text + `
    //                                        </span>
    //                                        <span class="time">
    //                                          ` + data[i1].date1 + `
    //                                           </span>

    //                                    </div>
    //                                </a>`;
    //         }
    //         $('#notif_center_id').html(st);
    //     }, 'json');
    // }
</script>



<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>

<script>
    // Import the functions you need from the SDKs you need


    const firebaseConfig = {
        apiKey: 'AIzaSyBEn2l0L2pS97sFfP4S3rIE0aQuRFKXLbE',
        appId: '1:635057540220:web:facf844e93dcd91d948df9',
        messagingSenderId: '635057540220',
        projectId: 'eatchen-b2f7e',
        authDomain: 'eatchen-b2f7e.firebaseapp.com',
        storageBucket: 'eatchen-b2f7e.appspot.com',
        measurementId: 'G-WRQ9RFXDHS',
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function() {

                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '{{ route('save-token') }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        // alert('Token saved successfully.');
                    },
                    error: function(err) {
                        console.log('User Chat Token Error' + err);
                    },
                });

            }).catch(function(err) {
                console.log('User Chat Token Error' + err);
            });
    }
    initFirebaseMessagingRegistration()
    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        var audio = new Audio("{{ asset('/assets/voice/sound.mp3') }}");
        audio.play();


        if (payload.notification.title == 'message')
            (get_messages());
        else
           {console.log(payload);

            (get_notification());}



    });
</script>


<!-- sweet alert -->
<script>


    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        animation: false,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });
</script>
@if (Session::has('status'))
    <script>
        $(document).ready(function() {

            toastMixin.fire({
                animation: true,
                title: "{{ session('status') }}"
            });
        });
    </script>
@endif

@if ($message = Session::get('success'))
    <script>
        $(document).ready(function() {

            toastMixin.fire({
                icon: 'success',
                animation: true,
                title: `{{ $message }}`
            });
        });
    </script>
@endif

@if ($message = Session::get('error'))
    <script>
        $(document).ready(function() {

            toastMixin.fire({
                icon: 'error',
                animation: true,
                title: `{{ $message }}`
            });
        });
    </script>
@endif

@yield('additional_scripts')
