app.controller("jobCtrl", function ($scope, $http, $location) {
    $scope.jobForm = { address: {}, min_rate_applicable: false };
    $scope.refineModel = {};

    $scope.edit = true;
    $scope.view_job = false;
    $scope.inquiry_message = "";

    if ($location.absUrl().indexOf("create") > -1) {
        $scope.edit = false;
    }
    $scope.init = function () {
        $scope.staffCategories();
        $scope.travelAllowances();
        $scope.getStates();
    };

    // Get User Jobs
    $scope.getUserJobs = function () {
        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/get_user_jobs",
        }).then(
            function (response) {
                console.log(response);
                $scope.jobs = response.data.data;
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.filterJobs = function (searchFields) {
        console.log(searchFields);

        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/get_jobs",
            params: searchFields,
        }).then(
            function (response) {
                console.log(response);
                $scope.jobs = response.data.data;
                $("#job_tab_1-list").click();

                $scope.initMap();
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    // Get ALL Jobs
    $scope.getJobs = function () {
        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/get_jobs",
        }).then(
            function (response) {
                console.log(response);
                $scope.jobs = response.data.data;
                $scope.initMap();
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    // Get ALL Jobs
    $scope.getShortlists = function () {
        $http({
            method: "GET",
            // route('add.to.cart', $item->id)
            url: "/get_shortlists",
        }).then(
            function (response) {
                console.log(response);
                $scope.shortlists = response.data.data;
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    // Get Single Job
    $scope.getJob = function (job_id) {
        console.log($scope.jobForm);
        $http({
            method: "get",
            // route('add.to.cart', $item->id)
            url: "/get_job/" + job_id,
        }).then(
            function (response) {
                console.log(response);
                $scope.job = response.data.data;

                $scope.jobForm = response.data.data;

                $scope.jobForm.date = $scope.convertUtcToLocalDate($scope.jobForm.date);
                $scope.jobForm.start_time = $scope.convertUtcToLocalDateTime($scope.jobForm.start_time);
                $scope.jobForm.end_time = $scope.convertUtcToLocalDateTime($scope.jobForm.end_time);

                $scope.jobForm.date = new Date($scope.jobForm.date);
                $scope.jobForm.start_time = new Date($scope.jobForm.start_time);
                $scope.jobForm.end_time = new Date($scope.jobForm.end_time);
                $scope.getJobTitle($scope.job.staff_category_id);
                // $scope.jobForm.date
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.postJob = function () {
        console.log($scope.jobForm);

        $scope.jobForm.date = moment($scope.jobForm.date).format("YYYY-MM-DD");
        if ($location.absUrl().indexOf("duplicate_job") > -1) {
            $scope.edit = false;
        }
        let postUrl = $scope.edit ? "/job/" + $scope.job.id : "/job";
        let postMethod = $scope.edit ? "PATCH" : "POST";
        $http({
            method: postMethod,
            // route('add.to.cart', $item->id)
            url: postUrl,
            data: $scope.jobForm,
        }).then(
            function (response) {
                console.log(response);
                $scope.job = response.data.data;
                addActiveClass($scope.next_fs, $scope.current_fs);
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.viewJob = function (job_id) {
        console.log($scope.jobForm);
        $http({
            method: "get",
            // route('add.to.cart', $item->id)
            url: "/get_job/" + job_id,
        }).then(
            function (response) {
                console.log(response);
                $scope.job = response.data.data;
                $scope.initJobMap();
            },
            function (error) {
                console.log(error);
                toastr.error(error.data.message);
            },
        );
    };

    $scope.deleteJob = function (job_id) {
        console.log($scope.jobForm);
        let find_job = $scope.jobs.find((j) => j.id == job_id);
        console.log(find_job);
        let message = "Are you sure you want to job?";
        if (find_job.occupied_positions > 0) message += "</br> You already have " + find_job.occupied_positions + " occupied positions. By doing this you will not get refund of those deducted fees";
        bootbox.confirm({
            title: "Confirm?",
            message: message,
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
                        url: "/job/" + job_id,
                    }).then(
                        function (response) {
                            $scope.getUserJobs();
                            toastr.success("Job has been deleted successfully");
                            console.log(response);
                        },
                        function (error) {
                            console.log(error);
                            toastr.error(error.data.message);
                        },
                    );
                }
            },
        });
    };

    $scope.contactReport = function (job_id) {
        window.location.href = "/contactus?report=" + job_id;
    };

    $scope.changeJobStatus = function (job_id, status) {
        message = "Are you sure you want to un-publish this job?";
        successMsg = "Your job has been un-published successfully.";
        if (!status) {
            successMsg = "Your job has been published successfully.";
            message = "Please check your details are correct before publishing.";
        }

        bootbox.confirm({
            message: message,
            closeButton: false,
            callback: function (result) {
                if (result) {
                    $http({
                        method: "POST",
                        url: "/change_job_status/" + job_id,
                    }).then(
                        function (response) {
                            $scope.getUserJobs();
                            toastr.success(successMsg);
                            console.log(response);
                        },
                        function (error) {
                            console.log(error);
                            toastr.error(error.data.message);
                        },
                    );
                }
            },
        });
    };

    $scope.getJobTitle = function (category_id) {
        $scope.job_titles = $scope.staff_categories.find((sc) => sc.id == category_id).sub_categories;
    };

    $scope.setMinRate = function (title) {
        $scope.pay_rate = $scope.job_titles.find((jt) => jt.title == title).min_rate;
        if ($scope.pay_rate) $scope.jobForm.min_rate_applicable = true;
        else $scope.jobForm.min_rate_applicable = false;
        $scope.jobForm.min_rate = $scope.pay_rate;
    };

    $scope.setEndTime = function () {
        if ($scope.jobForm.duration && $scope.jobForm.start_time) {
            console.log($scope.jobForm.start_time);
            let start_time = $scope.jobForm.start_time;
            let duration = parseInt($scope.jobForm.duration);

            let dt = new Date($scope.jobForm.start_time);
            dt.setHours(dt.getHours() + duration);

            $scope.jobForm.end_time = new Date(dt);
        } else $scope.jobForm.end_time = null;
    };

    $scope.initMap = function () {
        console.log($scope.jobs);

        if ($scope.jobs) {
            // let address = $scope.jobs.address
            let lats = $scope.jobs.map((job) => job.address.latitude);
            let longs = $scope.jobs.map((job) => job.address.longitude);
            let jobs = $scope.jobs;

            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 3,
                center: new google.maps.LatLng(62.39, -96.81),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < lats.length; i++) {
                var node = document.createElement("div"),
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(lats[i], longs[i]),
                        map: map,
                        content: node,
                        icon: "/images/icon.png",
                    });
                let pay_type = jobs[i].pay_type == "per_party" ? "Per Party" : "Per Hour";
                let job_date = $scope.convertUtcToLocalDate(jobs[i].date);
                node.innerHTML =
                    '<div class="gm-style-iw-d" style="overflow: scroll; max-height: 188px;">' +
                    "<div>" +
                    '<div class="noscroll job-marker">' +
                    '<div class="budget">$' +
                    jobs[i].pay_rate +
                    " <span>" +
                    pay_type +
                    "</span></div>" +
                    "<hr>" +
                    '<div class="date">' +
                    job_date +
                    "</div>" +
                    '<div class="event-name">' +
                    jobs[i].job_title +
                    "</div>" +
                    '<div class="job-title">' +
                    jobs[i].staff_category.title +
                    "</div>" +
                    '<div class="location">' +
                    jobs[i].address.address_line1 +
                    "</div>" +
                    '<div class="position">' +
                    (jobs[i].no_of_positions - jobs[i].occupied_positions) +
                    "/" +
                    jobs[i].no_of_positions +
                    " Positions Available</div>" +
                    '<div class="more"><a onclick="openMarkerJob(24559)" href="javascript:void(0)" tabindex="0">Read more</a></div>' +
                    "</div>" +
                    "</div>" +
                    "</div>";

                google.maps.event.addListener(
                    marker,
                    "click",
                    (function (marker, i) {
                        return function () {
                            // infowindow.setContent(locations[i][0]);
                            infowindow.setContent(this.get("content"));
                            infowindow.open(map, marker);
                        };
                    })(marker, i),
                );
            }
        }
    };

    $scope.initJobMap = function () {
        if ($scope.job || $scope.selected_job) {
            // let address = $scope.jobs.address
            let job = $scope.job || $scope.selected_job;
            let latitude = job.address.latitude;
            let longitude = job.address.longitude;

            var map = new google.maps.Map(document.getElementById("map"), {
                zoom: 6,
                center: new google.maps.LatLng(latitude, longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            // for (i = 0; i < lats.length; i++) {
            var node = document.createElement("div"),
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(latitude, longitude),
                    map: map,
                    content: node,
                    icon: "/images/icon.png",
                });
            let pay_type = job.pay_type == "per_party" ? "Per Party" : "Per Hour";
            let job_date = $scope.convertUtcToLocalDate(job.date);
            node.innerHTML =
                '<div class="gm-style-iw-d" style="overflow: scroll; max-height: 188px;">' +
                "<div>" +
                '<div class="noscroll job-marker">' +
                '<div class="budget">$' +
                job.pay_rate +
                " <span>" +
                pay_type +
                "</span></div>" +
                "<hr>" +
                '<div class="date">' +
                job_date +
                "</div>" +
                '<div class="event-name">' +
                job.job_title +
                "</div>" +
                '<div class="job-title">' +
                job.staff_category.title +
                "</div>" +
                '<div class="location">' +
                job.address.address_line1 +
                "</div>" +
                '<div class="position">' +
                (job.no_of_positions - job.occupied_positions) +
                "/" +
                job.no_of_positions +
                " Positions Available</div>" +
                '<div class="more"><a onclick="openMarkerJob(24559)" href="javascript:void(0)" tabindex="0">Read more</a></div>' +
                "</div>" +
                "</div>" +
                "</div>";

            google.maps.event.addListener(
                marker,
                "click",
                (function (marker, i) {
                    return function () {
                        // infowindow.setContent(locations[i][0]);
                        infowindow.setContent(this.get("content"));
                        infowindow.open(map, marker);
                    };
                })(marker, i),
            );
            // }
        }
    };

    $scope.selectedJob = function (job_id) {
        console.log(job_id);
        $scope.selected_job = $scope.jobs.find((job) => job.id == job_id);
        $scope.initJobMap();
        $(".solution_cards_box").find(".selected-card").removeClass("selected-card");
        $(".card-" + job_id).addClass("selected-card");
        $(".job-detail-card").css("display", "block");
    };

    $scope.showSelectedJobCard = function (job_id) {
        $scope.selected_job = $scope.jobs.find((job) => job.id == job_id);
        $scope.selected_job.applicant_users = $scope.selected_job.applicant_users.filter((a) => a.pivot.current_status !== "booked");

        $scope.view_job = true;

        $scope.calculateEarnings();
    };

    $scope.calculateEarnings = function () {
        $scope.earnings = [];

        let rate = $scope.payment_configuration.host_transaction_fee;
        $scope.total_earnings = 0;

        if ($scope.payment_configuration.host_transaction_type == "percentage") {
            rate = ($scope.selected_job.pay_rate * $scope.payment_configuration.host_transaction_fee) / 100;
        }

        $scope.earnings.push({
            name: $scope.selected_job.user.name,
            type: "Hirestaff",
            payment_status: "Paid",
            total: $scope.selected_job.booked.reduce((a, b) => parseInt(a) + parseInt(b.host_fee), 0),
        });

        $scope.selected_job.booked.map((applicant) => {
            let rate = $scope.payment_configuration.staff_transaction_fee;
            $scope.total_earnings = 0;

            if ($scope.payment_configuration.staff_transaction_type == "percentage") {
                rate = (applicant.job_pay * $scope.payment_configuration.staff_transaction_fee) / 100;
            }

            $scope.earnings.push({
                name: applicant.staff.name,
                type: "Staff",
                payment_status: "Pending",
                total: rate,
            });
        });

        $scope.earnings.map((earning) => {
            $scope.total_earnings += earning.total;
        });
    };

    $scope.hideSelectedJobCard = function () {
        $scope.view_job = false;
    };

    $scope.selectedJob = function (job_id) {
        console.log(job_id);
        $scope.selected_job = $scope.jobs.find((job) => job.id == job_id);
        $scope.initJobMap();
        $(".solution_cards_box").find(".selected-card").removeClass("selected-card");
        $(".card-" + job_id).addClass("selected-card");
        $(".job-detail-card").css("display", "block");
    };

    // $scope.showSelectedJobCard = function (job_id) {
    //     $scope.selected_job = $scope.jobs.find((job) => job.id == job_id);

    //     $scope.view_job = true;
    // };

    $scope.hideSelectedJobCard = function () {
        $scope.view_job = false;
    };

    $scope.markCompleted = function () {
        bootbox.confirm({
            title: "Confirm?",
            confirmationButton: false,
            closeButton: false,
            message: "Are you sure you want to mark this job as completed?",
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
                        method: "POST",
                        url: "/admin/jobs/mark-completed",
                        data: {
                            job_id: $scope.selected_job.id,
                        },
                    })
                        .then(function (response) {
                            if (response.data.success) {
                                toastr.success(response.data.message);
                                $scope.selected_job.status = "completed";
                                $scope.jobs = $scope.jobs.map((j) => (response.data.data.id == j.id ? response.data.data : j));
                                $scope.hideSelectedJobCard();
                            }
                        })
                        .catch(function (error) {
                            toastr.error(error.data.message);
                        });
                }
            },
        });
    };

    $scope.noShow = function () {
        // $scope.selected_job.booked_applicants = $scope.selected_job.booked_applicants.filter((ba) => ba.id !== id);

        // $scope.jobs = $scope.jobs.map((j) => (j.id == $scope.selected_job.id ? $scope.selected_job : j));
        $scope
            .ajaxPost("/admin/change_job_application_status", {
                job_applicant_id: $scope.selected_staff.id,
                status: "unbooked",
                action_by: $scope.selected_staff.staff.id,
                rule_type: "no-show",
            })
            .then((response) => {
                if (response.data.success) {
                    $scope.selected_job.booked_applicants = $scope.selected_job.booked_applicants.filter((ba) => ba.id !== $scope.selected_staff.id);

                    $scope.jobs = $scope.jobs.map((j) => (j.id == $scope.selected_job.id ? $scope.selected_job : j));
                    $scope.hideNoShowModal();
                    $scope.$apply();
                }
            })
            .catch((error) => {
                console.log(error);
            });
    };

    $scope.markClose = function () {
        $http({
            method: "POST",
            url: "/admin/jobs/mark-close",
            data: {
                job_id: $scope.selected_job.id,
            },
        })
            .then(function (response) {
                if (response.data.success) {
                    toastr.success(response.data.message);
                    $scope.selected_job.status = "completed";
                    $scope.jobs = $scope.jobs.filter((j) => response.data.data.id != j.id);
                    $scope.hideCloseModal();
                    $scope.view_job = false;
                }
            })
            .catch(function (error) {
                toastr.error(error.data.message);
            });
    };

    $scope.confirmClose = function () {
        $scope.closeForm = {};
        $scope.closeForm.option = "complete";
        $("#confirmCloseModal").modal("show");
    };

    $scope.hideCloseModal = function () {
        $("#confirmCloseModal").modal("hide");
    };

    $scope.selectOption = function (option) {
        $scope.closeForm.option = option;
    };

    $scope.sendInquiry = function () {
        $("#messageForm").show();
        $("#messageBtn").hide();

        $scope.inquiry_message = "";
    };

    $scope.sendMessage = function () {
        $scope
            .ajaxPost("/send-inquiry", {
                job_id: $scope.selected_job.id,
                message: $scope.inquiry_message,
            })
            .then(({ data }) => {
                if (data.success) {
                    toastr.success(data.message);
                    $scope.message = "";
                    $("#messageForm").hide();
                    $("#messageBtn").show();
                }
            })
            .catch(({ response: { data } }) => {
                toastr.error(data.message);
            });
    };

    $scope.toggleallSkill = function () {
        $(".all_skills").toggle();
        $(".dd-icon").toggleClass("icofont-caret-up icofont-caret-down");
    };

    $scope.showNoShowModal = function (user) {
        $scope.selected_staff = user;
        $("#confirmNoShowModal").modal("show");
    };

    $scope.hideNoShowModal = function () {
        $("#confirmNoShowModal").modal("hide");
    };

    $scope.showMessages = () => {
        window.location = "/admin/messages?job_id=" + $scope.selected_job.id;
    };
});
