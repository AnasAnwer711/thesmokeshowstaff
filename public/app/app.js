var app = angular
  .module("showstaff", ["angular.filter"])
  .config(function ($interpolateProvider) {
    $interpolateProvider.startSymbol("[[");
    $interpolateProvider.endSymbol("]]");
  })

  .directive("loading", [
    "$http",
    function ($http) {
      return {
        restrict: "A",
        link: function (scope, elm, attrs) {
          scope.isLoading = function () {
            return $http.pendingRequests.length > 0;
          };

          scope.$watch(scope.isLoading, function (v) {
            if (v) {
              $("body").css({ overflow: "hidden" });
              elm.show();
            } else {
              $("body").css({ overflow: "inherit" });
              elm.hide();
            }
          });
        },
      };
    },
  ])

  // .directive('loading', function ()
  // {
  //     return {
  //         restrict: 'E',
  //         replace:true,
  //         // template: '<div class="loading"><img src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif" width="20" height="20" />LOADING...</div>',
  //         template: '<div class="loader"><div class="iner-div"><img src="/images/loader.gif"></div></div>',
  //         link: function (scope, element, attr) {
  //             scope.$watch('loading', function (val) {
  //                 if (val){

  //                     $("body").css({"overflow":"hidden"});

  //                     $(element).show();
  //                 } else{

  //                     $("body").css({"overflow":"inherit"});
  //                     $(element).hide();
  //                 }

  //             });
  //         }
  //     };

  // })

  .controller("baseCtrl", function ($scope, $rootScope, $http, $filter) {
    $scope.message_interval = null;
    $scope.message_count = null;
    $scope.notification_count = null;
    $scope.auth_user = {};
    // $scope.loading = true;

    //set false on request success
    // $scope.loading = false;

    // notificationshow func
    $scope.unRead = "";
    let first_notify = 1;

    $scope.getMessageCount = () => {
      if (!$scope.message_interval) {
        clearInterval($scope.message_interval);
        return;
      }

      $scope
        .ajaxGet("/get-message-count")
        .then(({ data: { data } }) => {
          if(data){
            
            if (
              $scope.message_count != null &&
              $scope.message_count < data.count
            ) {
              $scope.message_count = data.count;
              if (
                !window.location.pathname.includes("/messages") &&
                !window.location.pathname.includes("/invitations") &&
                !window.location.pathname.includes("/find_staff")
              ) {
                toastr.info("You have new message");
                $(".unread-message-dot").show();
                $scope.$apply();
              } else {
                let sc = angular.element("#chatScope").scope();
                sc.loadChats(false);
              }
            } else {
              $scope.message_count = data.count;
            }
            if ($scope.notification_count < data.notification.count) {
              $scope.notification_count = data.notification.count;
              if(!first_notify){
                toastr.info("You have new notification");
                $scope.unRead = "unread-notification";
              }
              first_notify = 0;
  
              $scope.$apply();
            } else {
              $scope.notification_count = data.notification.count;
            }
            $scope.notifications = data.notification.data;
          } else {
            first_notify = 0;
          }
        })
        .catch((response) => {
          console.log(response);
        });
    };

    // notificationshow func
    $scope.getNotificationCount = () => {
      if (!$scope.notification_interval) {
        clearInterval(notification_interval);
        return;
      }
      $scope
        .ajaxGet("/get-notification-count")
        .then(({ data: { data } }) => {
          console.log(data);
          $scope.notification_count = data.count;
          $scope.notifications = data.data;
          // if (!!$scope.message_count && $scope.message_count < data.count) {
          //   $scope.message_count = data.count;
          //   if (!window.location.pathname.includes("/messages") || !window.location.pathname.includes("/invitations")) {
          //     toastr.info("You have new message");

          //     $scope.$apply();
          //   } else {
          //     let sc = angular.element("#chatScope").scope();
          //     sc.loadChats(false);
          //   }
          // } else {
          //   $scope.message_count = data.count;
          // }
        })
        .catch(({ response: { data } }) => {
          console.log(data.message);
        });

      // $http({
      //   method: "GET",
      //   url: "/get-notification-count",
      // }).then(
      //   function (response) {
      //     $scope.notification_count = response.data.data;
      //     // console.log($scope.auth_user)
      //   },
      //   function (error) {
      //     console.log(error.data.message);
      //     // toastr.error(error);
      //   }
      // );
    };

    $scope.showNotification = function () {
      $(".notification-ui_dd").toggle();
    };
    $scope.showMblMenu = function () {
      $("#menuToggle").toggleClass("elementor-active");
    };
    $scope.ajaxPost = function (url, data, headers = {}) {
      let form_data = new FormData();

      for (let key in data) {
        if (!data[key]) continue;
        if (data[key] instanceof File) {
          form_data.append(key, data[key]);
        } else {
          form_data.append(key, data[key]);
        }
      }

      return window.axios.post(url, form_data, {
        headers: {
          "Content-Type": "multipart/form-data",
          ...headers,
        },
      });
    };

    $scope.ajaxGet = function (url, data = {}, headers = {}) {
      return window.axios.get(
        url,
        { params: data },
        {
          headers: {
            ...headers,
          },
        }
      );
    };

    $scope.getDecodedUrl = function () {
      var url_string = window.location.href;
      decoded = decodeURIComponent(url_string);
      return new URL(decoded);
    };

    $scope.getAuthUser = function () {
      $scope.auth_user = JSON.parse(window.localStorage.getItem("auth_user"));
      $http({
        method: "GET",
        url: "/get_profile",
      }).then(
        function (response) {
          $scope.auth_user = response.data.data;
          window.localStorage.setItem(
            "auth_user",
            JSON.stringify(response.data.data)
          );

          // start long polling for messages
          $scope.message_interval = setInterval($scope.getMessageCount, 5000);
        },
        function (error) {
          console.log(error.data.message);
          if ($scope.message_interval) {
            clearInterval($scope.message_interval);
          }
          window.localStorage.removeItem("auth_user");
        }
      );
    };

    $scope.paymentConfiguration = function () {
      $http({
        method: "GET",
        url: "/payment_configuration",
      }).then(
        function (response) {
          $scope.payment_configuration = response.data.data;
        },
        function (error) {
          console.log(error.data.message);
          // toastr.error(error);
        }
      );
    };

    $scope.basicSetting = function () {
      $http({
        method: "GET",
        url: "/basic_setting",
      }).then(
        function (response) {
          $scope.basic_setting = response.data.data;
          if ($scope.basic_setting && $scope.basic_setting.name)
            domain_name = $scope.basic_setting.name;
        },
        function (error) {
          console.log(error.data.message);
        }
      );
    };
    
    $scope.languages = function () {
      $http({
        method: "GET",
        url: "/languages",
      }).then(
        function (response) {
          $scope.languages = response.data.data;
          
        },
        function (error) {
          console.log(error.data.message);
        }
      );
    };

    $scope.getCancellationPolicy = function (user_type) {
      $http({
        method: "GET",
        url: "/get_cancellation_policy/" + user_type,
      }).then(
        function (response) {
          $scope.cancellation_policy = response.data.data;

          if ($scope.cancellation_policy) {
            $scope.message +=
              "<div style='display:grid; color:red;'><span><strong>Please be aware of the Cancellation Policy as below:</strong></span>";
            for (var i = 0; i < $scope.cancellation_policy.length; i++) {
              if ($scope.cancellation_policy[i].rule_type == "cancel")
                $scope.message +=
                  "<span>Cancel within " +
                  $scope.convertMinutesToHourOrDays(
                    $scope.cancellation_policy[i].duration
                  ) +
                  " of the job start = $" +
                  $scope.cancellation_policy[i].charges +
                  " penalty</span>";
              if ($scope.cancellation_policy[i].rule_type == "no-show")
                $scope.message +=
                  "<span>No Show - (Don't show up) = $" +
                  $scope.cancellation_policy[i].charges +
                  " penalty</span>";
            }
            // $scope.message += "<span>Cancel within 14 days of the job start = $5 penalty</span>"
            // $scope.message += "<span>Cancel within 72 hours of the job start = $80 penalty</span>"
            // $scope.message += "<span>No Show - (Don't show up) = $100 penalty</span>"
            let max_duration = Math.max(
              ...$scope.cancellation_policy.map((cp) => cp.duration)
            );
            $scope.message +=
              "<br/><span>Outside of " +
              $scope.convertMinutesToHourOrDays(max_duration) +
              " there are no cancel fees.</span></div>";
          }
        },
        function (error) {
          console.log(error.data.message);
        }
      );
    };

    $scope.loadEntityTypes = function () {
      $http({
        method: "GET",
        url: "/entity_types",
      }).then(
        function (response) {
          $scope.entity_types = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.getStates = function () {
      $http({
        method: "GET",
        url: "/states",
      }).then(
        function (response) {
          $scope.states = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.getStateId = function (abbreviation) {
      let s_id = $scope.states.find((s) => s.abbreviation == abbreviation).id;
      $scope.selectedStateId = s_id;
      return s_id;
    };

    $scope.nationalities = function () {
      $http({
        method: "GET",
        url: "/nationalities",
      }).then(
        function (response) {
          $scope.nationalities = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.buildTypes = function () {
      $http({
        method: "GET",
        url: "/build_types",
      }).then(
        function (response) {
          $scope.build_types = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.staffCategories = function () {
      $http({
        method: "GET",
        url: "/staff_categories",
      }).then(
        function (response) {
          $scope.staff_categories = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.staffCategories();

    $scope.travelAllowances = function () {
      $http({
        method: "GET",
        url: "/travel_allowances",
      }).then(
        function (response) {
          $scope.travel_allowances = response.data.data;
        },
        function (error) {
          toastr.error(error.data.message);
        }
      );
    };

    $scope.convertUtcToLocalDateTime = function (dt) {
      let date = moment.utc().format(dt);
      let dateUtc = moment.utc(date).toDate();
      let convertedDateTime = moment(dateUtc)
        .local()
        .format("YYYY-MM-DDTHH:mm:ss");
      return convertedDateTime;
    };
    $scope.convertUtcToLocalDate = function (dt) {
      let date = moment.utc().format(dt);
      let dateUtc = moment.utc(date).toDate();
      let convertedDateTime = moment(dateUtc).local().format("MM/DD/YYYY");
      return convertedDateTime;
    };
    $scope.convertUtcToLocalMonthDate = function (dt) {
      let date = moment.utc().format(dt);
      let dateUtc = moment.utc(date).toDate();
      let convertedDateTime = moment(dateUtc).local().format("MMMM DD");
      return convertedDateTime;
    };
    $scope.convertUtcToLocalTime = function (dt) {
      let date = moment.utc().format(dt);
      let dateUtc = moment.utc(date).toDate();
      let convertedDateTime = moment(dateUtc).local().format("hh:mm A");
      return convertedDateTime;
    };
    $scope.convertMinutesToHourOrDays = function (duration) {
      let min = moment.duration(duration, "minutes");
      if (min.days() > 3 || min.asHours() > 72) {
        return min.days() + " days";
      } else {
        return min.asHours() + " hours";
      }
    };

    $scope.addToShortList = function (target, type) {
      let target_id = target.id;
      if (type == "job") successMsg = "Job has been added to shortlist";
      else successMsg = "Staff has been added to shortlist";

      $http({
        method: "POST",
        // route('add.to.cart', $item->id)
        url: "/shortlists",
        data: { target_id: target_id, type: type },
      }).then(
        function (response) {
          $scope.user = response.data.data;
          target.is_shortlisted = true;
          // $('.shortlistText'+target_id).text('ADDED TO SHORTLIST');
          toastr.success(successMsg);
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    let domain_name = "The Smoke Show Staff";
    $scope.invitationConfirmation = function (source, type) {
      // message = "If staff accepts your invitation, you will be charged the $35 PartiStaff booking fee"
      let host_transaction_fee = 0;

      if (
        $scope.payment_configuration &&
        $scope.payment_configuration.host_transaction_fee
      )
        host_transaction_fee =
          $scope.payment_configuration.host_transaction_fee;

      if (type == "invite") {
        let user_name = "staff";

        if (source.name) user_name = source.name;
        title = "Job Invitation";
        if ($scope.auth_user.cards && $scope.auth_user.cards.length > 0) {
          if ($scope.auth_user.active_jobs && $scope.auth_user.active_jobs.length > 0) {
            $scope
              .ajaxGet("/get_applicant_job_ids/" + source.id)
              .then(({ data: { data } }) => {
                $scope.applicant_job_ids = data;
                let filtered_jobs = $scope.auth_user.active_jobs.filter(
                  (j) => $scope.applicant_job_ids.indexOf(j.id) == -1
                );

                message =
                  "If " +
                  user_name +
                  " accepts your invitation, you will be charged the $" +
                  host_transaction_fee +
                  " " +
                  domain_name +
                  " booking fee, or if you have purchased a pack the booking fee will be less. <br/><br/>  <span> Confirm which job you want to ask " +
                  user_name +
                  " to do</span>";
                let myJobs = [{ text: "Select job", value: "" }];
                // var data = [1,2,3,4,5,6];
                for (var i = 0; i < filtered_jobs.length; i++) {
                  myJobs.push({
                    text:
                      filtered_jobs[i].title +
                      ": " +
                      filtered_jobs[i].job_title,
                    value: filtered_jobs[i].id,
                  });
                }
                bootbox.prompt({
                  title: title,
                  message: message,
                  inputType: "select",
                  inputOptions: myJobs,
                  value: "",
                  closeButton: false,
                  callback: function (result) {
                    if (result) $scope.applyJob(source, type, result);
                    else if (result == "")
                      toastr.error("Please select at least one job to invite");
                  },
                });
              })
              .catch(({ response: { data } }) => {
                console.log(data.message);
              });
          } else {
            message =
              "You currently do not have any active jobs to invite people to. To create a job, <a href='/job/create'> click here</a>.";
            bootbox.dialog({
              title: title,
              message: "<p>" + message + "</p>",
            });
          }
        } else {
          message =
            "You need to add your card and pay the registration fee of $1 to INVITE staff for the job.";
          bootbox.dialog({
            title: title,
            message:
              "<p>" +
              message +
              "</p><br/><a href='/credit_card'>Add Credit Card</a>",
          });
        }

        // bootbox.confirm({
        //     title: 'Job Invitation',
        //     message: message,
        //     closeButton: false ,
        //     confirmationButton: false,
        //     callback: function(result) {
        //         if(result){

        //             $scope.applyJob(source_id, source)
        //         }
        //     }
        // });
      } else if (type == "received") {
        title = "Apply for a Job";
        if ($scope.auth_user.status != "approved") {
          message =
            "Your profile currently do not have approved status from The Smoke Show Staff. To activate, complete your <a href='/profile' class='text-dark'> profile</a> first. Then it will be review by our team before approval";
          return bootbox.dialog({
            title: title,
            message: "<p>" + message + "</p>",
          });
        }
        let event = source.job_title;
        let job_title = source.title;
        let location = source.location;
        let date = $scope.convertUtcToLocalDate(source.date);
        if ($scope.auth_user.cards && $scope.auth_user.cards.length > 0) {
          $scope.message =
            "<h4>YOUR REQUEST WILL BE SENT TO THE ORGANISER OF THIS EVENT</h4><hr/><div style='display:grid'><span>Event: " +
            event +
            "</span><span>Job Title: " +
            job_title +
            "</span><span>Location: " +
            location +
            "</span><span>Date: " +
            date +
            "</span><textarea id='applicant-description' style='height: 150px; resize:none;' placeholder='Tell your client why you would be good for this job'></textarea></div><br/>";
          if ($scope.payment_configuration.staff_cancellation) {
            $scope.getCancellationPolicy("staff");
          }
          setTimeout(() => {
            bootbox.confirm({
              title: title,
              message: $scope.message,
              confirmationButton: false,
              closeButton: false,
              buttons: {
                confirm: {
                  label: "Apply",
                  // className: 'btn-success'
                },
              },
              callback: function (result) {
                if (result) {
                  $scope.applyJob(source, type);
                }
              },
            });
          }, 1000);
        } else {
          message =
            "You need to pay the registration fee of $1 to APPLY for the job.";

          bootbox.dialog({
            title: title,
            message:
              "<p>" +
              message +
              "</p><br/><a href='/credit_card'>Pay Registration Fee</a>",
          });
        }
      }
    };

    $scope.contactMessage = function (source, type) {
      // message = "If staff accepts your invitation, you will be charged the $35 PartiStaff booking fee"
      let host_transaction_fee = 0;

      if (
        $scope.payment_configuration &&
        $scope.payment_configuration.host_transaction_fee
      )
        host_transaction_fee =
          $scope.payment_configuration.host_transaction_fee;

      let user_name = "staff";

      if (source.name) user_name = source.name;
      title = "Contact Staff";
      if ($scope.auth_user.cards && $scope.auth_user.cards.length > 0) {
        if ($scope.auth_user.active_jobs && $scope.auth_user.active_jobs.length > 0) {
          // show modal
          $("#contactStaffModal").modal("show");
        } else {
          message =
            "You currently do not have any active jobs to invite people to. To create a job, <a href='/job/create'> click here</a>.";
          bootbox.dialog({
            title: title,
            message: "<p>" + message + "</p>",
          });
        }
      } else {
        message =
          "You need to add your card and pay the registration fee of $1 to INVITE staff for the job.";
        bootbox.dialog({
          title: title,
          message:
            "<p>" +
            message +
            "</p><br/><a href='/credit_card'>Add Credit Card</a>",
        });
      }
    };

    $scope.applyJob = function (source, type, job_id = null) {
      if (type == "invite")
        successMsg =
          "Your invitation has been sent. You can choose more staff for the one role, the first to accept is awarded the job.";
      else successMsg = "You have applied for job successfully";
      let description = $("#applicant-description").val();
      $http({
        method: "POST",
        // route('add.to.cart', $item->id)
        url: "/job_applicant",
        data: {
          source_id: source.id,
          source: type,
          job_id: job_id,
          description: description,
        },
      }).then(
        function (response) {
          $scope.job_applicant = response.data.data;
          if (type == "invite")
            // $scope.
            source.is_invited = true;
          else source.is_applied = true;

          toastr.success(successMsg);
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    $scope.tConvert = function (time) {
      if (time == undefined) return "";
      // Check correct time format and split into components
      time = time
        .toString()
        .match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

      if (time.length > 1) {
        // If time format correct
        time = time.slice(1); // Remove full string match value
        time.pop();
        time[5] = +time[0] < 12 ? " AM" : " PM"; // Set AM/PM
        time[0] = +time[0] % 12 || 12; // Adjust hours
      }
      return time.join(""); // return adjusted time or original string
    };

    $scope.getSubscriptionPlans = function () {
      $http({
        method: "GET",
        url: "/get_subscription_plans",
      }).then(
        function (response) {
          $scope.subscription_plans = response.data.data;
          setTimeout(() => {
            if ($scope.auth_user) {
              if ($scope.auth_user.cards && $scope.auth_user.cards.length > 0)
                $scope.haveCreditDetails = true;
              else $scope.haveNoCreditDetails = true;
            }
          }, 500);
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    $scope.staffDiv = false;
    $scope.hostDiv = false;
    $scope.signupWith = function (type) {
      if (type == "staff") {
        $scope.staffDiv = true;
        $scope.hostDiv = false;
      } else {
        $scope.hostDiv = true;
        $scope.staffDiv = false;
      }
    };

    $scope.getSubscription = function () {
      $http({
        method: "GET",
        url: "/get_subscription",
      }).then(
        function (response) {
          $scope.subscriptions = response.data.data;
          $scope.active_subscription = response.data.active_subscription;
          if (response.data.data.length > 0) $scope.subscriptionExist = true;
          else $scope.subscriptionNotExist = true;

          if (response.data.active_subscription)
            $scope.activeSubscriptionExist = true;
          else $scope.activeSubscriptionNotExist = true;
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    $scope.getCurrentStatus = function (status) {
      switch (status) {
        case "received":
        case "invited":
        case "reinvited":
          return "PENDING";
        case "cancelled":
          return "CANCELLED";
        case "rejected":
          return "DECLINED";
        case "expired":
          return "EXPIRED";
        case "contacted":
          return "INQUIRED";
        default:
          return "PENDING";
      }
    };

    $scope.infoAlert = function (message) {
      bootbox.alert({
        message: message,
        closeButton: false,
      });
    };

    $scope.checkAccessCondition = function (msg, first_time = false) {
      let accessCondition = true;
      let message = "";
      switch (msg) {
        case "initial":
          if ($scope.auth_user.roles[0].name == "host") {
            message =
              "<div class='alert-dialog'>Please complete the following fields in your profile:<br>- Suburb<br>- State<br>- Postcode<br><br></div>";
          }
          break;
        case "route":
          message =
            "<div class='alert-dialog'>Please complete your profile to access other pages.</div>";
          break;

        default:
          break;
      }

      if (first_time && $scope.auth_user.roles[0].name == "staff") {
        message =
          "<div class='alert-dialog'>Please add a range of photos, from profile / head shots, to more fun pics. We have 4 categories (so please select where each photo should appear)</br></br>Waitresses / Bucks Parties - Photos can be more revealing here. Bikini photos ok.</br></br>Hens Party Waiters - Shirts can be off, but good to have nice head shots here too.</br></br>Event Staff - head shots for professional events - bartending at birthday parties etc.</br></br>Promo Staff - Pics from car shows, boat shows or in store promotional activities.</br></br>Entertainers - Burlesque dancers, DJ's, Fire Twirlers - show off your talent via your pictures.</br></br>Let's Get Your Profile Looking the Goods!</div>";
        accessCondition = false;
        $scope.infoAlert(message);
      } else {
        if ($scope.auth_user.roles[0].name == "host") {
          if (!$scope.auth_user.is_profile_details) {
            accessCondition = false;

            if (message != "") $scope.infoAlert(message);
          }
        } else if ($scope.auth_user.roles[0].name == "staff") {
          if (!$scope.auth_user.is_skill_details) {
            accessCondition = false;

            if (message != "") $scope.infoAlert(message);
          } else if (!$scope.auth_user.is_profile_details) {
            accessCondition = false;

            if (message != "") $scope.infoAlert(message);
          }
        }
        if ($scope.auth_user.status != "approved" && accessCondition) {
          message =
            "Thanks for applying to " +
            domain_name +
            ", Canada's best party networking platform. We review all staff profile's and based on growth in jobs bring on new staff periodically. We will let you know if your application is successful in the next 48 hours.<br><br>Thank you,<br><br>Team " +
            domain_name;
          accessCondition = false;
          $scope.infoAlert(message);
        }
      }

      return accessCondition;
    };

    $scope.accessToRoute = function (route) {
      if ($scope.checkAccessCondition("route")) {
        window.location.href = route;
      }
      //   "{! URL::to('/project/project-data') !}"
    };

    $scope.giveFeedback = function (
      source,
      target,
      job_id,
      review = null,
      edit = false
    ) {
      $scope.source_user = source;
      $scope.target_user = target;
      $scope.feedbackModel = {};
      $scope.editFeedback = edit;
      if (review) {
        $scope.feedbackModel.id = review.id;
        $scope.feedbackModel.rating = review.rating;
        $scope.feedbackModel.comments = review.comments;
      }

      $scope.feedbackModel.job_id = job_id;
      $scope.feedbackModel.source_id = source.id;
      $scope.feedbackModel.target_id = target.id;
      $("#feedbackModal").modal("show");
    };

    $scope.cancelFeedback = function() {
      $("#feedbackModal").modal("hide");
    }

    $scope.showReviewButton = true;

    $scope.saveFeedback = function () {
      $scope.feedbackModel.rating = parseInt($scope.feedbackModel.rating);

      if (!$scope.feedbackModel.rating)
        return toastr.error("Rating is required to give feedback");

      // if($scope.feedbackModel.rating < 3){
      //     if(!$scope.feedbackModel.comments && $scope.feedbackModel.comments != '')
      //         return toastr.error('Comments are required when giving ratings is less than 3');

      // }

      let url =
        $scope.editFeedback && $scope.feedbackModel.id
          ? "/rating/" + $scope.feedbackModel.id
          : "/rating";
      let method =
        $scope.editFeedback && $scope.feedbackModel.id ? "PUT" : "POST";

      let successMsg = $scope.editFeedback && $scope.feedbackModel.id ? "User rating has been updated successfully" : "User has been rated successfully";

      $http({
        method: method,
        url: url,
        data: $scope.feedbackModel,
      }).then(
        function (response) {
          if ($scope.editFeedback && $scope.feedbackModel.id)
            $rootScope.myReviews();
          else $scope.callSpecificRoute();

          // hide feedback button
          $("#feedbackModal").modal("hide");
          toastr.success(successMsg);
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    $scope.disputeBooking = function (job_applicant_id, disputed_to) {
      $scope.target_user = disputed_to;
      $scope.disputeModel = {};
      $scope.disputeModel.job_applicant_id = job_applicant_id;
      $scope.disputeModel.disputed_to = disputed_to.id;

      $http({
        method: "GET",
        url: "/dispute_titles",
      }).then(
        function (response) {
          $scope.dispute_titles = response.data.data;
          $("#disputeModal").modal("show");
        },
        function (error) {
          console.log(error.data.message);
        }
      );
    };

    $scope.saveDispute = function () {
      if (!$scope.disputeModel.dispute_title_id)
        return toastr.error(
          "Dispute Tile is required to take action on your dispute case"
        );

      if (!$scope.disputeModel.concern)
        return toastr.error(
          "Concern is required to take action on your dispute case"
        );

      $http({
        method: "POST",
        url: "/dispute_booking",
        data: $scope.disputeModel,
      }).then(
        function (response) {
          $scope.callSpecificRoute();
          $("#disputeModal").modal("hide");
          toastr.success(
            "Dispute file case has been issued successfully. You will be notify whatever action taken by authorities"
          );
        },
        function (error) {
          console.log(error);
          toastr.error(error.data.message);
        }
      );
    };

    $scope.goToPage = function(page_no){
      let urlParams = new URLSearchParams(location.search);

      urlParams.delete('page');
      urlParams.set('page', parseInt(page_no))

      location.search = urlParams.toString();


  }

  $scope.previousPage = function () {
      var page = $scope.url.searchParams.get("page");
      
      let urlParams = new URLSearchParams(location.search);
      if(page > 1){
          urlParams.delete('page');
          urlParams.set('page', parseInt(page)-1)
      }
      // urlParams.set(key, value);
      location.search = urlParams.toString();
  }

  $scope.nextPage = function () {
      var page = $scope.url.searchParams.get("page");
      
      let urlParams = new URLSearchParams(location.search);
      if(page){
          urlParams.delete('page');
          urlParams.set('page', parseInt(page)+1)
      } else {
          urlParams.set('page', 2)
      }
      // urlParams.set(key, value);
      location.search = urlParams.toString();
  }
  

    $scope.callSpecificRoute = function () {
      $scope.url = $scope.getDecodedUrl();
      let pathname = $scope.url.pathname;
      let f_url = pathname.split("/")[1] || "";
      if (f_url == "invitations") {
        s_url = pathname.split("/")[2] || "";
        job_id = s_url;
        $rootScope.getJob(job_id);
      } else if (f_url == "applications") {
        $rootScope.getApplicants();
      }
    };

    $scope.getAuthUser();
    $scope.paymentConfiguration();
    $scope.basicSetting();
  });

app.directive("numbersOnly", function () {
  return {
    require: "ngModel",
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        if (text) {
          var transformedInput = text.replace(/[^0-9]/g, "");

          if (transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
          }

          return transformedInput;
        }
        return undefined;
      }
      ngModelCtrl.$parsers.push(fromUser);
    },
  };
});

// app.directive("alphabets", function () {
//     return {
//         require: "ngModel",
//         link: function (scope, element, attr, ngModelCtrl) {
//             function fromUser(text) {
//                 if (text) {
//                     let limit = attr.limit ? attr.limit : 5;

//                     let reg = new RegExp("/^[A-Za-z. ]{0," + limit + "}$/");

//                     if (!reg.test(text)) {
//                         transformedInput = ngModelCtrl.$$rawModelValue;
//                     } else {
//                         transformedInput = text;
//                     }

//                     ngModelCtrl.$setViewValue(transformedInput);
//                     ngModelCtrl.$render();

//                     return transformedInput;
//                 }
//                 return undefined;
//             }
//             ngModelCtrl.$parsers.push(fromUser);
//         },
//     };
// });

app.directive("replace", function () {
  return {
    require: "ngModel",
    scope: {
      regex: "@replace",
      with: "@with",
    },
    link: function (scope, element, attrs, model) {
      model.$parsers.push(function (val) {
        if (!val) {
          return;
        }
        var regex = new RegExp(scope.regex);
        var replaced = val.replace(regex, scope.with);
        if (replaced !== val) {
          model.$setViewValue(replaced);
          model.$render();
        }
        return replaced;
      });
    },
  };
});

app.directive("lettersOnly", function () {
  return {
    replace: true,
    template: '<input replace="[^a-zA-Z]" with="">',
  };
});

app.directive("titleOnly", function () {
  return {
    replace: true,
    template: '<input replace="[^a-zA-Z .]" with="">',
  };
});

app.directive("description", function () {
  return {
    replace: true,
    template: '<input replace="[^a-zA-Z .%()/$@0-9]" with="">',
  };
});
// app.directive("numbersOnly", function () {
//     return {
//         replace: true,
//         template: '<input replace="[^0-9]" with="">',
//     };
// });

toastr.options = {
  closeButton: false,
  debug: false,
  newestOnTop: false,
  progressBar: false,
  positionClass: "toast-top-right",
  preventDuplicates: false,
  onclick: null,
  showDuration: "300",
  hideDuration: "1000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "fadeIn",
  hideMethod: "fadeOut",
};
