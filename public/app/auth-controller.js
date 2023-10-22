app.controller("authCtrl", function ($scope, $http) {
    $scope.loginForm = {};
    $scope.signupForm = {};

    $scope.init = function () {
        let referral_code = null;
        $scope.url = $scope.getDecodedUrl();
        referral_code = $scope.url.searchParams.get("referral_code");

        $scope.signupForm.referral_code = referral_code;
    }

    $scope.loginUser = function () {
        $http({
            method: "post",
            url: "/doLogin",
            data: $scope.loginForm,
        }).then(
            function (response) {
                $scope.user = response.data.data;

                let token_status = window.localStorage.getItem(
                    "firebase_token_status"
                );

                if (!token_status || token_status !== "sent") {
                    let token = window.localStorage.getItem("firebaseToken");

                    if (token) {
                        $scope.sendToken();
                    }
                }

                window.location.href = "/profile";
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            }
        );
    };

    $scope.sendToken = function () {
        $http({
            method: "post",
            url: "/addToken",
            data: {
                token: window.localStorage.getItem("firebaseToken"),
            },
        }).then(function (response) {
            if (response.data.success) {
                window.localStorage.setItem("firebase_token_status", "sent");
            }
        });
    };

    $scope.can_send_code = true; 
    $scope.stopTimer = false; 

    $scope.startTimer = function(){
        $scope.can_send_code = false;
        $scope.countDown = 60;    
        var timer = setInterval(function(){
            if(!$scope.stopTimer){
                $scope.countDown--;
                if($scope.countDown == 0){
                    $scope.endTimer();
                }
                $scope.$apply();
                console.log($scope.countDown);
            }
        }, 1000);  
    }
    $scope.endTimer = function(){
        $scope.can_send_code = true; 
        $scope.stopTimer = true;
    }

    $scope.otpSent = false;
    $scope.sendOtp = function () {
        $http({
            method: "post",
            url: "/sendOtp",
            data: {
                phone: iti.getNumber()
            },
        }).then(
            function (response) {
                console.log(response)
                if (response.data.otp) {

                    $scope.otp = response.data.otp;
                    $scope.otpSent = true;
                    $scope.stopTimer = false;
                    $scope.startTimer();
                }
                toastr.success(response.data.message);
            },
            function (error) {
                console.log(error)
                toastr.error(error.data.message);
            } 
        );
    }

    $scope.is_verified = 0;
    $scope.disablePhone = false;
    $scope.verifyCode = function () {
        if($scope.signupForm.verify_code == $scope.otp){
            $scope.is_verified = 1;
            $scope.stopTimer = true;
            toastr.success("OTP verified");
        }

    }

    $scope.registerUser = function (type) {
        console.log($scope.signupForm);
        $scope.signupForm.type = type
        $scope.signupForm.phone_sms = iti.getNumber()
        $scope.signupForm.is_verified = $scope.is_verified
        $scope.signupForm.phone_code = $('.selected_country_'+type).val()
        $http({
            method: "post",
            // route('add.to.cart', $item->id)
            url: "/doSignup",
            data: $scope.signupForm,
        }).then(
            function (response) {
                console.log(response);
                $scope.user = response.data.data;
                window.location.href = "/profile?new_signup";
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            }
        );
    };
});
