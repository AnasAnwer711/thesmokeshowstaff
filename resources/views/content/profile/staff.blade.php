@extends('content.menu.index')
@section('main-css')
<style>
/* Ensure the size of the image fit the container perfectly */
img {
    display: block;
    /* This rule is very important, please don't ignore this */
    max-width: 100%;
}

.select2-container--default.select2-container--focus .select2-selection--multiple {
    border: solid #cb0074 1px !important;
}

select+.select2-container {
    width: 100% !important;
}

/* .select2-container .select2-selection--multiple {
    min-height: 100% !important;
} */

.select2-container--default .select2-selection--multiple .select2-selection__choice {
    margin-top: 10px !important;
    background: #1c90a7 !important;
    border: none !important;
    color: #fff !important;
}

button.select2-selection__choice__remove {
    border: none !important;
    color: #fff !important;
}

.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover,
.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:focus {
    background-color: #158297 !important;
}

span.select2-selection.select2-selection--multiple {
    max-height: 60px;
    overflow-y: auto;
}

textarea.select2-search__field {
    /* width: 100% !important; */
    height: 30px !important;
    margin-top: 0 !important;
    margin-left: 0 !important;
}

span.select2-selection.select2-selection--multiple::-webkit-scrollbar {
    width: 1px;
}

span.select2-selection.select2-selection--multiple::-webkit-scrollbar-thumb {
    background-color: #cb0074 !important;
    outline: 0px solid #cb0074 !important;
}

