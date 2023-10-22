@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/howitworks-style.css')}}" media='all' />
<!-- <link rel='stylesheet' href="{{asset('css/home-testimonial-style.css')}}" media='all' /> -->

@section('content')

<div class="main mykit">


    <section id="one" class="section section-one banner banner-one ">
        <div class="row m-0">
            <div class="section-content text-left">
                <h4 class="text-white">We connect great staff with people who need them</h4>
            </div>
        </div>
    </section>

    <section id="two" class="section section-two banner banner-two bg-light text-center">
        <div class="row m-0">
            <div class="section-content">
                <h4 class="heading-title">We hand-pick events and professionals to ensure a perfect match so everyone is
                    happy!</h4>
            </div>
        </div>
    </section>
    <section id="three" class="section section-three">
        <div class="row m-0">
            <div class="col-left col-6 p-0 content-col">
                <div class="col-content">
                    <h4 class="heading-title text-white">Find a job.?</h4>
                    <ul class="text-white">
                        <li><span class="count-circle">1</span>
                            <span><b>Create a profile</b> <br />Ensure you have 5
                                photos and your cover is professional</span><br />

                        </li>
                        <li><span class="count-circle">2</span>
                            <span><b>Apply for jobs</b> <br />Tell us why you are a perfect match for particular
                                job!</span><br />

                        </li>
                        <li><span class="count-circle">3</span>
                            <span><b>Get a reply!</b> <br />If your application is accepted, you are booked for the job
                                and on your way to earning money!</span><br />

                        </li>

                    </ul>
                    <strong class="text-white d-block">
                        Ready to join? Give it a shot!
                    </strong>
                    <button onclick="window.location.href='/find_job'" class="text-uppercase white-fill-btn mt-5">Start
                        here</button>
                </div>
            </div>
            <div class="col-right col-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
        </div>
    </section>

    <!-- <section id="three" class="section section-three banner banner-three text-center">
        <div class="row">
            <div class="section-content">
                <h4 class="text-white">Our well-equipped and highly experienced staff are the go-to choices to make sure
                    each party is an event
                    to remember.</h4>
                <h4 class="text-white">The Smokeshow staff always provide the right amount of heat whether you need a
                    bikini, lingerie or
                    topless waitresses to suit your event.</h4>
            </div>
        </div>
    </section> -->

    <!-- <section id="four" class="50-grid section section-four">
        <div class="row">
            <div class="col-left col-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
            <div class="col-right col-6 p-0 content-col">
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
    </section> -->

    <section id="five" class="section section-five">
        <div class="row m-0">

            <div class="col-right col-6 p-0 img-col">
                <div class="bg-img"></div>
            </div>
            <div class="col-left col-6 p-0 content-col">
                <div class="col-content">
                    <h4 class="heading-title ">Find Staff?</h4>
                    <ul class="">
                        <li><span class="count-circle">1</span>Fill out the request form.</li>
                        <li><span class="count-circle">2</span>Get a list of applicants. </li>
                        <li><span class="count-circle">3</span>Choose the best candidates and accept applications.</li>
                        <li><span class="count-circle">4</span>Receive your proposal and proceed with payment.</li>
                        <li><span class="count-circle">5</span>Your contact details are shared with the staff before the
                            job starts.</li>
                    </ul>
                    <button onclick="window.location.href='/find_staff'"
                        class="text-uppercase theme-pink-fill-btn mt-5">Start
                        Now</button>
                </div>
            </div>
        </div>
    </section>



    <section id="six" class="section section-six banner banner-six bg-light">
        <div class="row m-0">
            <div class="section-content col-10">
                <h5 class="heading-title text-white">WHAT MAKES US DIFFERENT</h5>
                <b class="text-white">OUR FUN, UPBEAT STAFF ALL HAVE WHAT IT TAKES TO NOT ONLY KEEP THE PARTY ROLLIN BUT
                    ENSURE YOUR GUESTS ARE ALWAYS TAKEN CARE OF</b>
            </div>

            <div class="section-content col-10">
                <h5 class="heading-title text-white">WHY YOU NEED OUR STAFF</h5>
                <b class="text-white">HAVING STAFF FOR YOUR PARTY ENSURES IT WILL RUN SMOOTHLY AND MINIMIZE YOUR STRESS
                    SO YOU CAN FOCUS ON ENJOYING YOUR PARTY</b>
            </div>
        </div>
    </section>

    <section id="seven" class="section section-seven banner banner-seven bg-light text-center">
        <div class="row m-0">
            <div class="section-content">
                <h4 class="heading-title">OUR STAFF ENSURES YOU’LL NEVER HAVE TO WORRY ABOUT AN EMPTY DRINK, ENPTY PLATE
                    OR AN EMPTY VIBE</h4>
            </div>
        </div>
    </section>


</div>
@endsection

@section('javascripts')


<script type="text/javascript">


</script>
@endsection