@extends('layouts.app')
<style>
input {
    background: #00696d !important;
    border: 1px solid #00595d !important;
}

input,
input:focus {
    color: #fff !important;
}

.iti__arrow--up {
    border-top: none;
    border-bottom: 4px solid #f1f1f1 !important;
}

.iti__arrow {
    border-top: 4px solid #f1f1f1 !important;
}

.iti__flag-container {
    /* width: 100%; */
}

select {
    background: #00696d !important;
    border: 1px solid #00595d !important;
    color: #9aaaaa !important;
}

select ::placeholder {
    color: #9aaaaa !important;
}

input::placeholder {
    color: #9aaaaa !important;
}

.iti__country {
    color: #cfcfcf !important;
}

.iti__country span {
    color: #cfcfcf !important;
}

.iti__country-list {
    /* width: 100%; */
    background: #009398 !important;
    border: 1px solid #00595d !important;
}
</style>
@section('content')
<div id="content" class="site-content site-content d-flex align-items-center justify-content-center"
    ng-controller='authCtrl' ng-init="init()" style="background-color: #009398;">
    <div class="container-fluid p-0">
        <div data-elementor-type="wp-page" data-elementor-id="360" class="elementor elementor-360"
            data-elementor-settings="[]">
            <div class="elementor-section-wrap">

                <section
                    class=" main-signup elementor-section elementor-top-section elementor-element elementor-element-826f719 elementor-section-full_width elementor-section-height-default elementor-section-height-default "
                    data-id="826f719" data-element_type="section"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeIn&quot;,&quot;background_motion_fx_motion_fx_scrolling&quot;:&quot;yes&quot;,&quot;background_motion_fx_translateY_effect&quot;:&quot;yes&quot;,&quot;background_motion_fx_translateY_speed&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:3,&quot;sizes&quot;:[]},&quot;background_motion_fx_translateY_affectedRange&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:{&quot;start&quot;:0,&quot;end&quot;:100}},&quot;background_motion_fx_devices&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;]}">
                    <div class="elementor-background-overlay"></div>
                    <div class="elementor-container elementor-column-gap-default">
                        <div style="background-color: #007377;"
                            class="mx-2 elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-226a0ba"
                            data-id="226a0ba" data-element_type="column">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-dfeb732 elementor-widget elementor-widget-heading"
                                    data-id="dfeb732" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">


                                        <a href="#" class="btn btn-st-1 signupWith btn-find-job" ng-click="signupWith('staff')">Find a Job</a>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-0a3eeba elementor-widget elementor-widget-text-editor"
                                    data-id="0a3eeba" data-element_type="widget" data-widget_type="text-editor.default">
                                    <div class="elementor-widget-container">
                                        <p>Whether you need assistance for a booth at a tradeshow, a street team
                                            to promote your brand or promotional models for a private event, we
                                            always make sure to provide clients with outstanding service and
                                            representation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: #007377;"
                            class="mx-2 elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-f101756"
                            data-id="f101756" data-element_type="column"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-13c8cfc elementor-widget elementor-widget-heading"
                                    data-id="13c8cfc" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <a href="#" class="btn btn-st-1 signupWith btn-hire-staff" ng-click="signupWith('host')">Hire Staff</a>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-8e05874 elementor-widget elementor-widget-text-editor"
                                    data-id="8e05874" data-element_type="widget" data-widget_type="text-editor.default">
                                    <div class="elementor-widget-container">
                                        <p>We have a very highly talented staff ranging anywhere from topless
                                            dealers to strippers. Our entertainers will always provide an
                                            energetic and personable experience for an unforgettable event.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section style="display: none;"
                    class="res-hire-staff elementor-section elementor-top-section elementor-element elementor-element-826f719 elementor-section-full_width elementor-section-height-default elementor-section-height-default "
                    data-id="826f7190" data-element_type="section"
                    data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeIn&quot;,&quot;background_motion_fx_motion_fx_scrolling&quot;:&quot;yes&quot;,&quot;background_motion_fx_translateY_effect&quot;:&quot;yes&quot;,&quot;background_motion_fx_translateY_speed&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:3,&quot;sizes&quot;:[]},&quot;background_motion_fx_translateY_affectedRange&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:{&quot;start&quot;:0,&quot;end&quot;:100}},&quot;background_motion_fx_devices&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;]}">
                    <div class="elementor-background-overlay"></div>
                    <div class="elementor-container elementor-column-gap-default">
                        <div style="background-color: #007377;"
                            class="mx-2 elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-226a0ba"
                            data-id="226a0ba" data-element_type="column">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-dfeb732 elementor-widget elementor-widget-heading"
                                    data-id="dfeb732" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <a href="#" class="btn btn-st-1 btn-staff-ind">Individual</a>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-0a3eeba elementor-widget elementor-widget-text-editor"
                                    data-id="0a3eeba" data-element_type="widget" data-widget_type="text-editor.default">
                                    <div class="elementor-widget-container">
                                        <p>Whether you need assistance for a booth at a tradeshow, a street team
                                            to promote your brand or promotional models for a private event, we
                                            always make sure to provide clients with outstanding service and
                                            representation.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="background-color: #007377;"
                            class="mx-2 elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-f101756"
                            data-id="f101756" data-element_type="column"
                            data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                            <div class="elementor-widget-wrap elementor-element-populated">
                                <div class="elementor-element elementor-element-13c8cfc elementor-widget elementor-widget-heading"
                                    data-id="13c8cfc" data-element_type="widget" data-widget_type="heading.default">
                                    <div class="elementor-widget-container">
                                        <a href="#" class="btn btn-st-1 btn-staff-bus">Business</a>
                                    </div>
                                </div>
                                <div class="elementor-element elementor-element-8e05874 elementor-widget elementor-widget-text-editor"
                                    data-id="8e05874" data-element_type="widget" data-widget_type="text-editor.default">
                                    <div class="elementor-widget-container">
                                        <p>We have a very highly talented staff ranging anywhere from topless
                                            dealers to strippers. Our entertainers will always provide an
                                            energetic and personable experience for an unforgettable event.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>


                <section class="trans row m-0 py-5 form-find-job" style="background-color: #009398; display: none;">
                    <div class="container-fluid">
                        <div class="container">
                            <div class="d-flex flex-column align-items-center">
                                <div class="col-md-6">
                                    <div class="card" style="background-color: #007377;">
                                        <div class="card-header d-flex text-white p-3 text-uppercase">
                                            <div class="card-title">
                                                <strong>Staff SignUp</strong>
                                            </div>
                                            <div class="card-toolbar" style="margin-left:auto;">
                                                <a href="javascript:void(0)" class="text-white btnc-find-job"><i
                                                        class="icofont-close-circled"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body px-5">
                                            <div class="form-groups">
                                                <form ng-submit="registerUser('staff')">
                                                    @csrf
                                                    <input type="hidden" ng-model="signupForm.referral_code">
                                                    <div class="mb-3">
                                                        <input type="text" maxlength="50"
                                                            ng-model="signupForm.first_name" class="form-control"
                                                            placeholder="First Name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" maxlength="50"
                                                            ng-model="signupForm.last_name" class="form-control"
                                                            placeholder="Last Name">
                                                    </div>
                                                    <div class="mb-3" ng-if="staffDiv">
                                                        <input type="hidden" value="ca"
                                                            class="selected_country selected_country_staff">
                                                        <input aria-invalid="true" type="tel" ng-disabled="is_verified"
                                                            ng-model="signupForm.phone" id="phone_int_staff"
                                                            class="form-control phone_int">
                                                    </div>
                                                    <div class=" input-group mb-3">

                                                        <input aria-invalid="true" type="text"
                                                            ng-model="signupForm.verify_code"
                                                            class="form-control"
                                                            ng-disabled="is_verified" 
                                                            placeholder="Verification Code"
                                                            ng-change="verifyCode()"
                                                            aria-describedby="button-addon3" >
                                                        <button type="button" ng-disabled="!can_send_code" ng-click="sendOtp();" id="button-addon3" class="btn btn-sm">[[is_verified ? 'Verified' : (can_send_code ? 'Send Otp' : 'Resend in '+ countDown +'s')]]</button>
                                                    </div>
                                                    <div class="mb-3">
                                                        <select class="form-control" ng-model="signupForm.gender">
                                                            <option value="" disabled>Select Gender</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" ng-model="signupForm.display_name"
                                                            class="form-control" maxlength="50"
                                                            placeholder="Show Staff Name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" ng-model="signupForm.email"
                                                            class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="password" ng-model="signupForm.password"
                                                            class="form-control" placeholder="Password">
                                                    </div>

                                                    <div class="d-flex align-items-end justify-content-end">
                                                        <button type="submit" ng-disabled="!is_verified"
                                                            class="btn bg-theme-pink text-white">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                <section class="trans row m-0 py-5 form-res-indnbus" style="background-color: #009398; display: none;">
                    <div class="container-fluid">
                        <div class="container">
                            <div class="d-flex flex-column align-items-center">
                                <div class="col-md-6">
                                    <div class="card" style="background-color: #007377d1;">
                                        <div class="card-header d-flex text-white p-3 text-uppercase">
                                            <div class="card-title">
                                                <strong>Host SignUp</strong>
                                            </div>
                                            <div class="card-toolbar" style="margin-left:auto;">
                                                <a href="javascript:void(0)" class="text-white btnc-indnbus"><i
                                                        class="icofont-close-circled"></i></a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-groups">
                                                <form ng-submit="registerUser('host')">
                                                    @csrf
                                                    <input type="hidden" ng-model="signupForm.referral_code">
                                                    {{-- <div class="mb-3 d-flex">
                                                        <button class="btn btn-st-fb btn-block btn-all"><i
                                                                class="icofont-facebook"></i> SIGNUP WITH
                                                            FACEBOOK</button>
                                                        <button class="btn btn-st-appl btn-block btn-all"><i
                                                                class="icofont-brand-apple"></i> SIGNUP WITH
                                                            APPLE</button>
                                                    </div>
                                                    <div class="mb-3 text-center text-white"><strong>OR</strong> 
                                                    </div> --}}
                                                    <div class="mb-3">
                                                        <input type="text" ng-model="signupForm.first_name"
                                                            class="form-control" placeholder="First Name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" ng-model="signupForm.last_name"
                                                            class="form-control" placeholder="Last Name">
                                                    </div>
                                                    <div class="mb-3" ng-if="hostDiv">
                                                        <input type="hidden" value="ca"
                                                            class="selected_country selected_country_host">
                                                        <input aria-invalid="true" type="tel" ng-disabled="is_verified"
                                                            ng-model="signupForm.phone" id="phone_int_host"
                                                            class="form-control phone_int">
                                                    </div>
                                                    <div class=" input-group mb-3">

                                                        <input aria-invalid="true" type="text"
                                                            ng-model="signupForm.verify_code"
                                                            class="form-control"
                                                            ng-disabled="is_verified" 
                                                            placeholder="Verification Code"
                                                            ng-change="verifyCode()"
                                                            aria-describedby="button-addon4" >
                                                        <button type="button" ng-disabled="!can_send_code" ng-click="sendOtp();" id="button-addon4" class="btn btn-sm">[[is_verified ? 'Verified' : (can_send_code ? 'Send Otp' : 'Resend in '+ countDown +'s')]]</button>

                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <input aria-invalid="true" type="text"
                                                            ng-model="signupForm.verify_code"
                                                            class="form-control"
                                                            placeholder="Verify Code" ng-change="verifyCode()" >
                                                    </div> --}}
                                                    <div class="mb-3 bsname" style="display: none;">
                                                        <input type="text" ng-model="signupForm.display_name"
                                                            class="form-control" placeholder="Business Name">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="text" ng-model="signupForm.email"
                                                            class="form-control" placeholder="Email">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="password" ng-model="signupForm.password"
                                                            class="form-control" placeholder="Password">
                                                    </div>
                                                    {{-- <div class="mb-3">
                                                        <input type="text" class="form-control"
                                                            placeholder="Promo/Referal Code (optional)" name="">
                                                    </div>
                                                    <div class="mb-3">
                                                        <select class="form-control" placeholder="">
                                                            <option>How did you hear about us?</option>
                                                        </select>
                                                    </div> --}}
                                                    <div class="d-flex align-items-end justify-content-end">
                                                        <button type="submit" ng-disabled="!is_verified"
                                                            class="btn bg-theme-pink text-white">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </section>

                {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
                    integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script> --}}


            </div>
        </div>
    </div> <!-- ast-container -->
