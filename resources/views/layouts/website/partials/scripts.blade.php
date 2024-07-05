<!--<script src="{{ asset('assets/js_site/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('assets/js_site/popper.min.js') }}"></script>
<script src="{{ asset('assets/js_site/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('assets/js_site/owl.carousel.min.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('assets/js_site/aos.js') }}"></script>
<script src="{{ asset('assets/js_site/jquery.animateNumber.min.js') }}"></script>
<script src="{{ asset('assets/js_site/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('assets/js_site/scrollax.min.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVWaKrjvy3MaE7SQ74_uJiULgl1JY0H2s&sensor=false"></script>
<script src="{{ asset('assets/js_site/google-map.js') }}"></script>
<script src="{{ asset('assets/js_site/main.js') }}"></script>-->
<!-- sweet alert -->
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>

<script>
    @php
        if (Auth::id() != null) {
            $user_id_Cookie = Auth::id();
        } else {
            if (Cookie::get('user_id') == null) {
                $user_id_Cookie = 0;
            } else {
                $user_id_Cookie = Cookie::get('user_id');
            }
        }
        
    @endphp
    if ({{ $user_id_Cookie }} != null) {
        $.get('{{ route('view.cart.website') }}', {
            user_id: {{ $user_id_Cookie }}
        }, function(data) {

            var div_con = "";
            if (data.length != 0) {
                $('#product_count_id').html(data.length);

            } else {

            }

        }, 'json');
    }
    $.get('<?= route('website.categoriers_menue') ?>', function(data1) {
        var sub1 = '<a class="dropdown-item" href="{{ route('website.shop') }}">All</a>';
        for (var i1 = 0; i1 < data1.length; i1++) {

            sub1 += '<a class="dropdown-item" href="/shop/' + data1[i1].categories_id + '">' + data1[i1]
                .categories_name + '</a>';

        }

        $('#shop_id').html(sub1);


    }, 'json');

    //--------------------------------------------slider image animation------------------------------------------------------------
    const images = document.querySelectorAll(".slide");

    const removeOverlay = overlay => {
        let tl = gsap.timeline();

        tl.to(overlay, {
            duration: 1.6,
            ease: "Power2.easeInOut",
            width: "0%"
        });

        return tl;
    };

    const scaleInImage = image => {
        let tl = gsap.timeline();

        tl.from(image, {
            duration: 1.6,

            ease: "Power2.easeInOut"
        });

        return tl;
    };

    images.forEach(image => {

        gsap.set(image, {
            visibility: "visible"
        });

        const overlay = image.querySelector('.img-overlay');
        const img = image.querySelector("img");

        const masterTL = gsap.timeline({
            paused: true
        });
        masterTL
            .add(removeOverlay(overlay))
            .add(scaleInImage(img), "-=1.6");


        let options = {
            threshold: 0
        }

        const io = new IntersectionObserver((entries, options) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    masterTL.play();
                } else {
                    masterTL.progress(0).pause()
                }
            });
        }, options);

        io.observe(image);
    });






    // -------------------------------header carousel--------------------------------------
    $(document).ready(() => {
        'use strict';

        var owl = $('#owl_header'),
            item,
            itemsBgArray = [], // to store items background-image
            itemBGImg;

        owl.owlCarousel({
            items: 1,
            smartSpeed: 1000,
            autoplay: true,
            autoplayTimeout: 8000,
            autoplaySpeed: 1000,
            loop: true,
            nav: true,
            navText: false,
            onTranslated: function() {
                changeNavsThump();
            }
        });

        $('.active').addClass('anim');

        var owlItem = $('.owl-item'),
            owlLen = owlItem.length;
        /* --------------------------------
          * store items bg images into array
        --------------------------------- */
        $.each(owlItem, function(i, e) {
            itemBGImg = $(e).find('.owl-item-bg').attr('src');
            itemsBgArray.push(itemBGImg);
        });
        /* --------------------------------------------
          * nav control thump
          * nav control icon
        --------------------------------------------- */
        var owlNav = $('.owl-nav'),
            el;

        $.each(owlNav.children(), function(i, e) {
            el = $(e);
            // append navs thump/icon with control pattern(owl-prev/owl-next)
            el.append('<div class="' + el.attr('class').match(/owl-\w{4}/) + '-thump">');
            el.append('<div class="' + el.attr('class').match(/owl-\w{4}/) + '-icon">');
        });

        /*-------------------------------------------
          Change control thump on each translate end
        ------------------------------------------- */
        function changeNavsThump() {
            var activeItemIndex = parseInt($('.owl-item.active').index()),
                // if active item is first item then set last item bg-image in .owl-prev-thump
                // else set previous item bg-image
                prevItemIndex = activeItemIndex != 0 ? activeItemIndex - 1 : owlLen - 1,
                // if active item is last item then set first item bg-image in .owl-next-thump
                // else set next item bg-image
                nextItemIndex = activeItemIndex != owlLen - 1 ? activeItemIndex + 1 : 0;

            $('.owl-prev-thump').css({
                backgroundImage: 'url(' + itemsBgArray[prevItemIndex] + ')'
            });

            $('.owl-next-thump').css({
                backgroundImage: 'url(' + itemsBgArray[nextItemIndex] + ')'
            });
        }
        changeNavsThump();
    });

    function star_fun() {
        var star = "";
        var starr = document.getElementById('swal-input2').value;
        if (starr == 1) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
        }
        if (starr == 2) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
        }
        if (starr == 3) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
        }
        if (starr == 4) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i>';
        }
        if (starr == 5) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i>';
        }
        $('#stars_id').html(star);
    }

    function rating_fun(rate, product_id) {
        var id = product_id;
        var star = ""
        var htmlcode = '<form id="rate-form" method="post"  >' +
            '<input name="_token" type="hidden" value="{{ csrf_token() }}"/>' +
            '<div class="row" style="width: 100%;">' +
            ' <div class="rate1" id="stars_id"></div>' +
            '<div class="col-4"><lable>Your name</lable></div><div class="col-8"><input id="swal-input1" class="swal2-input" name="name" required ></div>' +
            '<span class="error-text name_error" ></span>' +
            '<div class="col-4"><lable>Your rating</lable></div><div class="col-8"><select required  id="swal-input2" class="swal2-input" onchange="star_fun()" name="rate"></div>';
        if (rate == 1) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
            htmlcode +=
                '<option value="1" selected>1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
        }
        if (rate == 2) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
            htmlcode +=
                '<option value="1">1</option><option value="2" selected>2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option>';
        }
        if (rate == 3) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i><i class="fa  fa-star hide_element "></i>';
            htmlcode +=
                '<option value="1">1</option><option value="2" >2</option><option value="3" selected>3</option><option value="4">4</option><option value="5">5</option>';
        }
        if (rate == 4) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element "></i>';
            htmlcode +=
                '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4" selected>4</option><option value="5">5</option>';
        }
        if (rate == 5) {
            star +=
                '<i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i><i class="fa  fa-star hide_element fill_star"></i>';
            htmlcode +=
                '<option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5" selected>5</option>';
        }
        htmlcode += '</select></div>' +
            '<div class="col-4"><lable>Your review</lable></div><div class="col-8"><textarea required id="swal-input3" class="swal2-textarea" name="review" ></textarea></div>' +
            '</div>     </form>';

        (async () => {

            await Swal.fire({
                title: 'Rating & Reviews',
                html: htmlcode,
                focusConfirm: false,

                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('swal-input3').value
                    ]

                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var name = document.getElementById('swal-input1').value;
                    var rate = document.getElementById('swal-input2').value;
                    var review = document.getElementById('swal-input3').value;


                    $.post('<?= route('rating') ?>', {
                        name: name,
                        rate: rate,
                        review: review,
                        id: id,
                        _token: "{{ csrf_token() }}"
                    }, function(data) {


                        if (data.code == 0) {


                            toastr.warning(data.error);
                        } else {
                            // console.log(data)
                            toastr.success(data.msg);
                            location.reload();

                        }
                    }, 'json');
                    /*  Swal.fire(
                       'Thank you!',
                       '<p style="    text-align: center !important;font-size: 14px !important;">we appreciate your rating</p>',
                       'success'
                     )*/
                    // For more information about handling dismissals please visit
                    // https://sweetalert2.github.io/#handling-dismissals
                }
            })
            /*
            if (formValues) {
              //Swal.fire(JSON.stringify(formValues))
             $('#rate-form').submit();
             
            }*/

        })()
        $('#stars_id').html(star);
    }
</script>-->
<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>


<!-- Template Javascript -->
<script src="{{ URL::asset('js/script.js') }}"></script>    
@yield('additional_scripts')
