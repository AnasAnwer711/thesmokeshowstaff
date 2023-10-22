app.controller("invitationsCtrl", function ($scope, $rootScope, $http) {
    $scope.bookingModel = {};

    $scope.init = function () {
        $scope.getSubscriptionPlans();
        $scope.getSubscription();
        let url = $scope.getDecodedUrl();
        
        let hash = '#app_tab_1'
        if (url.hash)
            hash = url.hash;

        $scope.getActiveClass(hash);
    };

    $scope.getActiveClass = function (tab_id) {
        switch (tab_id) {
            case '#app_tab_1':
                $(tab_id).addClass("show active");
                $('#app_tab_2').removeClass("show active");
                $('#app_tab_3').removeClass("show active");
                $(tab_id+'-applicants').addClass("active");
                $('#app_tab_2-invitations').removeClass("active");
                $('#app_tab_3-booked').removeClass("active");

                break;
            case '#app_tab_2':
                $(tab_id).addClass("show active");
                $('#app_tab_1').removeClass("show active");
                $('#app_tab_3').removeClass("show active");
                $(tab_id+'-invitations').addClass("active");
                $('#app_tab_2-applicants').removeClass("active");
                $('#app_tab_3-booked').removeClass("active");

                break;
            case '#app_tab_3':
                $(tab_id).addClass("show active");
                $('#app_tab_1').removeClass("show active");
                $('#app_tab_2').removeClass("show active");
                $(tab_id+'-booked').addClass("active");
                $('#app_tab_2-applicants').removeClass("active");
                $('#app_tab_3-invitations').removeClass("active");

                break;
        
            default:
                break;
        }
    }

    $scope.selectApplicant = function (applicant_id) {
        let applicant = $scope.job.applications.find((a) => a.staff_id == applicant_id);
        $scope.selected_applicant = applicant;
        $("#jobChat").show();
        $scope.user_id = $scope.selected_applicant.staff.id;
        $scope.loadMessages();
    };

    $scope.scrollBottom = function () {
        var ca = document.getElementsByClassName("chatting-area");

        for (let a of ca) a.scrollTop = a.scrollHeight;
    };

    $scope.loadMessages = function () {
        $scope.messages = [];
        $scope
            .ajaxPost("/job-user-messages/", {
                user_id: $scope.user_id,
                job_id: $scope.job.id,
            })
            .then(({ data: { data } }) => {
                $scope.messages = data;
                $scope.$apply();
                $scope.scrollBottom();
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.selectInvitation = function (invitation_id) {
        let invitation = $scope.job.invitations.find((i) => i.staff_id == invitation_id);
        $scope.selected_invitation = invitation;
        $("#invitationChat").show();
        $scope.user_id = $scope.selected_invitation.staff.id;
        $scope.loadMessages();
    };

    $scope.selectBooked = function (booked_id) {
        let booked = $scope.job.booked.find((i) => i.staff_id == booked_id);
        $scope.selected_booked = booked;
        $("#bookedChat").show();
        $scope.user_id = $scope.selected_booked.staff.id;
        $scope.loadMessages();
    };

    $scope.changeJobApplicantStatus = function (job_applicant_id, status, action_by) {
        $http({
            method: "post",
            url: "/change_job_application_status/",
            data: { job_applicant_id: job_applicant_id, status: status, action_by: action_by },
        }).then(
            function (response) {
                console.log(response);
                $scope.getJob(response.data.data.job_id);
                // $scope.job = response.data.data;
                $scope.selected_applicant = null;
                $scope.selected_invitation = null;
                toastr.success("Applicant status has been updated successfully");
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.acceptApplication = function () {
        if ($scope.auth_user.cards.length < 1) {
            title = "Accept Application for Booking";
            message = "You need to add your card and pay the registration fee of $1 to Accept application for the job.";
            return bootbox.dialog({
                title: title,
                message: "<p>" + message + "</p><br/><a href='/credit_card'>Add Credit Card</a>",
            });
        }
        let host_transaction_fee = 0;

        if ($scope.payment_configuration && $scope.payment_configuration.host_transaction_fee) host_transaction_fee = $scope.payment_configuration.host_transaction_fee;

        let domain_name = "The Smoke Show Staff";
        if ($scope.basic_setting && $scope.basic_setting.name) domain_name = $scope.basic_setting.name;

        $scope.message =
            "By accepting application you will be charged the $" + host_transaction_fee + " " + domain_name + " booking fee, or if you have purchased a pack the booking fee will be less.";

        $scope.bookingModel.card_id = $scope.auth_user.cards[0].id;
        $scope.bookingModel.subscription_type = "card";
        if ($scope.activeSubscriptionExist) $scope.bookingModel.subscription_type = $scope.active_subscription.id;
        $("#cardSelectionModal").modal("show");

        // bootbox.confirm({
        //     message: message,
        //     closeButton:false,
        //     callback: function (result) {
        //         if(result)
        //             $scope.acceptBooking();
        //         console.log('This was logged in the callback: ' + result);
        //     }
        // });
    };

    $scope.acceptBooking = function () {
        $http({
            method: "post",
            url: "/accept_application/" + $scope.selected_applicant.id,
            data: $scope.bookingModel,
        }).then(
            function (response) {
                console.log(response);
                $scope.job = response.data.data;
                $scope.selected_applicant = null;
                $("#cardSelectionModal").modal("hide");
                $scope.hideChats();
                toastr.success("Applicant has been booked successfully");
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    // Get Single Job
    $rootScope.getJob = function (job_id) {
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
            },
        );
    };

    $scope.sendMessage = function () {
        $scope
            .ajaxPost("/send-message", {
                user_id: $scope.user_id,
                message: $scope.chat_message,
                job_id: $scope.job.id,
            })
            .then(({ data: { data } }) => {
                $scope.messages.push(data);
                $scope.chat_message = "";
                $scope.$apply();
                $scope.scrollBottom();
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };
    $scope.hideChats = function () {
        $("#jobChat").hide();
        $("#invitationChat").hide();
        $("#bookedChat").hide();
    };
});