</div><!-- #content -->
@endsection

@section('javascripts')

<!-- INTL TEL INPUT SCRIPTS -->
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/intlTelInput.js')}}"></script>
<script src="{{asset('js/utils.js')}}"></script>
<!-- INTL TEL INPUT SCRIPTS -->
<script src="{{ ('/app/auth-controller.js') }}"></script>
<script>
$('.btnc-find-job').on('click', function() {
    $('.form-find-job').hide('slow');
    $('.main-signup').show('slow');
});
$('.btnc-indnbus').on('click', function() {
    $('.trans').hide('slow');
    $('.main-signup').show('slow');
});
$('.btn-find-job').on('click', function() {
    $('.main-signup').hide('slow');
    $('.form-find-job').show('slow');
    setTimeout(() => {
        $('.trans').css({
            'opacity': '1',
            'visibility': 'visible',
            'right': '0'
        });
    }, 800);
});
$('.btn-hire-staff').on('click', function() {
    $('.main-signup').hide('slow');
    $('.res-hire-staff').show('slow');
    $('.trans').css({
        'opacity': '1',
        'visibility': 'visible',
        'right': '0'
    });
});
$('.btn-staff-ind').on('click', function() {
    $('.res-hire-staff').hide();
    $('.form-res-indnbus').show('slow');
    $('.trans').css({
        'opacity': '1',
        'visibility': 'visible',
        'right': '0'
    });
    $('.bsname').hide();

});
$('.btn-staff-bus').on('click', function() {
    $('.res-hire-staff').hide();
    $('.form-res-indnbus').show('slow');
    $('.trans').css({
        'opacity': '1',
        'visibility': 'visible',
        'right': '0'
    });
    $('.bsname').show();

});
</script>
@endsection