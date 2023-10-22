app.controller("subscriptionCtrl", function ($scope, $http) {
  // $scope.subscriptionExist = false
  // $scope.subscriptionNotExist = false

  $scope.init = function () {
    $scope.getSubscriptionPlans();
    $scope.getSubscription();
  };

  $scope.togglePackage = function () {
    $scope.subscriptionExist = !$scope.subscriptionExist;
    $scope.subscriptionNotExist = !$scope.subscriptionNotExist;
  };

  $scope.selectPlan = function (p_no) {
    $(".package").find(".active").removeClass("active");
    $("#part" + p_no).addClass("active");
    $scope.subscription_plan_id = p_no;
    let plan = $scope.subscription_plans.find((p) => p.id == p_no);
    $scope.plan_amount = plan.amount;
  };
  $scope.viewSubscriptionDetail = function (subs_id) {
    $scope.detail_subscription = $scope.subscriptions.find((s) => s.id == subs_id);
    console.log(subs_id);
    console.log($scope.detail_subscription);
    $("#subscriptionDetail").modal("show");
  };

  $scope.subscribe = function () {
    console.log($scope.subscription_plan_id);
    if (!$scope.subscription_plan_id) {
      return toastr.error("Please select at least one package");
    }
    $("#cardSelectionModal").modal("show");
  };

  $scope.postSubscribe = function () {
    if (!$scope.card_id) {
      return toastr.error(
        "Please select at least one card to buy a new package"
      );
    }
    $http({
      method: "POST",
      url: "/subscriptions",
      data: {
        subscription_plan_id: $scope.subscription_plan_id,
        card_id: $scope.card_id,
      },
    }).then(
      function (response) {
        console.log(response);
        toastr.success("You have subscribed to plan successfully");
        $scope.subscriptionNotExist = false;
        $scope.subscriptionExist = true;
        // $scope.subscription = response.data.data;
        // $scope.subscriptions = response.data.data;
        $scope.init();
        $("#cardSelectionModal").modal("hide");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };
});
