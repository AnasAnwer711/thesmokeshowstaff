@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/contactus-style.css')}}" media='all' />
<!-- <link rel='stylesheet' href="{{asset('css/home-testimonial-style.css')}}" media='all' /> -->
<style>
    textarea.form-control {
  height: auto !important;
}
</style>
@section('content')

<div class="main mykit" ng-controller='contactusCtrl' ng-init="init();" ng-cloak class="ng-cloak">


    <section id="one" class="section section-one banner banner-one ">
        <div class="row">
            <div class="section-content text-left">
                <h4 class="text-white">Contact us</h4>
            </div>
        </div>
    </section>
    <div id="two" class="section section-two">
        <div class="row m-0">
            <div class="col-md-4 green-panel">
                <div class="section-content text-left text-white">
                    <strong class="d-block text-white mb-4" style="font-size:22px;">T <a class="text-white"
                            style="text-decoration:none" href="tel:7782513875"> 778-251-3875</a>
                    </strong>
                    <strong class="d-block text-white mb-4" style="font-size:22px;">E <a class="text-white"
                            style="text-decoration:none" href="mailto:info@thesmokeshowstaff.com">
                            info@thesmokeshowstaff.com</a></strong>

                </div>
            </div>
            <div class="col-md-8">
                @if (count($errors) > 0)
                <div class = "alert alert-danger">
                    <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                <div class="section-content form-section">
                    <form ng-submit="submitContactUs()">
                        <div class="form">

                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="label">Your Name <span class="text-danger">*</span></div>
                                        <input type="text" class="form-control" ng-model="contactUsModel.name">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="label">Your Email <span class="text-danger">*</span></div>
                                        <input type="text" class="form-control" ng-model="contactUsModel.email">
                                        <input type="hidden" ng-model="contactUsModel.subject">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="label">Message <span class="text-danger">*</span></div>
                                        <textarea style="height: 250px;" class="form-control" ng-model="contactUsModel.message" id="" rows="5" cols="50"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <button class="theme-pink-fill-btn ">Submit</button>
                                </div>
                            </div>



                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
    @endsection

    @section('javascripts')
    <script src="{{ ('/app/contactus-controller.js') }}"></script>


    <script type="text/javascript">


    </script>
    @endsection