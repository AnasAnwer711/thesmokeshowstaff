app.controller("reviewsCtrl", function ($scope, $http, $rootScope) {

    $scope.init = function () {
        $scope.myReviews();
    }

    $rootScope.myReviews = function() {
        $http({
            method: 'GET',
            url: "/my_reviews",
        }).then(function(response) {
            $scope.reviews = response.data.data.reviews;
            $scope.my_reviews = response.data.data.my_reviews;
            $scope.reviews_count = response.data.reviews_count;
            $scope.my_reviews_count = response.data.my_reviews_count;
        }, function(error) {
            toastr.error(error.data.message);
        });
    };

    $scope.deleteFeedback = function (review_id) {
        bootbox.confirm({ 
            closeButton: false,
            message: "Are you sure want to delete your review?",
            callback: function(result){ 
                /* result is a boolean; true = OK, false = Cancel*/ 
                if(result){
                    $http({
                        method: 'DELETE',
                        url: "/rating/"+review_id,
                    }).then(function(response) {
                        $scope.myReviews();
                        toastr.success('User review has been deleted successfully');

                    }, function(error) {
                        toastr.error(error.data.message);
                    });
                }
            }
        })
        
    }
});