span.select2-selection.select2-selection--multiple::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 0px rgb(203 0 116) !important;
}
</style>
<link rel='stylesheet' href="{{asset('css/profile/host-style.css')}}" media='all' />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9" ng-controller='profileDashboardCtrl' ng-init="init({{$user->id ?? null}})"
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
                    <div class="form-outline mb-sm-4 mb-4">
                        <input type="password" class="form-control" ng-model="passwordModel.password" required="">
                        <label class="form-label" style="margin-left: 0px;"><span class="text-danger">*</span>
                            Password</label>
                    </div>
                    <div class="form-outline mb-sm-4 mb-4">
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
            <div class="form-outline mb-sm-4 mb-md-0">
                <input type="password" class="form-control" ng-model="passwordModel.password" required="">
                <label class="form-label" style="margin-left: 0px;">Password</label>
            </div>
            <div class="form-outline mb-sm-4 mb-md-0">
                <input type="password" class="form-control" ng-model="passwordModel.password_confirmation" required="">
                <label class="form-label" style="margin-left: 0px;">Confirm Password</label>
            </div>
            <a class="btn w-100 rounded my-2" title="Close" href="javascript:void(0)" ng-click="changePassword()">CHANGE
                PASSWORD</a>
        </div>
    </div-->
    <div id="skill-photo" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>[[selectedPhoto.is_uploaded == 1 ? 'CROP & ASSIGN' : 'UPLOAD']] PHOTO</h5>
                    <a href="#" title="Close" class="modal-close" ng-click="closeSkillPhotoModal()">Close</a>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-sm-4 mb-md-0">
                        <div ng-if="selectedPhoto.is_uploaded == 1" class="w-100">

                            <div class="demo--content demo--place-center" ng-repeat="user_skill in user_skills">

                                <label class="form-control-760">
                                    <input type="checkbox" ng-model="skillPhoto.cateogry_id"
                                        ng-checked="selectedSkills.includes(user_skill.id)" ng-value="user_skill.id"
                                        ng-click="selectSkill(user_skill.id)" />
                                    [[user_skill.title]]
                                </label>

                            </div>
                            <div class="docs-preview clearfix">
                                <div class="img-preview preview-lg"></div>
                                <div class="img-preview preview-md"></div>
                                <div class="img-preview preview-sm"></div>
                                <div class="img-preview preview-xs"></div>
                            </div>
                            <div class="img-container" ng-if="selectedPhoto.is_uploaded == 1">
                                <!-- uploaded pic shown here -->
                                <img id="skill-image" class="pic"
                                    ng-src="[[selectedPhoto.picture ? selectedPhoto.org_picture  : '/images/Logo_SmokeShowStaff.png']]">
                            </div>
                            <button type="button" class="btn mt-3 float-end" ng-click="saveSkillPhoto()">Save</button>
                        </div>
                        <input ng-if="selectedPhoto.is_uploaded == 0" class="uploadProfileInput"
                            onchange="angular.element(this).scope().uploadProfileInput(this)" type="file"
                            name="profile_pic" id="newProfilePhoto" accept="image/*" />
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="p-3 py-5 ">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">[[auth_user.id == user.id ? 'My Profile' : user.name ]]</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="col-md-12">
                <div class="bg-white">
                    <ul class="nav nav-tabs tablist nav-fill" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <button class="nav-link active" id="faq_tab_2-tab"
                                data-bs-toggle="tab" data-bs-target="#faq_tab_2" type="button" role="tab"
                                aria-controls="faq_tab_2" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-shopping-bag'></i>
                                    <span>SKILLS & PHOTOS</span>
                                </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link activeProfileTab" ng-click="activeProfileTab()"
                                id="faq_tab_1-tab" data-bs-toggle="tab" data-bs-target="#faq_tab_1" type="button"
                                role="tab" aria-controls="faq_tab_1" aria-selected="true">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-plane-alt'></i>
                                    <span>PROFILE</span>
                                </div>
                            </button> </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="faq_tab_2" role="tabpanel"
                            aria-labelledby="faq_tab_2-tab">
                            <div class="container-fluid container-md p-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex section-header bg-light">
                                                <h6>DEFAULT PHOTO</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="d-flex flex-column align-items-center text-center">
                                                    <div class="profile-pic-wrapper">
                                                        <div class="main-pic-holder position-relative">
                                                            <a
                                                                class="btn btn-block w-100 border-0 bg-light shadow rounded-0">
                                                                <img ng-click="setOrderNo(1)" class="pic"
                                                                    ng-src="[[user.skill_photos[0].picture]]">
                                                            </a>
                                                            <i ng-click="deletePhoto(1)"
                                                                class="icofont-ui-delete bg-danger text-white delete-icon"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="d-flex">
                                                    <div class="alt-pic-wrapper"
                                                        ng-repeat="x in [1, 4, 7] track by $index">
                                                        <div class="alt-pic-holder ml-0"
                                                            ng-repeat="photo in user.skill_photos.slice(x, x+3)">
                                                            <!-- uploaded pic shown here -->
                                                            <img class="pic img-fluid" ng-src="[[photo.picture]]"
                                                                ng-click="setOrderNo(photo.order_no)">

                                                            <label ng-if="photo.is_uploaded == 0"
                                                                class="upload-file-block"
                                                                ng-click="setOrderNo(photo.order_no)">
                                                                <div class="text-center">
                                                                    <div class="mb-2">
                                                                        <i class="fa fa-plus-square fa-2x"></i>
                                                                    </div>
                                                                    <div class="text-uppercase">
                                                                        Add image
                                                                    </div>
                                                                </div>
                                                            </label>

                                                            <i ng-if="photo.is_uploaded == 1"
                                                                class="icofont-ui-delete bg-danger text-white delete-icon"
                                                                ng-click="deletePhoto(photo.order_no)"></i>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header d-flex section-header bg-light">
                                                <h6>SKILLS</h6>
                                            </div>
                                            <div class="card-body">
                                                <p>Choose which jobs you wish to apply for by selecting from the
                                                    categories listed below. Ensure to click on each image after upload
                                                    and select which category the image should show in.

                                                    Once uploaded select one image from each category to represent you
                                                    as your default image (represented by the green dot).</p>
                                            </div>
                                        </div>

                                        <div class="ml-3 " ng-repeat="user_skill in user_skills">
                                            <div class="card">
                                                <div class="card-header set-notification">
                                                    <h6 class="text-white">[[user_skill.title]]</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="skill-photos bg-light cursor-pointer ">
                                                        <div class="d-flex p-2">
                                                            <span class="skill-photo cursor-pointer position-relative"
                                                                ng-repeat="skill_photo in user_skill.photos">
                                                                <img style="width:70px;height:70px"
                                                                    ng-src="[[skill_photo.photo.picture]]"
                                                                    class="img-thumbnail img-fluid me-2"
                                                                    ng-click="setDefaultPhoto(user_skill.id, skill_photo.photo.id)" />
                                                                <i ng-show="skill_photo.is_default_skill_photo == 1"
                                                                    class="icofont-tick-mark bg-success text-white"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <form>
                                                        <div class="demo--content demo--place-center"
                                                            ng-repeat="sub_skill in user_skill.sub_categories">

                                                            <label class="form-control-760 my-3">
                                                                <input type="checkbox"
                                                                    ng-model="skillModel.skill_ids[[sub_skill.id]]"
                                                                    ng-click="skillValue($event, sub_skill)"
                                                                    class="skill" name="checkbox-checked-state" />
                                                                [[sub_skill.title]]
                                                            </label>
                                                            <div class="row skill-value"
                                                                style="display: [[sub_skill.is_selected ? 'flex' : 'none']]">
                                                                <div class="col-md-12 col-lg-6 ">
                                                                    <div
                                                                        class="form-outline mb-sm-4 mb-md-3 [[sub_skill.is_selected ? 'hasvalue' : '']]">
                                                                        <input numbers-only limit="2" type="text"
                                                                            class="form-control"
                                                                            ng-model="skillModel.experiences[[sub_skill.id]]"
                                                                            value="" required="">
                                                                        <label class="form-label"
                                                                            style="margin-left: 0px;">
                                                                            Experience (in Years)</label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12 col-lg-6 ">
                                                                    <div
                                                                        class="form-outline mb-sm-4 mb-md-3 [[sub_skill.is_selected ? 'hasvalue' : '']]">
                                                                        <input type="text" class="form-control"
                                                                            ng-model="skillModel.work_details[[sub_skill.id]]"
                                                                            value="" required="">
                                                                        <label class="form-label"
                                                                            style="margin-left: 0px;">Where
                                                                            You
                                                                            Worked?</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                </div>

                                <div class="py-3 row">
                                    <div class="col-sm-12">
                                        <a class="btn" ng-click="saveSkills()" href="#" style="float: right">Save</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq_tab_1" ng-show="showProfileTab" role="tabpanel"
                            aria-labelledby="faq_tab_1-tab">
                            <div class="card mb-3 mt-3">
                                <div class="card-body">
                                    <div class="w-100 text-end my-2">
                                        <button type="button" class="btn" data-bs-toggle="modal"
                                            data-bs-target="#changePassword" ng-click="showChangePaswordModal()">Change
                                            Password</button>
                                        <!-- <a href="#change-pwd" class="btn">Change Password</a> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card mb-3 ">
                                                <div class="card-header set-notification">
                                                    <h6 class="text-white">BASIC INFO</h6>
                                                </div>
                                                <div class="card-body mt-2">

                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-4 md-sm-0 mb-md-4">
                                                            <div class="form-outline mb-sm-4 mb-md-3 mb-lg-0 hasvalue">
                                                                <input type="text" class="form-control"
                                                                    ng-model="profileModel.first_name" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-4 md-sm-0 mb-md-4">
                                                            <div class="form-outline mb-sm-4 mb-md-3 mb-lg-0 hasvalue">
                                                                <input type="text" class="form-control"
                                                                    ng-model="profileModel.last_name" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Last
                                                                    Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-4 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-0 [[profileModel.display_name ? 'hasvalue' : '']]">
                                                                <input type="text" class="form-control"
                                                                    ng-model="profileModel.display_name" value=""
                                                                    required="">
                                                                <label class="form-label" style="margin-left: 0px;">
                                                                    PartiStaff
                                                                    Name</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-0 [[profileModel.nationality.name ? 'hasvalue' : '']]">
                                                                <input type="text" class="form-control" readonly
                                                                    ng-model="profileModel.nationality.name" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Country</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-0 [[profileModel.address.suburb ? 'hasvalue' : '']]">
                                                                <input type="text" class="form-control"
                                                                    id="autocomplete"
                                                                    ng-model="profileModel.address.suburb" value=""
                                                                    required="">
                                                                <input type="hidden"
                                                                    ng-model="profileModel.address.latitude"
                                                                    id="latitude" class="form-control" value=""
                                                                    required="">
                                                                <input type="hidden"
                                                                    ng-model="profileModel.address.longitude"
                                                                    id="longitude" class="form-control" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Suburb</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-0 [[profileModel.address.state_id ? 'hasvalue' : '']]">
                                                                <select class="form-control"
                                                                    ng-model="profileModel.address.state_id">
                                                                    <option value="" disabled>Region</option>
                                                                    <option ng-repeat="state in states"
                                                                        ng-value="state.id">
                                                                        [[state.name]] </option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Region</label>
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-0 [[profileModel.address.postal_code ? 'hasvalue' : '']]">
                                                                <input type="text" class="form-control"
                                                                    ng-model="profileModel.address.postal_code" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Postcode</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div class="form-outline mb-sm-4 mb-md-3 mb-lg-0 hasvalue">

                                                                <input type="hidden" value="{{ $phone_code }}"
                                                                    class="selected_country selected_country_staff">
                                                                <input aria-invalid="true" required type="tel"
                                                                    ng-model="profileModel.phone" id="phone_int_staff"
                                                                    class="form-control phone_int">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div class="form-outline mb-sm-4 mb-md-3 mb-lg-0 hasvalue">
                                                                <input type="text" class="form-control" readonly
                                                                    ng-model="profileModel.email" value="" required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Email</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.gender ? 'hasvalue' : '']]">
                                                                <select class="form-control"
                                                                    ng-model="profileModel.gender">
                                                                    <option value="" disabled>Gender</option>
                                                                    <option value="male">Male</option>
                                                                    <option value="female">Female</option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Gender</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.dob ? 'hasvalue' : '']]">
                                                                <input type="date" class="form-control"
                                                                    ng-model="profileModel.dob" value="" required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Date of
                                                                    Birth</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.resume ? 'hasvalue' : '']]">
                                                                <textarea rows="5" cols="50" class="form-control"
                                                                    placeholder="Describe yourself as if the reader wants to hang out with you after reading this!"
                                                                    ng-model="profileModel.resume"
                                                                    style="height:150px">[[profileModel.resume]]</textarea>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Conduct
                                                                    a
                                                                    resume
                                                                    about
                                                                    your past experience here</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card mb-3 ">

                                                <div class="card-header set-notification">
                                                    <h6 class="text-white">ADDITIONAL INFO</h6>
                                                </div>

                                                <div class="card-body mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-xl-12 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.youtube ? 'hasvalue' : '']]">
                                                                <input type="text" class="form-control"
                                                                    ng-model="profileModel.youtube" value=""
                                                                    required="">
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;">Youtube</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg-6 col-xl-6 md-sm-0 mb-md-4 d-none">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.build_type_id ? 'hasvalue' : '']]">
                                                                <select class="form-control"
                                                                    ng-model="profileModel.build_type_id">
                                                                    <option ng-repeat="bt in build_types"
                                                                        ng-value="bt.id">
                                                                        [[bt.name]]
                                                                    </option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> Build
                                                                    Type</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12 col-lg-12 col-xl-12 md-sm-0 mb-md-4">
                                                            <div
                                                                class="form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.nationality_id ? 'hasvalue' : '']]">
                                                                <select class="form-control"
                                                                    ng-model="profileModel.nationality_id">
                                                                    <option ng-repeat="na in nationalities"
                                                                        ng-value="na.id">[[na.name]]
                                                                    </option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small>
                                                                    Nationality</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-12 md-sm-0 mb-md-4">
                                                            <div class="form-outline mb-sm-4 mb-md-3 mb-lg-0 selector">
                                                                {{-- <select multiple class="full-width" ui-select2="groupSetup" ng-model="profileModel.language_ids">
                                                                    <option ng-repeat="lang in languages"
                                                                        ng-value="lang.id">[[lang.name]]([[lang.native_name]])</option>
                                                                </select> --}}
                                                                <select id="e1" class="selector js-example-basic-multiple form-control"
                                                                    multiple="multiple" ng-model="profileModel.language_ids">
                                                                    <option ng-repeat="lang in languages"
                                                                        ng-value="lang.id">[[lang.name]]([[lang.native_name]])</option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small>
                                                                    Select Language</label>
                                                            </div>
                                                            <div
                                                                class=" d-none form-outline mb-sm-4 mb-md-3 mb-lg-0 [[profileModel.english_level ? 'hasvalue' : '']]">
                                                                <select class="form-control"
                                                                    ng-model="profileModel.english_level">
                                                                    <option value="beginner">Beginner</option>
                                                                    <option value="intermediate">Intermediate
                                                                    </option>
                                                                    <option value="advanced">Advanced</option>
                                                                </select>
                                                                <label class="form-label"
                                                                    style="margin-left: 0px;"><small
                                                                        class="text-danger">*</small> English
                                                                    Level</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                </div>

                                                <div class="card-header set-notification">
                                                    <h6 class="text-white">Qualifications</h6>
                                                </div>

                                                <div class="card-body mt-2">
                                                    <div class="row">
                                                        <div class="col-md-12">

                                                            <div class="demo--content demo--place-center">
                                                                <label class="form-control-760">

                                                                    <input type="checkbox"
                                                                        ng-model="profileModel.rsa_qualified"
                                                                        ng-true-value="1" ng-false-value="0"
                                                                        ng-click="toggleQualification(profileModel.rsa_qualified)" />
                                                                    RSA
                                                                </label>
                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        ng-model="profileModel.rcg_qualified"
                                                                        ng-true-value="1" ng-false-value="0"
                                                                        ng-click="toggleQualification(profileModel.rcg_qualified)" />
                                                                    RCG
                                                                </label>
                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        ng-model="profileModel.security_qualified"
                                                                        ng-true-value="1" ng-false-value="0"
                                                                        ng-click="toggleQualification(profileModel.security_qualified)" />
                                                                    Security
                                                                </label>

                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        ng-model="profileModel.silver_service_qualified"
                                                                        ng-true-value="1" ng-false-value="0"
                                                                        ng-click="toggleQualification(profileModel.silver_service_qualified)" />
                                                                    Silver Service
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="card-header set-notification d-none">
                                                    <h6 class="text-white">NOTIFICATION SETTINGS</h6>
                                                </div>
                                                <ul class="list-group list-group-flush d-none">
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">Sms</h6>
                                                        <span class="">
                                                            <div class="demo--content demo--place-center">
                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        name="checkbox-checked-state" />
                                                                </label>
                                                            </div>
                                                        </span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">Job</h6>
                                                        <span class="">
                                                            <div class="demo--content demo--place-center">
                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        name="checkbox-checked-state" />
                                                                </label>
                                                            </div>
                                                        </span>
                                                    </li>
                                                    <li
                                                        class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                        <h6 class="mb-0">Chat Message</h6>
                                                        <span class="">
                                                            <div class="demo--content demo--place-center">
                                                                <label class="form-control-760">
                                                                    <input type="checkbox"
                                                                        name="checkbox-checked-state" />
                                                                </label>
                                                            </div>
                                                        </span>
                                                    </li>
                                                </ul>
                                                <div class="row">
                                                    <div class="col-sm-12">

                                                        <a class="btn" ng-click="toSaveProfile()" href="#"
                                                            style="float: right">Save
                                                            Profile</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    @if (Auth::user()->hasAdminRights())
                    <div class="card set-notification mt-3">
                        <div class="card-header">
                            <h6 class="text-white">STATUS : <i class="text-capitalize">[[user.status]]</i></h6>
                        </div>

                        <div class="bg-light">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-grid" ng-if="user.status == 'pending' || user.status == 'rejected'">
                                    <button class="btn" ng-click="changeStatusTo('approved')">Approve</button>
                                </li>
                                <li class="list-group-item d-grid" ng-if="user.status == 'blocked'">
                                    <button class="btn" ng-click="changeStatusTo('approved')">Unblock</button>
                                </li>
                                <li class="list-group-item d-grid" ng-if="user.status == 'pending'">
                                    <button class="btn" ng-click="changeStatusTo('rejected')">Reject</button>
                                </li>
                                <li class="list-group-item d-grid" ng-if="user.status == 'approved'">
                                    <button class="btn btn-block" ng-click="changeStatusTo('blocked')">Block</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    @endsection
    @section('js-controller')
    <script src="{{ ('/app/profile-dashboard-controller.js') }}"></script>
    <script src="{{asset('/js/profile-address.js')}}"></script>
    <script>
    $(document).ready(function() {

        var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
            removeItemButton: true,
            maxItemCount: 100,
            searchResultLimit: 5,
            renderChoiceLimit: 5
        });
        $('.skill').on('click', function() {
            var skill_val = $('.skill-value');
            $(this).parent().next(skill_val).toggle();
        });

    });
    </script>
    @endsection