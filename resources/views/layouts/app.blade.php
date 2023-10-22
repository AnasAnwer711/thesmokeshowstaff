<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="showstaff">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    <link rel='stylesheet' href="{{asset('css/styles.pure.css')}}" media='all' />
    <link rel='stylesheet' href="{{asset('css/select2.min.css')}}" media='all' />
    <link rel='stylesheet' href="{{asset('css/footer.css')}}" media='all' />
    <link rel="stylesheet" type="text/css" href="{{asset('css/icofont.min.css')}}">
    <link rel='stylesheet' type="text/css" href="{{asset('css/font-awesome/css/fontawesome.min52d5.css')}}"
        media='all' />
    <link rel='stylesheet' type="text/css" href="{{asset('css/font-awesome/css/solid.min52d5.css')}}" media='all' />
    <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" type="text/css">
    <!-- Image Cropper CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.css"
        integrity="sha512-5ZQRy5L3cl4XTtZvjaJRucHRPKaKebtkvCWR/gbYdKH67km1e18C1huhdAc0wSnyMwZLiO7nEa534naJrH6R/Q=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Image Cropper CSS -->
    <title>Show Staff</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="icon" href="{{asset('images/favicon-showstaff-rounded-sm.png')}}" sizes="32x32" />
    <link rel="icon" href="{{asset('images/cropped-Logo_SmokeShowStaff-192x192.png')}}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{asset('images/cropped-Logo_SmokeShowStaff-180x180.png')}}" />

    <link rel="stylesheet" href="{{asset('css/intlTelInput.css')}}">

    <style>
    [ng\:cloak],
    [ng-cloak],
    [data-ng-cloak],
    [x-ng-cloak],
    .ng-cloak,
    .x-ng-cloak {
        display: none !important;
    }

    .bootbox-close-button {
        background: #cb0074;
        border-radius: 15px;
    }

    .loading {
        border: 1px solid #ddd;
        padding: 20px;
        margin: 40px 5px;
        width: 80px;
    }
    </style>

</head>


<body ng-controller="baseCtrl"
    class="page-template-default page page-id-360 theme-astra woocommerce-no-js ast-single-post ast-inherit-site-logo-transparent ast-hfb-header ast-desktop ast-page-builder-template ast-no-sidebar astra-3.7.5 elementor-default elementor-template-full-width elementor-kit-6 elementor-page elementor-page-360">
    <div id="baseScope" style="display:none"></div>
    <div class="hfeed site" id="page">
        {{-- <loading></loading> --}}

        <div class="loading-spiner-holder" data-loading>
            <div class="loader">
                <div class="iner-div">
                    <img src="{{asset('images/loader.gif')}}">
                </div>
            </div>
        </div>

        @include('layouts.header')
        @yield('content')
        @include('layouts.footer')

    </div>
    <!-- #page -->
    <!-- jQuery -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- toastr -->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <!-- select2 -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- moment -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <!-- Axios -->
    <script src="{{ asset('js/axios.min.js') }}"></script>

    <!-- bootbox code -->
    <script src="{{ asset('js/bootbox.min.js') }}"></script>
    <script src="{{ asset('js/bootbox.locales.min.js') }}"></script>
    <!-- /Place all Scripts Here -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular-animate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular-route.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-filter/0.5.8/angular-filter.min.js"></script>

    <!-- AngularJS Application Scripts -->

    <!-- Image Cropper Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.js"
        integrity="sha512-witv14AEvG3RlvqCAtVxAqply8BjTpbWaWheEZqOohL5pxLq3AtIwrihgz7SsxihwAZkhUixj171yQCZsUG8kw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Image Cropper Scripts -->

    <!-- GOOGLE MAP SCRIPTS -->
    <script
        src="https://maps.google.com/maps/api/js?key=AIzaSyCKU3ow8iRNEBhi1St_gMdG5Tn7_Vf3Wzo&libraries=places&callback=initAutocomplete"
        type="text/javascript"></script>
    {{-- <script src="{{asset('/js/address.js')}}"></script> --}}
    <!-- GOOGLE MAP SCRIPTS -->


    <script src="{{ asset('/app/app.js') }}"></script>

    <!-- Firebase -->
    <script type="module" src="{{ asset('/js/firebase/messages.js') }}"></script>

    @yield('javascripts')

    <script type="text/javascript">
    function ShowLoader() {
        $('.loader').css('display', 'block');
        // $.blockUI.defaults.baseZ = 4000;
        // $.blockUI({
        //     message: '<i class="icon-spinner2 spinner" style="font-size: xxx-large;"></i>',
        //     overlayCSS: {
        //         backgroundColor: 'white',
        //         opacity: 0.8,
        //         cursor: 'wait'
        //     },
        //     css: {
        //         border: 0,
        //         color: 'black',
        //         padding: 0,
        //         backgroundColor: 'transparent'
        //     }
        // });
        // document.getElementById("hideAll").style.display = "block";

    }

    function HideLoader() {
        //setTimeout(() => {
        $.unblockUI();
        //}, 500);

    }
    var block = "";
    $(document).mouseup(function(e) {
        var container = $(".notification-ui_dd");

        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });
    </script>



</body>

</html>