@extends('content.menu.index')
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='profileDashboardCtrl' ng-init="init()"
    id="profileDashboardCtrl" ng-cloak class="ng-cloak">

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePassword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="changePasswordLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordLabel">Change Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="password" class="form-control" ng-model="passwordModel.password" required="">
                        <label class="form-label" style="margin-left: 0px;"><span class="text-danger">*</span>
                            Password</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" class="form-control" ng-model="passwordModel.password_confirmation"
                            required="">
                        <label class="form-label" style="margin-left: 0px;"><span class="text-danger">*</span> Confirm
                            Password</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="changePassword()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Modal -->
    <div class="modal fade" id="verification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="verificationLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationLabel">Verify Your Number</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class=" input-group mb-3">

                        <input aria-invalid="true" type="text"
                            ng-model="verification.verify_code"
                            class="form-control"
                            {{-- ng-disabled="is_verified"  --}}
                            placeholder="Verification Code"
                            ng-change="verifyCode()"
                            aria-describedby="button-addon3" >
                        <button type="button" ng-disabled="!can_send_code" ng-click="sendOtp();" id="button-addon3" class="btn btn-sm">[[is_verified ? 'Verified' : (can_send_code ? 'Send Otp' : 'Resend in '+ countDown +'s')]]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div id="change-pwd" class="modal-window">
        <div>
            <a href="#" title="Close" class="modal-close">Close</a>

            <h1>CHANGE PASSWORD</h1>
            <div class="form-outline">
                <input type="password" class="form-control" ng-model="passwordModel.password" required="">
                <label class="form-label" style="margin-left: 0px;">Password</label>
            </div>
            <div class="form-outline">
                <input type="password" class="form-control" ng-model="passwordModel.password_confirmation" required="">
                <label class="form-label" style="margin-left: 0px;">Confirm Password</label>
            </div>
            <a class="btn w-100 rounded my-2" title="Close" href="javascript:void(0)" ng-click="changePassword()">CHANGE
                PASSWORD</a>
        </div>
    </div> -->
    <div class="p-3 py-5">
        <div class="main-body">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">My Profile</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="profile-pic-wrapper">
                                    <div class="pic-holder border">
                                        <!-- uploaded pic shown here -->
                                        {{-- <img id="profilePic" class="pic"
                                                src="https://source.unsplash.com/random/150x150"> --}}
                                        <img id="profilePic" class="pic"
                                            ng-src="[[user.display_pic ? user.display_pic  : '/images/Logo_SmokeShowStaff.png']]">

                                        <label for="newProfilePhoto" class="upload-file-block">
                                            <div class="text-center">
                                                <div class="mb-2">
                                                    <i class="fa fa-camera fa-2x"></i>
                                                </div>
                                                <div class="text-uppercase">
                                                    [[user.display_pic ? 'Update' : 'Upload']] <br> Profile Photo
                                                </div>
                                            </div>
                                        </label>
                                        <input class="uploadHostProfileInput"
                                            onchange="angular.element(this).scope().uploadHostProfileInput(this)"
                                            type="file" name="profile_pic" id="newProfilePhoto" accept="image/*"
                                            style="display: none;">
                                    </div>
                                </div>
                                <!-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150"> -->
                                <div class="">
                                    <h4 class="mb-1" ng-cloak class="ng-cloak"> [[user.first_name]] [[user.last_name]]
                                    </h4>
                                    <p class="text-secondary mb-1" ng-cloak class="ng-cloak"> [[user.email]]</p>
                                    <button type="button" class="btn" data-bs-toggle="modal"
                                        data-bs-target="#changePassword">Change Password</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card set-notification mt-3 d-none">
                        <div class="card-header">
                            <h6>NOTIFICATION SETTINGS</h6>
                        </div>
                        <ul class="list-group list-group-flush  d-none">
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Sms</h6>
                                <span class="">
                                    <div class="demo--content demo--place-center">
                                        <label class="form-control-760">
                                            <input type="checkbox" name="checkbox-checked-state">
                                        </label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Job</h6>
                                <span class="">
                                    <div class="demo--content demo--place-center">
                                        <label class="form-control-760">
                                            <input type="checkbox" name="checkbox-checked-state">
                                        </label>
                                    </div>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                <h6 class="mb-0">Chat Message</h6>
                                <span class="">
                                    <div class="demo--content demo--place-center">
                                        <label class="form-control-760">
                                            <input type="checkbox" name="checkbox-checked-state">
                                        </label>
                                    </div>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Full Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.first_name]] [[user.last_name]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-outline [[profileModel.first_name ? 'hasvalue': '']]">
                                                <input type="text" class="form-control"
                                                    ng-model="profileModel.first_name" value="" required="">
                                                <label class="form-label" style="margin-left: 0px;"><span
                                                        class="text-danger">*</span> First
                                                    Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline [[profileModel.last_name ? 'hasvalue': '']]">
                                                <input type="text" class="form-control"
                                                    ng-model="profileModel.last_name" value="" required="">
                                                <label class="form-label" style="margin-left: 0px;"><span
                                                        class="text-danger">*</span> Last
                                                    Name</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Country</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.nationality.name]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.nationality.name ? 'hasvalue': '']]">
                                        <input type="text" class="form-control" disabled
                                            ng-model="profileModel.nationality.name" value="">
                                        <label class="form-label" style="margin-left: 0px;"><small
                                                class="text-danger">*</small> Country</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">State</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.address.state.name]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.address.state_id ? 'hasvalue': '']]">

                                        <select class="form-control" ng-model="profileModel.address.state_id">
                                            <option value="">Region</option>
                                            <option ng-repeat="state in states"
                                                ng-selected="state.id == selectedStateId" ng-value="state.id">
                                                [[state.name]] </option>
                                        </select>
                                        <label class="form-label" style="margin-left: 0px;"><small
                                                class="text-danger">*</small> Region</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Suburb</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.address.suburb]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.address.suburb ? 'hasvalue': '']]">
                                        <input type="text" class="form-control" id="autocomplete"
                                            ng-model="profileModel.address.suburb" value="" required="">
                                        <input type="hidden" ng-model="profileModel.address.latitude" id="latitude"
                                            class="form-control" value="" required="">
                                        <input type="hidden" ng-model="profileModel.address.longitude" id="longitude"
                                            class="form-control" value="" required="">
                                        <label class="form-label" style="margin-left: 0px;"><span
                                                class="text-danger">*</span> Suburb</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Postcode </h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.address.postal_code]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.address.postal_code ? 'hasvalue': '']]">
                                        <input type="text" class="form-control"
                                            ng-model="profileModel.address.postal_code" value="" required="">
                                        <label class="form-label" style="margin-left: 0px;"><span
                                                class="text-danger">*</span> Postcode</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.phone]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.phone ? 'hasvalue': '']]">
                                        {{-- <input type="text" class="form-control" ng-model="profileModel.phone" value=""
                                                required="">
                                            <label class="form-label" style="margin-left: 0px;">Mobile</label> --}}
                                        <input type="hidden" value="{{ $phone_code }}"
                                            class="selected_country selected_country_host">
                                        <input aria-invalid="true" required type="tel" ng-model="profileModel.phone"
                                            id="phone_int_host" class="form-control phone_int">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3 field-title">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    [[user.email]]
                                </div>
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.email ? 'hasvalue': '']]">
                                        <input type="email" class="form-control" ng-model="profileModel.email" value=""
                                            required="">
                                        <label class="form-label" style="margin-left: 0px;"
                                            value="intel@gmail.com"><span class="text-danger">*</span> Email</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                {{-- <div class="col-sm-3 field-title">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        [[user.email]]
                                    </div> --}}
                                <div class="col-sm-12 edit-text-secondary" style="display:none;">
                                    <div class="form-outline [[profileModel.resume ? 'hasvalue': '']]">
                                        <textarea class="form-control" ng-model="profileModel.resume" rows="5"
                                            cols="50">[[profileModel.resume]]</textarea>

                                        <label class="form-label" style="margin-left: 0px;"><span
                                                class="text-danger">*</span> Resume</label>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn edit-profile editHostProfile" href="javascript:void(0)">Edit Profile
                                        Detail</a>
                                    <a class="btn save-profile" ng-click="toSaveProfile()" href="#"
                                        style="display:none;">Save
                                        Changes</a>
                                    <a class="btn cancel-profile" href="#" style="display:none;">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-body" ng-if="user.resume">
                <div class="card bio-info">
                    <div class="card-header px-5">
                        <h5>My Biography</h5>
                    </div>
                    <div class="card-body px-5">
                        <p>[[user.resume]]</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js-controller')
<script src="{{ ('/app/profile-dashboard-controller.js') }}"></script>
<script src="{{asset('/js/profile-address.js')}}"></script>
@endsection