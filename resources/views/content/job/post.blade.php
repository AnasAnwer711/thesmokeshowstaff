@extends('content.menu.index')
@section('main-css')
<style>
.required {
    color: red;
}
</style>
@endsection
@section('main-body')
@if(isset($job) && $job->id)
<div class="col-md-8 col-lg-9 border-right" id="jobCtrl" ng-controller='jobCtrl' ng-init="init();getJob({{ $job->id }})"
    ng-cloak class="ng-cloak">
    @else
    <div class="col-md-8 col-lg-9 border-right" id="jobCtrl" ng-controller='jobCtrl' ng-init="init();" ng-cloak
        class="ng-cloak">
        @endif
        <div class="p-3 py-5">
            <!--wizard start-->
            <div class="row justify-content-center">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Post Your Job</h4>
                    <button class="btn btn-sm align-self-end d-none"><i
                            class="icofont-arrow-left me-2"></i>Back</button>
                </div>
                <div class="card px-0 pb-0 mb-3">
                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li class="active" id="account"><i class="fa fa-bars"></i><strong>Create Event</strong>
                            </li>
                            <li id="personal"><i class="fa fa-list"></i><strong>Event Detail</strong></li>
                            <li id="payment"><i class="fa fa-dollar-sign"></i><strong>Payment</strong></li>
                            <li id="confirm"><i class="fa fa-check"></i><strong>Finish</strong></li>
                        </ul>
                        <fieldset class="text-end initial">
                            <div class="form-card mb-3">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input type="text" ng-model="jobForm.title" data-val="jobForm.title"
                                                class="form-control" required="">
                                            <label class="form-label" style="margin-left: 0px;">Event Name</label>
                                            <div class="field-message-title" style="display: none">
                                                <small class="required"><i>Event Name is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.staff_category_id"
                                                ng-change="getJobTitle(jobForm.staff_category_id);">
                                                <option ng-repeat="sc in staff_categories" ng-value="sc.id">[[sc.title]]
                                                </option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Staff Category</label>
                                            <div class="field-message-staff_category_id" style="display: none">
                                                <small class="required"><i>Staff Category is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input type="date" ng-model="jobForm.date" id="datefield" class="form-control" value=""
                                                required="">
                                            <label class="form-label" style="margin-left: 0px;">Job Date</label>
                                            <div class="field-message-date" style="display: none">
                                                <small class="required"><i>Job Date is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.gender">
                                                <option value="both">Don't Care</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Looking For</label>
                                            <div class="field-message-gender" style="display: none">
                                                <small class="required"><i>Gender is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <textarea ng-model="jobForm.description" class="form-control"
                                                rows="4"></textarea>
                                            <label class="form-label" style="margin-left: 0px;">Job Description</label>
                                            <div class="field-message-description" style="display: none">
                                                <small class="required"><i>Description is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn next">Next</button>

                        </fieldset>
                        <fieldset class="text-end detail">
                            <div class="form-card  mb-3">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input type="text" class="form-control" id="autocomplete"
                                                ng-model="jobForm.location" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Location <span
                                                    class="small">(Dolphin Hotel or Private Home)</span></label>
                                            <div class="field-message-location" style="display: none">
                                                <small class="required"><i>Location is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[jobForm.address.suburb ? 'hasvalue' : '']]">
                                            <input type="text" ng-model="jobForm.address.address_line1"
                                                id="address_line1" class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Address 1</label>
                                            <div class="field-message-address_line1" style="display: none">
                                                <small class="required"><i>Address Line 1 is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input type="text" ng-model="jobForm.address.address_line2"
                                                id="address_line2" class="form-control" value="">
                                            <label class="form-label" style="margin-left: 0px;">Address 2</label>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[jobForm.address.suburb ? 'hasvalue' : '']]">
                                            <input type="text" ng-model="jobForm.address.suburb" id="suburb"
                                                class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Suburb</label>
                                            <div class="field-message-suburb" style="display: none">
                                                <small class="required"><i>Suburb is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[jobForm.address.state_id ? 'hasvalue' : '']]">
                                            {{-- <input type="text" ng-model="jobForm.address.state_id" id="state" class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Region</label> --}}
                                            <select class="form-control" ng-model="profileModel.address.state_id">
                                                <option value="">Region</option>
                                                <option ng-repeat="state in states"
                                                    ng-selected="state.id == selectedStateId" ng-value="state.id">
                                                    [[state.name]] </option>
                                            </select>
                                            <div class="field-message-state" style="display: none">
                                                <small class="required"><i>Region is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[jobForm.address.postal_code ? 'hasvalue' : '']]">
                                            <input type="text" ng-model="jobForm.address.postal_code" id="postal_code"
                                                class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Post Code</label>
                                            <div class="field-message-postal_code" style="display: none">
                                                <small class="required"><i>Post Code is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" ng-model="jobForm.address.latitude" id="latitude"
                                        class="form-control" value="" required="">
                                    <input type="hidden" ng-model="jobForm.address.longitude" id="longitude"
                                        class="form-control" value="" required="">
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input ng-model="jobForm.start_time" type="time" ng-change="setEndTime()"
                                                class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Start Time</label>
                                            <div class="field-message-start_time" style="display: none">
                                                <small class="required"><i>Start Time is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">

                                            <select class="form-control" ng-model="jobForm.duration"
                                                ng-change="setEndTime()">
                                                <option ng-value="2">2 Hours</option>
                                                <option ng-value="3">3 Hours</option>
                                                <option ng-value="4">4 Hours</option>
                                                <option ng-value="5">5 Hours</option>
                                                <option ng-value="6">6 Hours</option>
                                                <option ng-value="7">7 Hours</option>
                                                <option ng-value="8">8 Hours</option>
                                                <option ng-value="9">9 Hours</option>
                                                <option ng-value="10">10 Hours</option>
                                                <option ng-value="11">11 Hours</option>
                                                <option ng-value="12">12 Hours</option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Duration</label>
                                            <div class="field-message-duration" style="display: none">
                                                <small class="required"><i>Duration is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline hasvalue">
                                            <input ng-model="jobForm.end_time" readonly type="time" class="form-control"
                                                value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">End Time</label>
                                            <div class="field-message-end_time" style="display: none">
                                                <small class="required"><i>End Time is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input ng-model="jobForm.dress_code" type="text" class="form-control"
                                                value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Dress Code</label>
                                            <div class="field-message-dress_code" style="display: none">
                                                <small class="required"><i>Dress Code is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.job_title"
                                                ng-change="setMinRate(jobForm.job_title)">
                                                <option ng-repeat="job_title in job_titles" ng-value="job_title.title">
                                                    [[job_title.title]]</option>
                                                {{-- <option value="Party Host" selected>Party Host</option>
                                                <option value="Bikini Waitress">Bikini Waitress</option>
                                                <option value="Lingerie Waitress">Lingerie Waitress</option>
                                                <option value="Model">Model</option> --}}
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Job Title</label>
                                            <div class="field-message-job_title" style="display: none">
                                                <small class="required"><i>Job Title is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn Previous me-1">Previous</button>
                            <button type="button" class="btn next">Next</button>
                            <!-- <input type="button" name="next" class="next action-button" value="Next" /> <input
                                type="button" name="previous" class="previous action-button-previous"
                                value="Previous" /> -->
                        </fieldset>
                        <fieldset class="text-end payment">
                            <div class="form-card mb-3">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <input ng-model="jobForm.pay_rate" numbers-only maxlength="3" type="text"
                                                class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Pay ($)</span></label>
                                            <div class="field-message-pay_rate" style="display: none">
                                                <small class="required"><i>Pay Rate is required </i></small>
                                            </div>
                                            <div class="field-message-min_rate" style="display: none">
                                                <small class="required"><i>Min Pay Rate per hour is [[jobForm.min_rate]]
                                                    </i></small>
                                            </div>
                                            <div class="field-message-min_rate_with_type" style="display: none">
                                                <small class="required"><i>Min Pay Rate per party is [[jobForm.min_rate
                                                        * jobForm.duration]] </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.pay_type">
                                                <option value="per_hour">Per Hour</option>
                                                <option value="per_party">Per Party</option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Pay</label>
                                            <div class="field-message-pay_type" style="display: none">
                                                <small class="required"><i>Pay Type is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 d-none">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.travel_allowance_id">
                                                <option ng-repeat="ta in travel_allowances" ng-value="ta.id">
                                                    [[ta.title]]</option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Travel Allowance
                                                ($)</label>
                                            <div class="field-message-travel_allowance_id" style="display: none">
                                                <small class="required"><i>Travel Allowance is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-outline [[edit ? 'hasvalue': '']]">
                                            <select class="form-control" ng-model="jobForm.no_of_positions">
                                                <option ng-value="1">1</option>
                                                <option ng-value="2">2</option>
                                                <option ng-value="3">3</option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px;">Positions</label>
                                            <div class="field-message-no_of_positions" style="display: none">
                                                <small class="required"><i>Positions is required </i></small>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group col-md-6">
                                        <div class="form-outline">
                                            <input ng-model="jobForm.no_of_postions" type="text" class="form-control" value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">Promo Code</label>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <button type="button" class="btn Previous me-1">Previous</button>
                            <button type="button" class="btn next ">Next</button>
                            <!-- <input type="button" name="next" class="next action-button" value="Submit" />
                            <input type="button" name="previous" class="previous action-button-previous"
                                value="Previous" /> -->
                        </fieldset>
                        <fieldset class="text-end final">
                            <div class="form-card  mb-3">
                                <h2 class="purple-text text-center"><strong>SUCCESS !</strong></h2> <br>
                                <div class="row justify-content-center">
                                    <div class="col-3"> <img src="https://i.imgur.com/GwStPmg.png" class="fit-image">
                                    </div>
                                </div> <br><br>
                                <div class="row justify-content-center">
                                    <div class="col-7 text-center">
                                        <h5 class="purple-text text-center">You Have Successfully
                                            [[edit?'Updated':'Posted']] a Job</h5>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!--wizard end-->
        </div>
    </div>
    @endsection
    @section('js-controller')
    <script src="{{ ('/app/job-controller.js') }}"></script>
    <script src="{{asset('/js/job-address.js')}}"></script>
    <script>
        // Use Javascript
        var today = new Date();
        var dd = today.getDate()+1;
        var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
        var yyyy = today.getFullYear();
        if(dd<10){
        dd='0'+dd
        } 
        if(mm<10){
        mm='0'+mm
        } 

        today = yyyy+'-'+mm+'-'+dd;
        console.log(today);
        document.getElementById("datefield").setAttribute("min", today);
    </script>
    @endsection