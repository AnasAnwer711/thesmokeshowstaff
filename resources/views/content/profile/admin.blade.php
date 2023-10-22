@extends('content.menu.index')
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='profileDashboardCtrl' ng-init="init()"
    id="profileDashboardCtrl" ng-cloak class="ng-cloak">
    <div id="change-pwd" class="modal-window">
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
    </div>
    <div class="py-5">
        <div class="main-body">
            <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column align-items-center text-center">
                                <div class="profile-pic-wrapper">
                                    <div class="pic-holder">
                                        <!-- uploaded pic shown here -->
                                        {{-- <img id="profilePic" class="pic"
                                                src="https://source.unsplash.com/random/150x150"> --}}
                                        <img id="profilePic" class="pic"
                                            ng-src="[[user.display_pic ? user.display_pic  : 'https://source.unsplash.com/random/150x150']]">

                                        <label for="newProfilePhoto" class="upload-file-block">
                                            <div class="text-center">
                                                <div class="mb-2">
                                                    <i class="fa fa-camera fa-2x"></i>
                                                </div>
                                                <div class="text-uppercase">
                                                    Update <br> Profile Photo
                                                </div>
                                            </div>
                                        </label>
                                        <input class="uploadProfileInput"
                                            onchange="angular.element(this).scope().uploadProfileInput(this)"
                                            type="file" name="profile_pic" id="newProfilePhoto" accept="image/*"
                                            style="display: none;">
                                    </div>
                                </div>
                                <!-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" width="150"> -->
                                <div class="">
                                    <h4 class="mb-1" ng-cloak class="ng-cloak"> [[user.first_name]] [[user.last_name]]
                                    </h4>
                                    <p class="text-secondary mb-1" ng-cloak class="ng-cloak"> [[user.email]]</p>
                                    <a href="#change-pwd" class="btn">Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card set-notification mt-3">
                        <div class="card-header">
                            <h6>NOTIFICATION SETTINGS</h6>
                        </div>
                        <ul class="list-group list-group-flush">
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
                                                <label class="form-label" style="margin-left: 0px;">First
                                                    Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-outline [[profileModel.last_name ? 'hasvalue': '']]">
                                                <input type="text" class="form-control"
                                                    ng-model="profileModel.last_name" value="" required="">
                                                <label class="form-label" style="margin-left: 0px;">Last
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
                                        <label class="form-label" style="margin-left: 0px;">Country</label>
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
                                        {{-- <input type="text" class="form-control" ng-model="profileModel.address.state"
                                                value="" required="">
                                            <label class="form-label" style="margin-left: 0px;">State</label> --}}
                                        <select class="form-control" ng-model="profileModel.address.state_id">
                                            <option value="">Region</option>
                                            <option ng-repeat="state in states"
                                                ng-selected="state.id == selectedStateId" ng-value="state.id">
                                                [[state.name]] </option>
                                        </select>
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
                                        <label class="form-label" style="margin-left: 0px;">Suburb</label>
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
                                        <label class="form-label" style="margin-left: 0px;">Postcode</label>
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
                                        <input type="text" class="form-control" ng-model="profileModel.phone" value=""
                                            required="">
                                        <label class="form-label" style="margin-left: 0px;">Mobile</label>
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
                                            value="intel@gmail.com">Email</label>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <a class="btn edit-profile" href="javascript:void(0)">Edit Profile
                                        Detail</a>
                                    <a class="btn save-profile" ng-click="saveProfile()" href="#"
                                        style="display:none;">Save
                                        Changes</a>
                                    <a class="btn cancel-profile" href="#" style="display:none;">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-body">
                <div class="card bio-info">
                    <div class="card-header px-5">
                        <h5>My Biography</h5>
                    </div>
                    <div class="card-body px-5">
                        <p>I am an outgoing, bubbly enthusiastic person who loves to have fun but also work
                            hard! I have experience in Melbourne, London and New Zealand bartending,
                            dancing,
                            working in hospitality and have travelled through Europe doing the most
                            important
                            thing- partying! I know how to get the crowd in a good mood to have a great time
                            and
                            am a leader at keeping the vibes high which is a must in this line of work!</p>
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