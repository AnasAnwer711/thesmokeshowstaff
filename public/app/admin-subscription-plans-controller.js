app.controller("adminSubscriptionPlansCtrl", function ($scope, $http) {
    $scope.init = () => {
        $scope.getSubscriptionPlans();
    };

    $scope.getSubscriptionPlans = () => {
        $scope
            .ajaxGet("/admin/get-subscription-plans")
            .then(({ data }) => {
                if (data.success) {
                    $scope.subscriptionPlans = data.data;
                    $scope.$apply();
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.addSubscriptionPlan = () => {
        $scope.subscriptionPlan = {};
        $("#formSubscriptionPlan").show();
    };

    $scope.editSubscriptionPlan = (subscriptionPlan) => {
        $scope.subscriptionPlan = angular.copy(subscriptionPlan);
        $("#formSubscriptionPlan").show();
        window.scroll(0, 0);
    };

    $scope.confirmDeleteSubscriptionPlan = (subscriptionPlan) => {
        $scope.subscriptionPlan = subscriptionPlan;
        $("#modalDeleteSubscriptionPlan").modal("show");
    };

    $scope.hideConfirmModal = () => {
        $("#modalDeleteSubscriptionPlan").modal("hide");
        window.scroll(0, 0);
    };

    $scope.deleteSubscriptionPlan = () => {
        $scope
            .ajaxPost("/admin/delete-subscription-plan", {
                id: $scope.subscriptionPlan.id,
            })
            .then(({ data }) => {
                if (data.success) {
                    toastr.success(data.message);
                    $scope.getSubscriptionPlans();
                    $scope.subscriptionPlan = {};
                    $("#modalDeleteSubscriptionPlan").modal("hide");
                    $scope.cancelForm();
                    window.scroll(0, 0);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.saveSubscriptionPlan = () => {
        $scope
            .ajaxPost("/admin/save-subscription-plan", $scope.subscriptionPlan)
            .then(({ data }) => {
                if (data.success) {
                    toastr.success(data.message);
                    $scope.getSubscriptionPlans();
                    $("#formSubscriptionPlan").hide();
                    window.scroll(0, 0);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.cancelForm = () => {
        $("#formSubscriptionPlan").hide();
    };
});
