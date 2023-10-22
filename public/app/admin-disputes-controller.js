app.controller("adminDisputesCtrl", function ($scope, $http) {
    $scope.init = () => {
        $scope.getDisputes();
    };

    $scope.getDisputes = () => {
        $scope
            .ajaxGet("/admin/get-disputes")
            .then((response) => {
                if (response.data.success) {
                    $scope.disputes = response.data.data;
                    $scope.$apply();
                }
            })
            .catch((response) => {
                toastr.error(response);
            });
    };

    $scope.viewDispute = (dispute) => {
        $scope.dispute = dispute;
        $scope.job = dispute.job_applicant.job;
        $("#disputeDetail").show();
        $("#disputeTable").hide();
    };

    $scope.viewDisputes = () => {
        $("#disputeDetail").hide();
        $("#disputeTable").show();
    };

    $scope.showModal = () => {
        $("#modalChangeStatus").modal("show");
        $scope.modalForm = {};
    };

    $scope.hideModal = () => {
        $("#modalChangeStatus").modal("hide");
    };

    $scope.resolveDispute = () => {
        if (!$scope.modalForm.status) {
            toastr.error("Please select status");
            return;
        }

        if (!$scope.modalForm.remarks) {
            toastr.error("Please enter remarks");
            return;
        }

        $scope.modalForm.id = $scope.dispute.id;
        $scope
            .ajaxPost("/admin/resolve-dispute", $scope.modalForm)
            .then((response) => {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    $scope.hideModal();
                    $scope.getDisputes();
                    $scope.viewDisputes();
                }
            })
            .catch((response) => {
                console.log(response);
            });
    };
});
