app.controller("applicationsCtrl", function ($scope, $rootScope, $http) {
  $scope.bookingModel = {};

  $scope.init = function () {
    $scope.getApplicants();

    let url = $scope.getDecodedUrl();

    let hash = "#app_tab_1";
    if (url.hash) hash = url.hash;

    $scope.getActiveClass(hash);
  };

  $scope.getActiveClass = function (tab_id) {
    switch (tab_id) {
      case "#app_tab_1":
        $(tab_id).addClass("show active");
        $("#app_tab_2").removeClass("show active");
        $("#app_tab_3").removeClass("show active");
        $(tab_id + "-applicants").addClass("active");
        $("#app_tab_2-invitations").removeClass("active");
        $("#app_tab_3-booked").removeClass("active");

        break;
      case "#app_tab_2":
        $(tab_id).addClass("show active");
        $("#app_tab_1").removeClass("show active");
        $("#app_tab_3").removeClass("show active");
        $(tab_id + "-invitations").addClass("active");
        $("#app_tab_2-applicants").removeClass("active");
        $("#app_tab_3-booked").removeClass("active");

        break;
      case "#app_tab_3":
        $(tab_id).addClass("show active");
        $("#app_tab_1").removeClass("show active");
        $("#app_tab_2").removeClass("show active");
        $(tab_id + "-booked").addClass("active");
        $("#app_tab_2-applicants").removeClass("active");
        $("#app_tab_3-invitations").removeClass("active");

        break;

      default:
        break;
    }
  };

  $rootScope.getApplicants = function () {
    $http({
      method: "get",
      // route('add.to.cart', $item->id)
      url: "/get_applicants",
    }).then(
      function (response) {
        console.log(response);
        // $scope.job_applicants = response.data.data.job_applicants;
        $scope.applications = response.data.data.applications;
        $scope.invitations = response.data.data.invitations;
        $scope.bookings = response.data.data.booked;
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.selectApplicant = function (applicant_id) {
    let applicant = $scope.job.applications.find(
      (a) => a.staff_id == applicant_id
    );
    $scope.selected_applicant = applicant;
    console.log($scope.selected_applicant);
  };

  $scope.selectInvitation = function (invitation_id) {
    let invitation = $scope.job.invitations.find(
      (i) => i.staff_id == invitation_id
    );
    $scope.selected_invitation = invitation;
    console.log($scope.selected_invitation);
  };

  $scope.changeJobApplicantStatus = function (
    job_applicant_id,
    status,
    action_by
  ) {
    $http({
      method: "post",
      url: "/change_job_application_status/",
      data: {
        job_applicant_id: job_applicant_id,
        status: status,
        action_by: action_by,
      },
    }).then(
      function (response) {
        console.log(response);
        $scope.getApplicants();
        // $scope.job = response.data.data;
        $scope.selected_applicant = null;
        $scope.selected_invitation = null;
        toastr.success("Applicant status has been updated successfully");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.extendedHours = function (job_applicant) {
    $scope.extendedModal = {};
    $scope.extendedModal.job_applicant_id = job_applicant.id;
    $scope.staff_fee = 0;
    $scope.transaction_type = "percentage";

    if ($scope.payment_configuration.staff_transaction_fee) {
      $scope.staff_fee = $scope.payment_configuration.staff_transaction_fee;
      $scope.transaction_type =
        $scope.payment_configuration.staff_transaction_type;
    }
    $scope.job_applicant = job_applicant;

    $scope.portal_fee = $scope.job_applicant.job_pay;
    if ($scope.transaction_type == "percentage" && $scope.staff_fee > 0) {
      $scope.portal_fee =
        ($scope.job_applicant.job_pay * $scope.staff_fee) / 100;
    } else {
      $scope.portal_fee = $scope.job_applicant.job_pay + $scope.staff_fee;
    }

    // $scope.job_applicant_id = job_applicant.id
    $("#extendedModal").modal("show");
  };

  $scope.calculateRate = function () {
    a = parseInt($scope.extendedModal.job_extended_hours);
    b = parseInt($scope.job_applicant.job_actual_hours);
    c = parseInt($scope.job_applicant.job_pay_rate);

    $scope.extended_pay = a * c;

    $scope.extended_portal_fee = 0;
    if ($scope.transaction_type == "percentage" && $scope.staff_fee > 0) {
      $scope.extended_portal_fee =
        ($scope.extended_pay * $scope.staff_fee) / 100;
    } else {
      $scope.extended_portal_fee = $scope.extended_pay + $scope.staff_fee;
    }

    $scope.extendedModal.job_pay = c * (a + b);
  };

  $scope.saveExtendedBooking = function () {
    $http({
      method: "post",
      url: "/extended_booking",
      data: $scope.extendedModal,
    }).then(
      function (response) {
        console.log(response);
        $scope.getApplicants();
        $("#extendedModal").modal("hide");
        toastr.success("Hours has been extended into booking successfully");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.getCancellationPolicy = function (user_type) {
    $http({
      method: "GET",
      url: "/get_cancellation_policy/" + user_type,
    }).then(
      function (response) {
        $scope.cancellation_policy = response.data.data;

        if ($scope.cancellation_policy) {
          $scope.message +=
            "<div style='display:grid; color:red;'><span><strong>Please be aware of the Cancellation Policy as below:</strong></span>";
          for (var i = 0; i < $scope.cancellation_policy.length; i++) {
            if ($scope.cancellation_policy[i].rule_type == "cancel")
              $scope.message +=
                "<span>Cancel within " +
                $scope.convertMinutesToHourOrDays(
                  $scope.cancellation_policy[i].duration
                ) +
                " of the job start = $" +
                $scope.cancellation_policy[i].charges +
                " penalty</span>";
            if ($scope.cancellation_policy[i].rule_type == "no-show")
              $scope.message +=
                "<span>No Show - (Don't show up) = $" +
                $scope.cancellation_policy[i].charges +
                " penalty</span>";
          }
          // $scope.message += "<span>Cancel within 14 days of the job start = $5 penalty</span>"
          // $scope.message += "<span>Cancel within 72 hours of the job start = $80 penalty</span>"
          // $scope.message += "<span>No Show - (Don't show up) = $100 penalty</span>"
          let max_duration = Math.max(
            ...$scope.cancellation_policy.map((cp) => cp.duration)
          );
          // console.log(max_duration);
          $scope.message +=
            "<br/><span>Outside of " +
            $scope.convertMinutesToHourOrDays(max_duration) +
            " there are no cancel fees.</span></div>";
        }
        // console.log($scope.auth_user)
      },
      function (error) {
        console.log(error.data.message);
        // toastr.error(error);
      }
    );
  };

  $scope.acceptApplication = function (job_applicant) {
    source = job_applicant.job;
    title = "Accept Application for Booking";
    let event = source.job_title;
    let job_title = source.title;
    let location = source.location;
    let date = $scope.convertUtcToLocalDate(source.date);

    $scope.message =
      "<div style='display:grid'><span>Event: " +
      event +
      "</span><span>Job Title: " +
      job_title +
      "</span><span>Location: " +
      location +
      "</span><span>Date: " +
      date +
      "</span></div><br/>";
    if ($scope.payment_configuration.staff_cancellation) {
      $scope.getCancellationPolicy("staff");
    }
    setTimeout(() => {
      return bootbox.confirm({
        title: title,
        message: $scope.message,
        confirmationButton: false,
        closeButton: false,
        buttons: {
          confirm: {
            label: "Confirm",
            // className: 'btn-success'
          },
        },
        callback: function (result) {
          if (result) {
            $scope.acceptBooking(job_applicant.id);
          }
        },
      });
    }, 1000);
  };

  $scope.acceptBooking = function (job_applicant_id) {
    // console.log($scope.bookingModel);

    $http({
      method: "post",
      url: "/accept_invitation/" + job_applicant_id,
    }).then(
      function (response) {
        console.log(response);
        $scope.getApplicants();
        $scope.selected_applicant = null;
        // $('#cardSelectionModal').modal('hide');
        toastr.success("Invitation has been accepted successfully");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  // Get Single Job
  $scope.getJob = function (job_id) {
    console.log($scope.jobForm);
    $http({
      method: "get",
      // route('add.to.cart', $item->id)
      url: "/get_invitation/" + job_id,
    }).then(
      function (response) {
        console.log(response);
        $scope.job = response.data.data;
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.openMessages = (id) => {
    window.location = "/messages?job_id=" + id;
  };
});
