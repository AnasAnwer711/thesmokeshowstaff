@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/home-style.css')}}" media='all' />
<!-- <link rel='stylesheet' href="{{asset('css/home-testimonial-style.css')}}" media='all' /> -->

@section('content')

<div class="main mykit">
    <section class="section section-one video-section">
        <video width="100%" loop="true" autoplay="autoplay" muted>
            <source src="{{asset('images/TheSmokeShow-Video-5.mp4')}}" type=" video/mp4">
        </video>

    </section>

    <section id="one" class="section section-two banner banner-one bg-light text-center">
        <div class="row mx-sm-auto">
            <div class="section-content">
                <h3 class="heading-title">Bring your party experience to a new level</h2>
                    <div class="action-btn">
                        <button onclick="window.location.href='/find_staff'"
                            class="text-uppercase theme-pink-fill-btn">Pick your staff</button>
                    </div>
            </div>
        </div>
    </section>

    <section id="two" class="section section-three banner banner-two text-center">
        <div class="row mx-sm-auto">
            <div class="section-content">
                <h4 class="text-white">Our well-equipped and highly experienced staff are the go-to choices to make sure
                    each party is an event
                    to remember.</h4>
                <h4 class="text-white">The Smokeshow staff always provide the right amount of heat whether you need a
                    bikini, lingerie or
                    topless waitresses to suit your event.</h4>
            </div>
        </div>
    </section>

    <section id="three" class="50-grid section section-four">
        <div class="row mx-sm-auto">
            <div class="col-left col-md-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
            <div class="col-right col-md-6 p-0 content-col">
                <div class="col-content">
                    <h4 class="heading-title">Our staff turns any party into a smoke show.</h4>
                    <p class="para">We know how important it is to bring the heat when hosting a party – our staff will
                        leave you
                        with an unforgettable experience.</p>
                    <p class="para">Pick your staff, reduce stress and keep the party rolling – all from the click of a
                        button.</p>
                </div>

            </div>
        </div>
    </section>

    <section id="four" class="section section-five">
        <div class="row mx-sm-auto">
            <div class="col-left col-md-6 p-0 content-col">
                <div class="col-content">
                    <h4 class="heading-title text-white">How it works?</h4>
                    <ul class="text-white">
                        <li><span class="count-circle">1</span>Submit the form</li>
                        <li><span class="count-circle">2</span>Get hand-picked applications (party or staff) </li>
                        <li><span class="count-circle">3</span>Choose the best match</li>
                        <li><span class="count-circle">4</span>Proceed with payment</li>
                        <li><span class="count-circle">5</span>Meet your staff at the venue</li>
                    </ul>
                    <strong class="text-white d-block">
                        Ready to join? Give it a shot!
                    </strong>
                    <button onclick="window.location.href='/howitworks'"
                        class="text-uppercase white-fill-btn mt-5">Start here</button>
                </div>
            </div>
            <div class="col-right col-md-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
        </div>
    </section>

    <section id="five" class="section section-six banner banner-three bg-light text-center">
        <div class="row mx-sm-auto">
            <div class="section-content">
                <h3 class="heading-title">Fun, outgoing staff for any occasion!</h2>
            </div>
        </div>
    </section>

    <section id="six" class="section section-seven">
        <div class="row mx-sm-auto">
            <div class="col-left col-md-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
            <div class="col-right col-md-6 p-0 content-col">
                <div class="col-content">
                    <h4 class="heading-title text-white">Services we offer?</h4>
                    <ul class="text-white">
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Topless waitresses</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Lingerie waitresses</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Bikini waitresses</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Poker dealers</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Hosts</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Promotional staff</li>
                        <li><span class="ul-list-icon"><i class="fa fa-check"></i></span>Entertainers </li>

                    </ul>
                    <strong class="text-white d-block">
                        We supply the staff so you can focus on partying.
                    </strong>
                    <button onclick="window.location.href='/find_staff'" class="text-uppercase white-fill-btn mt-5">Find
                        Staff</button>
                </div>
            </div>

        </div>
    </section>

    <section id="seven" class="section section-eight banner banner-four bg-light text-center">
        <div class="row mx-sm-auto">
            <div class="section-content">
                <h3 class="heading-title">Why not work hard and have fun?</h3>
                <h5 class="heading-title">Reimagine the way you work <br />We help you earn while you enjoy
                    parting</h5>
                <div class="action-btn">
                    <button onclick="window.location.href='/find_staff'" class="text-uppercase white-fill-btn mt-5">Find
                        party</button>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('javascripts')
<script src="{{ ('app/auth-controller.js') }}"></script>

<script type="text/javascript">
let params = new URLSearchParams(window.location.search);

if (params.get('logout') == 1) {
    window.localStorage.removeItem('auth_user');
}
</script>
@endsection