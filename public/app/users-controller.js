app.controller("usersCtrl", function ($scope, $http) {

    $scope.refineUserModel = {role: 'staff', status: 'approved'}

    
    $scope.init = function () {
        $scope.getUsers();
    };

    $scope.getUsers = function () {
        console.log($scope.refineUserModel);

        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/admin/get-users",
            params: $scope.refineUserModel,
        }).then(
            function (response) {
                console.log(response);
                $scope.users = response.data.data;
                // $("#job_tab_1-list").click();

                // $scope.initMap();
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

});
