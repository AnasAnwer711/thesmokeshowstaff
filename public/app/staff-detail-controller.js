app.controller("staffDetailCtrl", function ($scope, $http) {
    $scope.init = function (staff_id) {
        $scope.getStaffDetail(staff_id);
    };

    $scope.getStaffDetail = function (staff_id) {
        $http({
            method: "GET",
            url: "/get_staff_detail/" + staff_id,
        }).then(
            function (response) {
                console.log(response);
                $scope.detail = response.data.data;
                setTimeout(() => {
                    $("#lightSlider").lightSlider({
                        gallery: true,
                        item: 1,
                        loop: true,
                        slideMargin: 0,
                        thumbItem: 9,
                    });
                }, 800);
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.sendMessage = function () {
        if (!$scope.contactForm) {
            toastr.error("Please select a job");
            return;
        }

        if (!$scope.contactForm.job_id) {
            toastr.error("Please select a job");
            return;
        }

        if (!$scope.contactForm.message) {
            toastr.error("Please enter message");
            return;
        }

        console.log();

        $scope
            .ajaxPost("/contact-staff", { ...$scope.contactForm, user_id: $scope.detail.id })
            .then(({ data }) => {
                toastr.success(data.message);
                $scope.contactForm = {};
                $scope.hideContactModal();
            })
            .catch(function ({ response: { data } }) {
                toastr.error(data.message);
            });
    };

    $scope.hideContactModal = function () {
        $("#contactStaffModal").modal("hide");
    };
});
