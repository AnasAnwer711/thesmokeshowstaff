@extends('layouts.app')
@yield('main-css')
@section('content')
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />

<div id="content" class="site-content">

    <div class="container-fluid container-md rounded bg-white my-sm-2 my-md-5" ng-cloak class="ng-cloak">
        <div class="row">
            <div class="success-message col-md-12" style="position:relative;">

            </div>
            @include('content.menu.sidebar')
            @yield('main-body')
        </div>
    </div>
</div>

@endsection
@section('javascripts')

@yield('js-controller')


<!-- INTL TEL INPUT SCRIPTS -->
<script src="{{asset('js/jquery.mask.min.js')}}"></script>
<script src="{{asset('js/intlTelInput.js')}}"></script>
<script src="{{asset('js/utils.js')}}"></script>
<!-- INTL TEL INPUT SCRIPTS -->
<script type="text/javascript">
$().ready(function() {
    $(".form-control").blur(function() {
        if ($(this).val()) {
            $(this).parent().addClass('hasvalue');
        }
    });
});
$('.btn.edit-profile').on('click', function() {
    $('.text-secondary').hide().css('opacity', '0');
    $('.field-title').hide().css('opacity', '0');
    $('.btn.edit-profile').hide().css('opacity', '0');
    $('.edit-text-secondary').show().css('opacity', '1');
    $('.save-profile').show('slow');
    $('.cancel-profile').show('slow');
});
$('.btn.save-profile').on('click', function() {
    $('.text-secondary').show().css('opacity', '1');
    $('.field-title').show().css('opacity', '1');
    $('.btn.edit-profile').show().css('opacity', '1');
    $('.edit-text-secondary').hide().css('opacity', '0');
    $('.save-profile').hide();
    $('.cancel-profile').hide();
});
$('.btn.cancel-profile').on('click', function() {
    $('.text-secondary').show().css('opacity', '1');
    $('.field-title').show().css('opacity', '1');
    $('.btn.edit-profile').show().css('opacity', '1');
    $('.edit-text-secondary').hide().css('opacity', '0');
    $('.save-profile').hide();
    $('.cancel-profile').hide();
});
</script>
<script type="text/javascript">
function addActiveClass(next_fs, current_fs) {
    //Add Class Active
    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

    //show the next fieldset
    next_fs.show();
    //hide the current fieldset with style
    current_fs.animate({
        opacity: 0
    }, {
        step: function(now) {
            // for making fielset appear animation
            opacity = 1 - now;

            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({
                'opacity': opacity
            });
        },
        duration: 600
    });
}

function validateInitial(scope) {
    console.log(scope.jobForm);
    hasError = false;

    // Event Name Validation
    if (!scope.jobForm.title) {
        $('.field-message-title').show();
        hasError = true;
    } else
        $('.field-message-title').hide();

    // Staff Category Validation
    if (!scope.jobForm.staff_category_id) {
        $('.field-message-staff_category_id').show();
        hasError = true;
    } else
        $('.field-message-staff_category_id').hide();

    // Job Date Validation
    if (!scope.jobForm.date) {
        $('.field-message-date').show();
        hasError = true;
    } else
        $('.field-message-date').hide();

    // Looking For Validation
    if (!scope.jobForm.gender) {
        $('.field-message-gender').show();
        hasError = true;
    } else
        $('.field-message-gender').hide();


    // Description Validation
    if (!scope.jobForm.description) {
        $('.field-message-description').show();
        hasError = true;
    } else
        $('.field-message-description').hide();



    if (hasError)
        return false;
    else
        addActiveClass(scope.next_fs, scope.current_fs)

}

