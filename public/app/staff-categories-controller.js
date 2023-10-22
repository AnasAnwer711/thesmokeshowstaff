app.controller("staffCategoriesCtrl", function ($scope, $http) {
  $scope.currentPage = 1;
  $scope.lastPage = 1;
  $scope.selected_category_has_gender = true;

  $scope.init = function () {
    $scope.url = $scope.getDecodedUrl();
    let page = $scope.url.searchParams.get("page");

    if (page) $scope.currentPage = parseInt(page);

    $scope.getStaffCategories();
    $scope.getCategories();
    $scope.getHelpfulKeys();
  };

  $scope.getStaffCategories = function () {
    $scope
      .ajaxGet("/admin/get-staff-categories", { page: $scope.currentPage })
      .then(function ({ data }) {
        if (data.success) {
          $scope.staffCategories = data.data.categories;
          $scope.TotalRecords = data.data.totalRecords;
          $scope.lastPage = data.data.lastPage;
          $scope.$apply();
        }
      })
      .catch(function (error) {
        toastr.error(error);
      });
  };

  $scope.getCategories = function () {
    $scope
      .ajaxGet("/admin/get-categories")
      .then(function ({ data }) {
        if (data.success) {
          $scope.categories = data.data;
        }
      })
      .catch(function (error) {
        console.log(error);
      });
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

  $scope.addStaffCategory = function () {
    $scope.selectedCategory = {};
    $scope.staffCategory = {};

    $("#formStaffCategory").show();
    $("#btnAddStaffCategory").hide();
  };

  $scope.cancelForm = function () {
    $scope.selectedCategory = {};
    $scope.staffCategory = {};
    $("#formStaffCategory").hide();
    $("#btnAddStaffCategory").show();
  };

  $scope.editStaffCategory = function (category) {
    $scope.selectedCategory = {};
    $scope.staffCategory = angular.copy(category);

    if ($scope.staffCategory.category_id) {
      $scope.selectedCategory = $scope.categories.filter(
        (c) => c.id === $scope.staffCategory.category_id
      )[0];
      $scope.staffCategory.category_id = $scope.selectedCategory.id;
    }

    $("#formStaffCategory").show();
    $("#btnAddStaffCategory").hide();
    window.scroll(0, 0);
  };

  $scope.selectCategory = function () {
    if ($scope.staffCategory.category_id) {
      $scope.selectedCategory = $scope.categories.filter(
        (c) => c.id === $scope.staffCategory.category_id
      )[0];
      $scope.staffCategory.min_rate = $scope.selectedCategory.min_rate;
    } else {
      $scope.staffCategory.category_id = null;
      $scope.selectedCategory = {};
    }

    //temp purpose
    if ($scope.selectedCategory && $scope.selectedCategory.id) {
      $scope.selected_category_has_gender = !!$scope.selectedCategory.gender;

      if ($scope.selected_category_has_gender) {
        $scope.staffCategory.gender = $scope.selectedCategory.gender;
        setTimeout(() => $scope.$apply(), 1000);
      } else {
        $scope.staffCategory.gender = "";
      }

      return $scope.selected_category_has_gender;
    }
  };

  $scope.selectHelpfulKey = () => {
    if ($scope.staffCategory.helpful_key_id) {
      $scope.selectedHelpfulKey = $scope.helpfulKeys.filter(
        (c) => c.id === $scope.staffCategory.helpful_key_id
      )[0];
      // $scope.staffCategory.helpful_key = $scope.selectedHelpfulKey.id;
    } else {
      $scope.staffCategory.helpful_key = null;
      $scope.selectedHelpfulKey = {};
    }
  };

  $scope.saveStaffCategory = function () {
    if ($scope.staffCategory.category_id) {
      $scope.staffCategory.gender = $scope.selectedCategory.gender;
    }

    $scope
      .ajaxPost("/admin/save-staff-category", $scope.staffCategory)
      .then(function ({ data }) {
        if (data.success) {
          $scope.staffCategory = {};
          $("#formStaffCategory").hide();
          $("#btnAddStaffCategory").show();
          toastr.success(data.message);
          $scope.getStaffCategories();
          $scope.selectedCategory = {};
          window.scroll(0, 0);
        }
      })
      .catch(function ({ response: { data } }) {
        toastr.error(data.message);
      });
  };

  // $scope.isGenderDisabled = function () {
  //   if ($scope.selectedCategory && $scope.selectedCategory.id) {
  //     let selected_category_has_gender = !!$scope.selectedCategory.gender;

  //     if (selected_category_has_gender) {
  //       $scope.staffCategory.gender = $scope.selectedCategory.gender;
  //       setTimeout(() => $scope.$apply(), 1000);
  //     } else {
  //       $scope.staffCategory.gender = "";
  //     }

  //     return selected_category_has_gender;
  //   }

  //   return false;
  // };

  $scope.confirmDeleteStaffCategory = function (category) {
    $scope.staffCategory = angular.copy(category);
    $("#modalDeleteStaffCategory").modal("show");
  };

  $scope.hideConfirmModal = function () {
    $("#modalDeleteStaffCategory").modal("hide");
  };

  $scope.deleteStaffCategory = function () {
    $scope
      .ajaxPost("/admin/delete-staff-category", {
        id: $scope.staffCategory.id,
      })
      .then(function ({ data }) {
        if (data.success) {
          $scope.staffCategory = {};
          $("#modalDeleteStaffCategory").modal("hide");
          toastr.success(data.message);
          $scope.getStaffCategories();
          $scope.selectedCategory = {};
          $("#formStaffCategory").hide();
          $("#btnAddStaffCategory").show();
          window.scroll(0, 0);
        }
      })
      .catch(function ({ response: { data } }) {
        toastr.error(data.message);
      });
  };

  $scope.previousPage = function () {
    var page = $scope.url.searchParams.get("page");

    let urlParams = new URLSearchParams(location.search);
    if (page > 1) {
      urlParams.delete("page");
      urlParams.set("page", parseInt(page) - 1);
    }
    // urlParams.set(key, value);
    location.search = urlParams.toString();
  };

  $scope.nextPage = function () {
    var page = $scope.url.searchParams.get("page");

    let urlParams = new URLSearchParams(location.search);
    if (page) {
      urlParams.delete("page");
      urlParams.set("page", parseInt(page) + 1);
    } else {
      urlParams.set("page", 2);
    }
    // urlParams.set(key, value);
    location.search = urlParams.toString();
  };

  $scope.goToPage = function (page_no) {
    let urlParams = new URLSearchParams(location.search);

    urlParams.delete("page");
    urlParams.set("page", parseInt(page_no));

    location.search = urlParams.toString();
  };
});
