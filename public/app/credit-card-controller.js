app.controller("creditCardCtrl", function ($scope, $http) {
    $scope.cardModel = {};
    $scope.showPaymentInfo = false;

    $scope.init = function () {
        $scope.getCard();
    };

    $scope.getCard = function () {
        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/get_cards",
        }).then(
            function (response) {
                console.log(response);
                $scope.cards = response.data.data;
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            }
        );
    };

    $scope.addCard = function () {
        $scope.showPaymentInfo = true;
    };
    $scope.toggleCardForm = function () {
        $scope.showPaymentInfo = !$scope.showPaymentInfo;
    };

    $scope.clearCard = function () {
        $scope.showPaymentInfo = false;
        $scope.cardModel = {};
    };

    $scope.saveCard = function () {
        console.log($scope.cardModel);
        $http({
            method: "POST",
            // route('add.to.cart', $item->id)
            url: "/credit_card",
            data: $scope.cardModel,
        }).then(
            function (response) {
                console.log(response);
                $scope.init();
                $scope.clearCard();
                toastr.success(
                    "Your card has been added and charged successfully"
                );
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            }
        );
    };

    $scope.removeCard = function (card_id) {
        $http({
            method: "delete",
            url: "/credit_card/" + card_id,
        }).then(
            function (response) {
                $scope.init();
                toastr.success("Card has been removed successfully");
                console.log(response);
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            }
        );
    };
});
