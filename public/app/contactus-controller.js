app.controller("contactusCtrl", function ($scope, $http) {

    

    $scope.init = function () {
        $scope.contactUsModel = {'name': $scope.auth_user.name, 'email': $scope.auth_user.email,'subject': 'Contact Query', 'message': ''};
        let url = $scope.getDecodedUrl();
    
        let report = url.searchParams.get("report");

        console.log(report)

        if(report)
            $scope.getContactUsDetails(report);


    
    };

    $scope.getContactUsDetails = function (job_id) {
        $http({
          method: "get",
          // route('add.to.cart', $item->id)
          url: "/get_contactus_details/"+job_id,
        }).then(
          function (response) {
            console.log(response);

            $scope.contactUsModel.subject = response.data.data ? 'Reported-Job-'+response.data.data.id : 'Contact Query';
            $scope.contactUsModel.message = response.data.data ? 'Please explain why you are reporting '+response.data.data.title+' job: ' : '';
          },
          function (error) {
            console.log(error);
            toastr.error(error.data.message);
          }
        );
      };

    $scope.submitContactUs = function () {
        console.log($scope.contactUsModel);

        $http({
            method: "POST",
            // route('add.to.cart', $item->id)
            url: "/contactus",
            data: $scope.contactUsModel,
        }).then(
            function (response) {
                console.log(response);
                $scope.init();
                toastr.success('Your query has been submitted successfully!')
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
