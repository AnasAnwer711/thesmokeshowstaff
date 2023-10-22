app.controller("notificationsCtrl", function ($scope, $http) {

    $scope.currentPage = 1;
    $scope.TotalRecords = 0;
    $scope.FilterRecords = 0;

    $scope.init = function () {
        $scope.url = $scope.getDecodedUrl();
        let page = $scope.url.searchParams.get("page");

        
        if(page)
            $scope.currentPage = parseInt(page)

        $scope.getAllNotifications();
    }

    $scope.getAllNotifications = function() {
        var url = $scope.getDecodedUrl();
        data = url.search;

        $http({
            method: 'GET',
            url: "/get-all-notifications/"+data,
        }).then(function(response) {
            $scope.allNotifications = response.data.data;
            $scope.TotalRecords = response.data.totalRecords;
            $scope.FilterRecords = response.data.filterRecords;
            $scope.lastPage = response.data.lastPage;
        }, function(error) {
            toastr.error(error.data.message);
        });
    };

    $scope.deleteNotification = function (notification_id) {
        bootbox.confirm({
            title: "Confirm?",
            message: "Are you sure you want to delete notification?",
            confirmationButton: false,
            closeButton: false,
            buttons: {
                confirm: {
                    label: "Yes",
                },
                cancel: {
                    label: "No",
                },
            },
            callback: function (result) {
                if (result) {
                    $http({
                        method: "delete",
                        // route('add.to.cart', $item->id)
                        url: "/notification/" + notification_id,
                    }).then(
                        function (response) {
                            $scope.getAllNotifications();
                            toastr.success('Notification has been delete successfully.');
                        },
                        function (error) {
                            toastr.error(error.data.message);
                        },
                    );
                }
            },
        });
    }

    $scope.deleteAllNotifications = function () {
        bootbox.confirm({
            title: "Confirm?",
            message: "Are you sure you want to clear all your notifications?",
            confirmationButton: false,
            closeButton: false,
            buttons: {
                confirm: {
                    label: "Yes",
                },
                cancel: {
                    label: "No",
                },
            },
            callback: function (result) {
                if (result) {
                    $http({
                        method: "delete",
                        // route('add.to.cart', $item->id)
                        url: "/delete_all_notifications",
                    }).then(
                        function (response) {
                            $scope.getAllNotifications();
                            toastr.success('Notifications section has been clear successfully.');
                        },
                        function (error) {
                            toastr.error(error.data.message);
                        },
                    );
                }
            },
        });
    }

});