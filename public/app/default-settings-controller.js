app.controller("defaultSettingsCtrl", function ($scope, $http) {
    $scope.basicSettings = {};

    $scope.minutesInDay = 60 * 24;

    $scope.tabs = ["Basic Settings", "Payment Configuration", "Cancellation Policies"];

    $scope.currentTab = $scope.tabs[0];

    $scope.showTab = function (tab) {
        $scope.currentTab = tab;
    };

    $scope.selectSiteLogo = function () {
        $("#siteLogo").click();
    };

    $scope.uploadSiteLogo = function (e) {
        if (e.files.length > 0) {
            $scope.basicSettings.logo = e.files[0];
            $("#lblLogo").text(e.files[0].name);
            $("#btnRemoveLogo").show();
        }
    };

    $scope.removeSiteLogo = function () {
        $scope.logo = null;
        $("#lblLogo").text("Choose File");
        $("#btnRemoveLogo").hide();
        $scope.basicSettings.logo = null;
    };

    $scope.selectFavIcon = function () {
        $("#favIcon").click();
    };

    $scope.uploadFavIcon = function (e) {
        if (e.files.length > 0) {
            $scope.basicSettings.fav_icon = e.files[0];
            $("#lblFavIcon").text(e.files[0].name);
            $("#btnRemoveFavIcon").show();
        }
    };

    $scope.removeFavIcon = function () {
        $scope.fav = null;
        $("#lblFavIcon").text("Choose File");
        $("#btnRemoveFavIcon").hide();
        $scope.basicSettings.fav_icon = null;
    };

    $scope.selectCoverVideo = function () {
        $("#coverVideo").click();
    };

    $scope.uploadCoverVideo = function (e) {
        if (e.files.length > 0) {
            $scope.basicSettings.cover_video = e.files[0];
            $("#lblCoverVideo").text(e.files[0].name);
            $("#btnRemoveCoverVideo").show();
        }
    };

    $scope.removeCoverVideo = function () {
        $scope.cover = null;
        $("#lblCoverVideo").text("Choose File");
        $("#btnRemoveCoverVideo").hide();
        $scope.basicSettings.cover_video = null;
    };

    $scope.init = function () {
        $scope.getBasicSettings();
        $scope.getPaymentConfiguration();
        $scope.getCancellationPolicies();
        $scope.getCurrencies();
        $scope.getSocialLinks();
    };

    $scope.setBasicSettings = function () {
        if ($scope.basicSettings.logo) {
            $("#btnRemoveLogo").show();
        } else {
            $scope.removeSiteLogo();
        }

        if ($scope.basicSettings.fav_icon) {
            $("#btnRemoveFavIcon").show();
        } else {
            $scope.removeFavIcon();
        }

        if ($scope.basicSettings.cover_video) {
            $("#btnRemoveCoverVideo").show();
        } else {
            $scope.removeCoverVideo();
        }
    };

    $scope.getBasicSettings = function () {
        $http
            .get("/admin/get-basic-settings")
            .then(function (response) {
                if (response.data.success) {
                    $scope.basicSettings = response.data.data || {};
                    $scope.setBasicSettings();
                }
            })
            .catch(function (error) {
                // toastr.error(error.data.message);
                console.log(error);
            });
    };

    $scope.getPaymentConfiguration = function () {
        $http
            .get("/admin/get-payment-configuration")
            .then(function (response) {
                if (response.data.success) {
                    $scope.paymentConfiguration = response.data.data;
                }
            })
            .catch(function (error) {
                // toastr.error(error.data.message);
                console.log(error);
            });
    };

    $scope.getCancellationPolicies = function () {
        $scope
            .ajaxGet("/admin/get-cancellation-policies")
            .then(function ({ data }) {
                if (data.success) {
                    $scope.cancellationPolicies = data.data;

                    $scope.setCancellationPolicies();
                } else {
                    toastr.error(response.message);
                }
            })
            .catch(function ({ response: { data } }) {
                toastr.error(data.message);
            });
    };

    $scope.setCancellationPolicies = function () {
        $scope.cancellationPolicies = $scope.cancellationPolicies.map((policy) => {
            policy.days = parseInt(policy.duration / $scope.minutesInDay);
            policy.hours = parseInt((policy.duration - policy.days * $scope.minutesInDay) / 60);

            return policy;
        });
    };

    $scope.getCurrencies = function () {
        $scope
            .ajaxGet("/admin/get-currencies")
            .then(function ({ data }) {
                if (data.success) {
                    $scope.currencies = data.data;
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(function ({ response: { data } }) {
                toastr.error(data.message);
            });
    };

    $scope.getSocialLinks = function () {
        $scope
            .ajaxGet("/admin/get-social-links")
            .then(function ({ data }) {
                if (data.success) {
                    $scope.socialLinks = data.data;
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(function ({ response: { data } }) {
                toastr.error(data.message);
            });
    };

    $scope.saveBasicSettings = function () {
        $scope
            .ajaxPost("/admin/save-basic-settings", $scope.basicSettings)
            .then(({ data }) => {
                if (data.success) {
                    $scope.basicSettings = data.data;
                    $scope.$apply();
                    $scope.setBasicSettings();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.savePaymentConfiguration = function () {
        let data = angular.copy($scope.paymentConfiguration);

        $scope
            .ajaxPost("/admin/save-payment-configuration", data)
            .then(({ data }) => {
                if (data.success) {
                    $scope.paymentConfiguration = data.data;
                    $scope.$apply();
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.selectCurrency = function ({ id }) {
        $scope.paymentConfiguration.currency_id = id;
    };

    $scope.addCancellationPolicy = function (user_type) {
        $scope.cancellationPolicy = {
            user_type: user_type,
        };

        $("#formCancellationPolicy").show();
        $("#btnAddCancellationPolicy").hide();
    };

    $scope.editCancellationPolicy = function (policy) {
        $scope.cancellationPolicy = angular.copy(policy);

        $("#formCancellationPolicy").show();
        $("#btnAddCancellationPolicy").hide();
    };

    $scope.saveCancellationPolicy = function () {
        $scope.cancellationPolicy.duration = ($scope.cancellationPolicy.days ? $scope.cancellationPolicy.days : 0 ) * $scope.minutesInDay + ($scope.cancellationPolicy.hours ? $scope.cancellationPolicy.hours : 0) * 60;

        $scope
            .ajaxPost("/admin/save-cancellation-policy", $scope.cancellationPolicy)
            .then(({ data }) => {
                if (data.success) {
                    if ($scope.cancellationPolicy.id) {
                        $scope.cancellationPolicies = $scope.cancellationPolicies.map((cp) => (cp.id == data.data.id ? data.data : cp));
                        $scope.setCancellationPolicies();
                    } else {
                        $scope.cancellationPolicies.push(data.data);
                        $scope.setCancellationPolicies();
                    }
                    $scope.cancellationPolicy = {};
                    $("#formCancellationPolicy").hide();
                    $("#btnAddCancellationPolicy").show();
                    toastr.success(data.message);
                    $scope.$apply();
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.confirmDeleteCancellationPolicy = function (policy) {
        $scope.cancellationPolicy = angular.copy(policy);

        $("#modalDeleteCancellationPolicy").modal("show");
    };

    $scope.hideConfirmModal = function () {
        $("#modalDeleteCancellationPolicy").modal("hide");
    };

    $scope.deleteCancellationPolicy = function () {
        $scope
            .ajaxPost("/admin/delete-cancellation-policy", {
                id: $scope.cancellationPolicy.id,
            })
            .then(({ data }) => {
                if (data.success) {
                    $scope.cancellationPolicies = $scope.cancellationPolicies.filter((cp) => cp.id !== $scope.cancellationPolicy.id);
                    $scope.cancellationPolicy = {};
                    $scope.$apply();
                    $("#modalDeleteCancellationPolicy").modal("hide");
                    toastr.success(data.message);
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.cancelPolicy = function () {
        $scope.cancellationPolicy = {};
        $("#formCancellationPolicy").hide();
        $("#btnAddCancellationPolicy").show();
    };

    $scope.addSocialLink = function () {
        $scope.socialLink = {};

        $("#formSocialLink").show();
        $("#btnAddFooterLink").hide();
    };

    $scope.saveSocialLink = function () {
        $scope
            .ajaxPost("/admin/save-social-link", $scope.socialLink)
            .then(({ data }) => {
                if (data.success) {
                    if ($scope.socialLink.id) {
                        $scope.socialLinks = $scope.socialLinks.map((sl) => (sl.id == data.data.id ? data.data : sl));
                    } else {
                        $scope.socialLinks.push(data.data);
                    }
                    $scope.socialLink = {};
                    $("#formSocialLink").hide();
                    toastr.success(data.message);
                    $scope.$apply();
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.cancelSocialLink = function () {
        $scope.socialLink = {};
        $("#formSocialLink").hide();
    };

    $scope.editSocialLink = function (socialLink) {
        $scope.socialLink = angular.copy(socialLink);

        $("#formSocialLink").show();
        $("#btnAddFooterLink").hide();
    };

    $scope.confirmDeleteSocialLink = function (socialLink) {
        $scope.socialLink = angular.copy(socialLink);

        $("#modalDeleteSocialLink").modal("show");
    };

    $scope.selectSocialLinkIcon = function () {
        $("#socialLinkIcon").click();
    };

    $scope.uploadSocialLinkIcon = function (e) {
        if (e.files.length > 0) {
            $scope.socialLink.icon = e.files[0];
            $("#lblSocialLinkIcon").text(e.files[0].name);
            $("#btnRemoveSocialLinkIcon").show();
        }
    };

    $scope.removeSocialLinkIcon = function () {
        $scope.socialLinkIcon = null;
        $("#lblSocialLinkIcon").text("Choose File");
        $("#btnRemoveSocialLinkIcon").hide();
        $scope.socialLink.icon = null;
    };

    $scope.hideConfirmDeleteSocial = function () {
        $("#modalDeleteSocialLink").modal("hide");
    };

    $scope.cancelSocialLinkForm = () => {
        $scope.socialLink = {};
        $("#formSocialLink").hide();
        $("#btnAddFooterLink").show();
    };

    $scope.deleteSocialLink = function () {
        $scope
            .ajaxPost("/admin/delete-social-link", {
                id: $scope.socialLink.id,
            })
            .then(({ data }) => {
                if (data.success) {
                    $scope.socialLinks = $scope.socialLinks.filter((sl) => sl.id !== $scope.socialLink.id);
                    $scope.socialLink = {};
                    $("#modalDeleteSocialLink").modal("hide");
                    toastr.success(data.message);
                    $scope.$apply();
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };
});
