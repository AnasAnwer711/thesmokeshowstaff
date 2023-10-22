app.controller("findStaffCtrl", function ($scope, $http) {

    $scope.currentPage = 1;
    $scope.TotalRecords = 0;
    $scope.FilterRecords = 0;
    $scope.searchStaffAttributes = {};
    $scope.pageSort = {};
    $scope.sortColumn = {}
    $scope.pagination = [{ page: 1 }];
    $scope.init = function () {
        $scope.url = $scope.getDecodedUrl();
        let page = $scope.url.searchParams.get("page");

        
        if(page)
            $scope.currentPage = parseInt(page)

        $scope.getStaff()
        $scope.buildTypes();
        $scope.getStates();
    }

    $scope.pageChanged = function (num) {
        $scope.pagination[0].page = num;
        $scope.pageSort = $scope.pagination;
        $scope.CustomPagingAndSort();
    };

    $scope.sort = function (col, order) {
        dir = 'asc';
        if (!order) {
            $scope.sortColumn[col.Name] = "sorting_asc";
        }
        else if (order == "sorting_asc") {
            $scope.sortColumn[col.Name] = "sorting_desc";
            dir = 'desc';
        }
        else
            $scope.sortColumn[col.Name] = "sorting_asc";
        $scope.pagination[0].colName = col.Name;
        $scope.pagination[0].direction = dir;
        $scope.pageSort = $scope.pagination;
        $scope.resetSortSigns(col.Name);
        $scope.CustomPagingAndSort();
    }
    $scope.resetSortSigns = function (Name) {
        Object.keys($scope.sortColumn)
            .filter(function (k) { if (k != Name) $scope.sortColumn[k] = "sorting" })
    }

    $scope.CustomPagingAndSort = function () {
        $scope.getStaff();
    }

    $scope.selectedSkill = function (id) {
        if( $scope.skillValues){

            var split_str = $scope.skillValues.split(",");
            if (split_str.indexOf(id.toString()) !== -1) 
                return true;
            else
                return false;
        } else
            return false;
    }

    //added in app.js
    // $scope.getDecodedUrl = function () {
    //     var url_string = window.location.href
    //     decoded = decodeURIComponent(url_string);
    //     return new URL(decoded);
    // }


    $scope.getStaff =function () {
        
        var url = $scope.getDecodedUrl();
        var sv = url.searchParams.get("skillvalues");
        $scope.selectedStateId = url.searchParams.get("state_id");

        const skillvalues = $('#skillvalues');

        // Re-converts it to a string, then affects it to the hidden input.
        skillvalues.val(sv);
        $scope.skillValues = sv;

        data = url.search;
        $http({
            method: 'POST',
            // route('add.to.cart', $item->id)
            url: "/get_staff/"+data,
            // data:data
        }).then(function(response) {
            console.log(response)
            $scope.staffs = response.data.payload;
            $scope.TotalRecords = response.data.totalRecords;
            $scope.FilterRecords = response.data.filterRecords;
            $scope.lastPage = response.data.lastPage;
            // $scope.getProfileModel();
    
        }, function(error) {
            console.log(error);
            toastr.error(error.data.message);
        });
    }

    
    $scope.setSkillValue = function (skill_id) {
    
        const skillvalues = $('#skillvalues');
        // Converts to array, because array manipulation is much easier.
        let skills = (skillvalues.val()) ? skillvalues.val().split(',') : []

        // If the clicked color is found, remove it from the array.
        if (skills.includes(skill_id.toString())) {
            skills.splice(skills.indexOf(skill_id.toString()), 1);
        } // If not, add it to the array.
        else {
            skills.push(skill_id.toString());
        }

        // Re-converts it to a string, then affects it to the hidden input.
        skillvalues.val(skills.join(','));

        $scope.searchStaffAttributes.skill_ids = skills

        console.log(skills);

        // var numbers = listOfNumbers.split(',');
        // if(numbers.indexOf(add)!=-1) {
        // numbers.push(add);
        // }
        // listOfNumbers = numbers.join(',');
        // // { ...$scope.skillModel.skill_ids, [skill_id] : true}
        // $scope.searchStaffAttributes.skill_ids = { ...$scope.searchStaffAttributes.skill_ids, [skill_id]: skill_id }  

    }

    $scope.filterStaffs = function(searchFields) {
        // console.log(searchFields);
        //ShowLoaderTb();
        // searchFields.type = $scope.params.type;
        searchFields.pageSort = $scope.pageSort;
        $http({
            method: 'POST',
            // route('add.to.cart', $item->id)
            url: "/get_staff",
            data : searchFields
        }).then(function(response) {
            console.log(response)
            $scope.staffs = response.data.data;
            // $scope.getProfileModel();
    
        }, function(error) {
            console.log(error);
            toastr.error(error.data.message);
        });
        // $scope.ajaxPost('get_staff', searchFields, true)
        //     .then(function(response) {
        //         //HideLoaderTb();
        //         if (response.success) {
        //             $scope.members = response.payload;
        //             $scope.TotalRecords = response.totalRecords;
        //         }

        //     })

    }
});
