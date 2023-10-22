app.controller("staffRequestsCtrl", function ($scope, $http) {
    $scope.init = function () {
        $scope.getStaffRequests();
    };

    $scope.getStaffRequests = function () {
        $http.get("/admin/get-staff-requests").then(function (response) {
            if (response.data.success) {
                $scope.staffRequests = response.data.data;
            }
        });
    };
});
