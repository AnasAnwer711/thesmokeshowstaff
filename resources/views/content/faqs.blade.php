@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/faq-style.css')}}" media='all' />
<!-- <link rel='stylesheet' href="{{asset('css/home-testimonial-style.css')}}" media='all' /> -->

@section('content')

<div class="main mykit">


    <section id="one" class="section section-one banner banner-one ">
        <div class="row">
            <div class="section-content text-left">
                <h4 class="text-white">FAQ</h4>
            </div>
        </div>
    </section>
    <div id="two" class="section section-two green-panel">
        <div class="row">
            <div class="section-content text-left text-white">
                <h5 class="text-white">For clients</h5>
            </div>
        </div>
    </div>
    <div id="three" class="section section-three">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                    HOW MUCH IS IT TO HIRE STAFF THROUGH THE SMOKESHOW STAFF?
                                </button>
                            </h5>
                            <div id="collapseZero" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> THE SMOKESHOW STAFF CHARGES $20 FOR A SUCCESSFUL EVENT
                                        HIRE. THE FEE IS CHARGED AFTER THE POSITIONS REQUESTED ARE FILLED.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    HOW DO I PAY THE STAFF FOR MY PARTIES?
                                </button>
                            </h5>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> PAYMENT IS ORGANIZED BETWEEN YOU AND THE STAFF.
                                    </b>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    HOW DO I POST A JOB?
                                </button>
                            </h5>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> POSTING A JOB IS AS EASY AS FILLING OUT OUR POSITION
                                        DOCUMENT AND POSTING ON THE SMOKESHOW STAFF SITE.
                                    </b>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                    HOW DO I CONTACT STAFF?
                                </button>
                            </h5>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> AFTER POSTING YOUR JOB SEARCH THE AVAILABLE STAFF WILL
                                        ACCEPT THE POSITION AND YOU WILL RECEIVE A NOTIFICATION.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                    WHAT IF STAFF CANCEL AFTER ACCEPTING THE JOB?
                                </button>
                            </h5>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> STAFF CAN CANCEL UP TP 72 HOURS BEFORE THE EVENT GIVING
                                        OTHER STAFF TIME TO FILL THE POSITION. YOU WILL ONLY BE CHARGED WITH A
                                        SUCCESSFUL HIRE.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    WHAT IF I WANT TO CANCEL STAFF?
                                </button>
                            </h5>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> YOU HAVE UP TO 48 HOURS BEFORE THE EVENT TO CANCEL STAFF
                                        OTHERWISE YOU WILL BE CHARGED ACCORDINGLY.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                    CAN I ONLY HIRE STAFF IN VANCOUVER?
                                </button>
                            </h5>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> WE WILL HAVE STAFF AVAILABLE AT VARIOUS LOCATIONS AROUND
                                        BC.
                                    </b>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="four" class="section section-two green-panel">
        <div class="row">
            <div class="section-content text-left text-white">
                <h5 class="text-white">For staffs</h5>
            </div>
        </div>
    </div>

    <div id="five" class="section section-five">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseZero" aria-expanded="true"
                                    aria-controls="s_collapseZero">
                                    HOW DO I RECEIVE PAYMENT FOR THE JOB I'M WORKING?
                                </button>
                            </h5>
                            <div id="s_collapseZero" class="accordion-collapse collapse show"
                                aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> YOU WILL RECEIVE PAYMENT UPON ARRIVAL AT THE JOB SITE. IT’S
                                        THE STAFFS RESPONSIBILITY TO COLLECT THEIR PAYMENTS.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseOne" aria-expanded="true" aria-controls="s_collapseOne">
                                    HOW DO I GET A JOB?
                                </button>
                            </h5>
                            <div id="s_collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> AFTER CREATING A BIO ON OUR SITE THE STAFF WILL HAVE ACCESS
                                        TO THE JOB BOARD AND CAN APPLY/ACCEPT ANY JOBS OF THEIR INTEREST.
                                    </b>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseTwo" aria-expanded="true" aria-controls="s_collapseTwo">
                                    HOW DO I SET UP A PROFILE?
                                </button>
                            </h5>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> YOU CAN SET UP A PROFILE BY FILLING OUT THE STAFF FORM
                                        THROUGH OUR “SIGN UP” OPTION.
                                    </b>
                                </div>
                            </div>
                        </div>


                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseThree" aria-expanded="true"
                                    aria-controls="s_collapseThree">
                                    WHAT SHOULD I WEAR?
                                </button>
                            </h5>
                            <div id="s_collapseThree" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default">DRESS CODES DEPEND ON THE JOB. ATTIRE WILL BE DISCUSSED
                                        BETWEEN THE STAFF AND HOST.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseFour" aria-expanded="true"
                                    aria-controls="s_collapseFour">
                                    HOW DO I CONTACT THE CLIENT?
                                </button>
                            </h5>
                            <div id="s_collapseFour" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> CONTACT BETWEEN STAFF AND THE CLIENT WILL ALL BE HELD
                                        THROUGH OUR MESSAGING SYSTEM ON THE WEBSITE.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseFive" aria-expanded="true"
                                    aria-controls="s_collapseFive">
                                    ONCE BOOKED, IF I CANNOT MAKE IT, HOW DO I CANCEL?
                                </button>
                            </h5>
                            <div id="s_collapseFive" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default"> CANCELLING YOUR SHIFT CAN BE DONE ON THE WEBSITE UNDER YOUR
                                        CURRENT JOB LISTINGS. YOU HAVE UP TO 72 HOURS BEFORE THE EVENT TO CANCEL
                                        OTHERWISE YOU WILL BE CHARGED ACCORDINGLY.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseSix" aria-expanded="true" aria-controls="s_collapseSix">
                                    WHAT IF THE CLIENT WANTS TO EXTEND THE BOOKING?
                                </button>
                            </h5>
                            <div id="s_collapseSix" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default">THE CLIENT CAN EXTEND THE BOOKING AS THEY PLEASE BUT ANY
                                        EXTENDED HOURS ARE TO BE ORGANIZED BETWEEN YOU AND THE CLIENT.
                                    </b>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h5 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#s_collapseSeven" aria-expanded="true"
                                    aria-controls="s_collapseSeven">
                                    WHAT IF I’VE ARRIVED AT A JOB AND DON’T FEEL COMFORTABLE?
                                </button>
                            </h5>
                            <div id="s_collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <b class="text-default">IF YOU EVER DON’T FEEL COMFORTABLE AT AN EVENT IT IS YOUR
                                        RESPONSIBILITY TO INFORM THE HOST OF THE ISSUE AND IF YOU CANNOT FIX THE
                                        SITUATION YOU ARE FREE TO EXIT THE EVENT.
                                    </b>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
@endsection

@section('javascripts')


<script type="text/javascript">


</script>
@endsection