app.controller("shortlistCtrl", function ($scope, $http) {

    $scope.init = function(){
        $scope.userShortlists();
    }

    $scope.userShortlists = function () {
        $http({
            method: 'GET',
            // route('add.to.cart', $item->id)
            url: "/get_shortlists",
        }).then(function(response) {
            console.log(response)
            $scope.shortlists = response.data.data;
            // $scope.getProfileModel();

        }, function(error) {
            console.log(error);
            toastr.error(error.data.message);
        });
    }

    $scope.deleteShortlist = function(shortlist_id){
        $http({
            method: 'delete',
            // route('add.to.cart', $item->id)
            url: "/shortlists/"+shortlist_id,
        }).then(function(response) {
            $scope.userShortlists();
            toastr.success('Shortlist has been removed successfully');
            console.log(response)
        }, function(error) {
            console.log(error);
            toastr.error(error.data.message);
        });
    }
});