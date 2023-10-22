app.controller("adminHelpfulKeysCtrl", function ($scope, $http) {
    $scope.init = () => {
        $scope.getHelpfulKeys();
    };

    $scope.getHelpfulKeys = () => {
        $scope
            .ajaxGet("/admin/get-helpful-keys")
            .then(({ data }) => {
                if (data.success) {
                    $scope.helpfulKeys = data.data;
                    $scope.$apply();
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.addHelpfulKey = () => {
        $scope.helpfulKey = {};
        $("#formHelpfulKey").show();
        $("#btnAddHelpfulKey").hide();
    };

    $scope.editHelpfulKey = (helpfulKey) => {
        $scope.helpfulKey = angular.copy(helpfulKey);
        $("#formHelpfulKey").show();
        $("#btnAddHelpfulKey").hide();
        window.scroll(0, 0);
    };

    $scope.confirmDeleteHelpfulKey = (helpfulKey) => {
        $scope.helpfulKey = helpfulKey;
        $("#modalDeleteHelpfulKey").modal("show");
    };

    $scope.hideConfirmModal = () => {
        $("#modalDeleteHelpfulKey").modal("hide");
        window.scroll(0, 0);
    };

    $scope.deleteHelpfulKey = () => {
        $scope
            .ajaxPost("/admin/delete-helpful-key", {
                id: $scope.helpfulKey.id,
            })
            .then(({ data }) => {
                if (data.success) {
                    toastr.success(data.message);
                    $scope.getHelpfulKeys();
                    $scope.helpfulKey = {};
                    $("#modalDeleteHelpfulKey").modal("hide");
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

    $scope.saveHelpfulKey = () => {
        $scope
            .ajaxPost("/admin/save-helpful-key", $scope.helpfulKey)
            .then(({ data }) => {
                if (data.success) {
                    toastr.success(data.message);
                    $scope.getHelpfulKeys();
                    $("#formHelpfulKey").hide();
                    window.scroll(0, 0);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.cancelForm = () => {
        $("#formHelpfulKey").hide();
        $("#btnAddHelpfulKey").show();
    };

    $scope.selectHelpfulKeyIcon = function () {
        $("#helpfulKeyIcon").click();
    };

    $scope.uploadHelpfulKeyIcon = function (e) {
        if (e.files.length > 0) {
            $scope.helpfulKey.icon = e.files[0];
            $("#lblHelpfulKeyIcon").text(e.files[0].name);
            $("#btnRemoveHelpfulKeyIcon").show();
        }
    };

    $scope.removeHelpfulKeyIcon = function () {
        $scope.helpfulKeyIcon = null;
        $("#lblHelpfulKeyIcon").text("Choose File");
        $("#btnRemoveHelpfulKeyIcon").hide();
        $scope.helpfulKey.icon = null;
    };
});
