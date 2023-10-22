app.controller("transactionCtrl", function ($scope, $http) {


    $scope.init = function () {
        $scope.getTransaction();
    }

    $scope.getTransaction = function () {
        $http({
            method: 'GET',
            // route('add.to.cart', $item->id)
            url: "/get_transactions",
        }).then(function(response) {
            console.log(response)
            $scope.transactions = response.data.data;

        }, function(error) {
            console.log(error);
            toastr.error(error.data.message);
        });
    }

    
});