function validateDetail(scope) {
    console.log(scope.jobForm);
    hasError = false;

    // Location Validation
    if (!scope.jobForm.location) {
        $('.field-message-location').show();
        hasError = true;
    } else
        $('.field-message-location').hide();

    // Address Line 1 Validation
    if (!scope.jobForm.address.address_line1) {
        $('.field-message-address_line1').show();
        hasError = true;
    } else
        $('.field-message-address_line1').hide();

    // Suburb Validation
    if (!scope.jobForm.address.suburb) {
        $('.field-message-suburb').show();
        hasError = true;
    } else
        $('.field-message-suburb').hide();

    // Region Validation
    if (!scope.jobForm.address.state_id) {
        $('.field-message-state').show();
        hasError = true;
    } else
        $('.field-message-state').hide();


    // Post Code Validation
    if (!scope.jobForm.address.postal_code) {
        $('.field-message-postal_code').show();
        hasError = true;
    } else
        $('.field-message-postal_code').hide();

    // Start Time Validation
    if (!scope.jobForm.start_time) {
        $('.field-message-start_time').show();
        hasError = true;
    } else
        $('.field-message-start_time').hide();

    // Duration Validation
    if (!scope.jobForm.duration) {
        $('.field-message-duration').show();
        hasError = true;
    } else
        $('.field-message-duration').hide();

    // End Time Validation
    if (!scope.jobForm.end_time) {
        $('.field-message-end_time').show();
        hasError = true;
    } else
        $('.field-message-end_time').hide();

    // Dress Code Validation
    if (!scope.jobForm.dress_code) {
        $('.field-message-dress_code').show();
        hasError = true;
    } else
        $('.field-message-dress_code').hide();

    // Job Title Validation
    if (!scope.jobForm.job_title) {
        $('.field-message-job_title').show();
        hasError = true;
    } else
        $('.field-message-job_title').hide();



    if (hasError)
        return false;
    else
        addActiveClass(scope.next_fs, scope.current_fs)

}

function validatePayment(scope) {
    console.log(scope.jobForm);
    hasError = false;

    // Pay Rate Validation
    if (!scope.jobForm.pay_rate) {
        $('.field-message-pay_rate').show();
        hasError = true;
    } else
        $('.field-message-pay_rate').hide();

    // Min Rate Validation
    if (scope.jobForm.min_rate_applicable) {
        if (scope.jobForm.pay_type == 'per_party') {
            $('.field-message-min_rate').hide();
            if (parseInt(scope.jobForm.pay_rate) < (parseInt(scope.jobForm.min_rate) * parseInt(scope.jobForm
                    .duration))) {
                $('.field-message-min_rate_with_type').show();
                hasError = true;
            } else
                $('.field-message-min_rate_with_type').hide();
        } else {
            $('.field-message-min_rate_with_type').hide();
            if (parseInt(scope.jobForm.pay_rate) < parseInt(scope.jobForm.min_rate)) {
                $('.field-message-min_rate').show();
                hasError = true;
            } else
                $('.field-message-min_rate').hide();
        }
    }

    // Pay Type Validation
    if (!scope.jobForm.pay_type) {
        $('.field-message-pay_type').show();
        hasError = true;
    } else
        $('.field-message-pay_type').hide();

    // Travel Allowance Validation
    // if (!scope.jobForm.travel_allowance_id) {
    //     $('.field-message-travel_allowance_id').show();
    //     hasError = true;
    // } else
    //     $('.field-message-travel_allowance_id').hide();

    // Positions Validation
    if (!scope.jobForm.no_of_positions) {
        $('.field-message-no_of_positions').show();
        hasError = true;
    } else
        $('.field-message-no_of_positions').hide();


    if (hasError)
        return false;
    else
        scope.postJob();


}

$(document).ready(function() {

    var current_fs, next_fs, previous_fs; //fieldsets
    var opacity;

    $(".next").click(function() {

        current_fs = $(this).parent();
        next_fs = $(this).parent().next();

        var scope = angular.element(document.getElementById('jobCtrl')).scope();
        scope.current_fs = current_fs;
        scope.next_fs = next_fs;

        if (current_fs.hasClass('initial') && next_fs.hasClass('detail')) {
            validateInitial(scope);
        }

        if (current_fs.hasClass('detail') && next_fs.hasClass('payment')) {
            validateDetail(scope);
        }

        if (current_fs.hasClass('payment') && next_fs.hasClass('final')) {
            validatePayment(scope);
        }


    });



    $(".previous").click(function() {

        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({
            opacity: 0
        }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({
                    'opacity': opacity
                });
            },
            duration: 600
        });
    });

    $('.radio-group .radio').click(function() {
        $(this).parent().find('.radio').removeClass('selected');
        $(this).addClass('selected');
    });

    $(".submit").click(function() {
        return false;
    })

});

$(function() {
    $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection