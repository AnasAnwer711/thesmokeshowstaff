app.controller("profileDashboardCtrl", function ($scope, $http) {
  $scope.first_time = false;
  $scope.user = {};
  $scope.passwordModel = {};
  $scope.skillModel = { skill_ids: {}, experiences: {}, work_details: {} };
  $scope.profileModel = { nationality: {}, address: {} };

  $scope.init = function (id = null) {
    $scope.url = $scope.getDecodedUrl();
    // let page = $scope.url.searchParams.get("page");
    let new_signup = $scope.url.search;
    if (new_signup == "?new_signup") {
      $scope.first_time = true;
      let newurl =
        window.location.protocol +
        "//" +
        window.location.host +
        window.location.pathname;
      window.history.pushState({ path: newurl }, "", newurl);
    }

    $scope.languages();

    if (id) {
      $scope.is_admin = true;
    } else {
      $scope.is_admin = false;
    }

    if ($scope.is_admin) {
      $scope.getUser(id);
    } else {
      $scope.getUser();
    }
    $scope.nationalities();
    $scope.buildTypes();
    $scope.getStates();
    $(".js-example-basic-multiple").select2({
      width: "resolve",
      tags: true,
      placeholder: "Select your languages",
      multiple: true,

    });
  };

  $scope.uploadHostProfileInput = function (ele) {
    var triggerInput = ele;
    var currentImg = $(ele).closest(".pic-holder").find(".pic").attr("src");
    var holder = $(ele).closest(".pic-holder");
    var wrapper = $(ele).closest(".profile-pic-wrapper");
    $(wrapper).find('[role="alert"]').remove();
    var files = !!ele.files ? ele.files : [];
    if (!files.length || !window.FileReader) {
      return;
    }
    if (/^image/.test(files[0].type)) {
      // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function () {
        $(holder).addClass("uploadInProgress");
        $(holder).find(".pic").attr("src", this.result);
        // $(holder).append(
        //   '<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
        // );

        // Dummy timeout; call API or AJAX below
        $http({
          method: "post",
          // route('add.to.cart', $item->id)
          url: "/update_host_picture",
          data: { image: this.result, orderNo: $scope.orderNo },
        }).then(
          function (response) {
            // also get user_skills here
            $scope.user = response.data.data;
            $scope.getUser(null, true);
            $scope.getAuthUser();
            // $scope.setOrderNo($scope.orderNo);
            setTimeout(() => {
              $(holder).removeClass("uploadInProgress");
              $(holder).find(".upload-loader").remove();
              // If upload successful
              // $(".success-message").append('<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>');

              toastr.success("Photo has been updated successfully");
              // Clear input after upload
              $(triggerInput).val("");

              setTimeout(() => {
                $(wrapper).find('[role="alert"]').remove();
              }, 3000);
              if (Math.random() < 0.9) {
              } else {
              }
            }, 1500);
          },
          function (error) {
            console.log(error.data.data.errors);
            $(holder).find(".pic").attr("src", currentImg);
            toastr.error("There is an error while uploading! Due to: " + error);

            // $(".success-message").append(
            //   '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Due to: ' +
            //     error +
            //     "</div>"
            // );

            // Clear input after upload
            $(triggerInput).val("");
            setTimeout(() => {
              $(wrapper).find('[role="alert"]').remove();
            }, 3000);
          }
        );
      };
    } else {
      toastr.error("Please choose a valid image.");
      //   $(".success-message").append(
      //     '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
      //   );
      setTimeout(() => {
        $(wrapper).find('role="alert"').remove();
      }, 3000);
    }
  };

  $scope.uploadProfileInput = function (ele) {
    var triggerInput = ele;
    var currentImg = $(ele).closest(".pic-holder").find(".pic").attr("src");
    var holder = $(ele).closest(".pic-holder");
    var wrapper = $(ele).closest(".profile-pic-wrapper");
    $(wrapper).find('[role="alert"]').remove();
    var files = !!ele.files ? ele.files : [];
    if (!files.length || !window.FileReader) {
      return;
    }
    if (/^image/.test(files[0].type)) {
      // only image file
      var reader = new FileReader(); // instance of the FileReader
      reader.readAsDataURL(files[0]); // read the local file

      reader.onloadend = function () {
        $(holder).addClass("uploadInProgress");
        $(holder).find(".pic").attr("src", this.result);
        // $(holder).append(
        //   '<div class="upload-loader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>'
        // );

        // Dummy timeout; call API or AJAX below
        $http({
          method: "post",
          // route('add.to.cart', $item->id)
          url: "/update_profile_picture",
          data: { image: this.result, orderNo: $scope.orderNo },
        }).then(
          function (response) {
            // also get user_skills here
            $scope.user = response.data.data;
            $scope.getUser(null, true);
            // $scope.setOrderNo($scope.orderNo);
            setTimeout(() => {
              $(holder).removeClass("uploadInProgress");
              $(holder).find(".upload-loader").remove();
              // If upload successful
              // $(".success-message").append('<div class="snackbar show" role="alert"><i class="fa fa-check-circle text-success"></i> Profile image updated successfully</div>');

              toastr.success("Photo has been updated successfully");
              // Clear input after upload
              $(triggerInput).val("");

              setTimeout(() => {
                $(wrapper).find('[role="alert"]').remove();
              }, 3000);
              if (Math.random() < 0.9) {
              } else {
              }
            }, 1500);
          },
          function (error) {
            console.log(error.data.data.errors);
            $(holder).find(".pic").attr("src", currentImg);
            toastr.error("There is an error while uploading! Due to: " + error);

            // $(".success-message").append(
            //   '<div class="snackbar show" role="alert"><i class="fa fa-times-circle text-danger"></i> There is an error while uploading! Due to: ' +
            //     error +
            //     "</div>"
            // );

            // Clear input after upload
            $(triggerInput).val("");
            setTimeout(() => {
              $(wrapper).find('[role="alert"]').remove();
            }, 3000);
          }
        );
      };
    } else {
      toastr.error("Please choose a valid image.");
      //   $(".success-message").append(
      //     '<div class="alert alert-danger d-inline-block p-2 small" role="alert">Please choose the valid image.</div>'
      //   );
      setTimeout(() => {
        $(wrapper).find('role="alert"').remove();
      }, 3000);
    }
  };

  $scope.getUser = function (id = null, pic_uploaded = false) {
    let url = "/get_profile";

    if ($scope.is_admin) {
      url = "/admin/profile/" + id + "/show";
    }

    $http({
      method: "GET",
      // route('add.to.cart', $item->id)
      url: url,
    }).then(
      function (response) {
        $scope.user = response.data.data;
        $scope.user_skills = response.data.user_skills;
        $scope.attachPhotos(response.data.skill_photos);
        // $scope.user.skill_photos = response.data.skill_photos;

        if (pic_uploaded) {
          $scope.setOrderNo($scope.orderNo);
        }

        let dob = $scope.convertUtcToLocalDate($scope.user.dob);
        $scope.user.dob = new Date(dob);
        $scope.selectedStateId = $scope.user.address
          ? $scope.user.address.state_id
          : null;
        setTimeout(() => {
          // if (pic_uploaded){
          // const image = document.getElementById("skill-image");

          // if (image) {
          //     $scope.cropper = new Cropper(image, {
          //         aspectRatio: 16 / 9,
          //         crop(event) {
          //             $scope.cropParams.x = event.detail.x;
          //             $scope.cropParams.y = event.detail.y;
          //             $scope.cropParams.width = event.detail.width;
          //             $scope.cropParams.height = event.detail.height;
          //             $scope.cropParams.rotate = event.detail.rotate;
          //             $scope.cropParams.scaleX = event.detail.scaleX;
          //             $scope.cropParams.scaleY = event.detail.scaleY;
          //         },
          //         minCanvasWidth: 450,
          //         minCanvasHeight: 450,
          //         minContainerWidth: 450,
          //         minContainerHeight: 450,
          //     });
          // }}

          $scope.getProfileModel();
          // $scope.userSkills(pic_uploaded);
          if ($scope.is_admin) {
            $scope.hisSkills(id);
          } else {
            $scope.mySkills();
          }
        }, 500);
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.getProfileModel = function () {
    $scope.profileModel = angular.copy($scope.user);
    if ($scope.user.nationality)
      $scope.profileModel.nationality.name = angular.copy(
        $scope.user.nationality.name
      );
    if ($scope.user.address) {
      $scope.profileModel.address = angular.copy($scope.user.address);
    }
    if ($scope.user.languages) {
      $scope.profileModel.language_ids = [];
      $scope.profileModel.language_names_with_native = [];
      $scope.user.languages.forEach(element => {
        $scope.profileModel.language_ids.push(element.language_id)
        $scope.profileModel.language_names_with_native.push(element.language.name.concat('('+element.language.native_name+')'))
      });

      setTimeout(() => {
        $(".js-example-basic-multiple").select2();
      }, 1500);

    }

    $scope.checkAccessCondition("initial", $scope.first_time);

    $scope.first_time = false;
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
  $scope.verifyCode = function () {
      if($scope.verification.verify_code == $scope.otp){
        $scope.is_verified = 1;
        $scope.stopTimer = true;
        toastr.success("OTP verified");
        $scope.profileModel.phone_sms = iti.getNumber();
        $('#verification').modal('hide')
        $scope.count = 1

        $scope.saveProfile();

      }

  }

  $scope.showVerificationModal = function () {
    $scope.verification = {}
    $('#verification').modal('show')
  };

  $scope.count = -1
  $scope.$watch('profileModel.phone', function (newval, oldval) {
    
    $scope.count = $scope.count + 1;
    $scope.is_verified = 0;
    $scope.endTimer()

  });

  $scope.toSaveProfile = function () {
    let old_phone_code = angular.copy($scope.profileModel.phone_code);
    $scope.profileModel.phone_code = $(".selected_country").val();

    if(old_phone_code != $scope.profileModel.phone_code || $scope.count > 1)
      return $scope.showVerificationModal()
    else 
      $scope.saveProfile();
    
  }

  $scope.saveProfile = function () {
    console.log($scope.profileModel);
    $http({
      method: "post",
      // route('add.to.cart', $item->id)
      url: "/save_profile",
      data: $scope.profileModel,
    }).then(
      function (response) {
        // console.log(response);
        if ($scope.is_admin) {
          $scope.getUser($scope.profileModel.id);
        } else {
          $scope.getUser();
        }
        $scope.getAuthUser();
        toastr.success("Profile has been saved successfully");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };
  $scope.showChangePaswordModal = function () {
    $scope.passwordModel = {};
  };
  $scope.changePassword = function () {
    console.log($scope.passwordModel);

    $http({
      method: "post",
      // route('add.to.cart', $item->id)
      url: "/change_password",
      data: $scope.passwordModel,
    }).then(
      function (response) {
        console.log(response);
        // $scope.init();
        $("#changePassword").modal("hide");
        toastr.success("Password has been changed successfully");
      },
      function (error) {
        toastr.error(error.data.message);
      }
    );
  };

  $scope.userSkills = function (show_cropper = false) {
    $http({
      method: "GET",
      url: "/user_skills",
    }).then(
      function (response) {
        $scope.user_skills = response.data.data;
        $scope.attachPhotos(response.data.skill_photos);
        $scope.user.skill_photos = response.data.skill_photos;

        if (show_cropper) {
          $scope.setOrderNo($scope.orderNo);
        }
      },
      function (error) {
        toastr.error(error.data.message);
      }
    );
  };

  $scope.attachPhotos = function (photos) {
    $scope.user_skills = $scope.user_skills.map((us) => {
      let p = photos.filter((p) => p[us.id]);
      if (p.length > 0) {
        return { ...us, photos: p[0][us.id] };
      } else {
        return { ...us, photos: [] };
      }
    });
  };

  $scope.mySkills = function () {
    $http({
      method: "GET",
      url: "/my_skills",
    }).then(
      function (response) {
        $scope.my_skills = response.data.data;
        $scope.my_skills.forEach((element) => {
          let skill_id = element.skill_id;
          let experience = element.experience;
          let work_detail = element.work_detail;
          $scope.skillModel.skill_ids = {
            ...$scope.skillModel.skill_ids,
            [skill_id]: true,
          };
          $scope.skillModel.experiences = {
            ...$scope.skillModel.experiences,
            [skill_id]: experience,
          };
          $scope.skillModel.work_details = {
            ...$scope.skillModel.work_details,
            [skill_id]: work_detail,
          };
        });

        console.log($scope.user_skills);
      },
      function (error) {
        toastr.error(error.data.message);
      }
    );
  };
  $scope.hisSkills = function () {
    $http({
      method: "GET",
      url: "/admin/his_skills/" + $scope.user.id,
    }).then(
      function (response) {
        $scope.my_skills = response.data.data;
        $scope.my_skills.forEach((element) => {
          let skill_id = element.skill_id;
          let experience = element.experience;
          let work_detail = element.work_detail;
          $scope.skillModel.skill_ids = {
            ...$scope.skillModel.skill_ids,
            [skill_id]: true,
          };
          $scope.skillModel.experiences = {
            ...$scope.skillModel.experiences,
            [skill_id]: experience,
          };
          $scope.skillModel.work_details = {
            ...$scope.skillModel.work_details,
            [skill_id]: work_detail,
          };
        });

        $scope.user_skills = $scope.user_skills.map((us) => {
          return {
            ...us,
            sub_categories: us.sub_categories.map((sc) => {
              let skill_exists = $scope.my_skills.filter(
                (ms) => ms.skill_id == sc.id
              );

              if (skill_exists.length > 0) {
                return {
                  ...sc,
                  is_selected: true,
                };
              } else {
                return {
                  ...sc,
                  is_selected: false,
                };
              }
            }),
          };
        });
      },
      function (error) {
        toastr.error(error.data.message);
      }
    );
  };

  $scope.skillValue = function (event, ss) {
    var el = event.target;
    var skill_val = $(".skill-value");
    ss.is_selected = !ss.is_selected;

    angular.element(el).parent().next(skill_val).toggle();
  };

  $scope.saveSkills = function () {
    skillIds = Object.keys($scope.skillModel.skill_ids).filter(
      (key) => $scope.skillModel.skill_ids[key]
    );

    data = {
      skill_ids: $scope.skillModel.skill_ids,
      experiences: $scope.skillModel.experiences,
      work_details: $scope.skillModel.work_details,
      id: $scope.user.id,
    };

    $http({
      method: "post",
      // route('add.to.cart', $item->id)
      url: "/user_skills",
      data: data,
    }).then(
      function (response) {
        console.log(response);
        if ($scope.is_admin) {
          $scope.getUser($scope.user.id);
        } else {
          $scope.getUser();
        }

        toastr.success("Skills have been updated successfully");
      },
      function (error) {
        console.log(error);
        toastr.error(error.data.message);
      }
    );
  };

  $scope.showProfileTab = false;
  $scope.activeProfileTab = function () {
    if (!$scope.user.is_skill_details) {
      $scope.showProfileTab = false;
      $("#faq_tab_2-tab").click();

      message =
        "<div class='alert-dialog'>You need to set up your skills and photos before you can finish setting up your profile details.</div>";
      $scope.infoAlert(message);
    } else {
      $scope.showProfileTab = true;
    }
  };

  $scope.changeStatusTo = function (status) {
    let message = "";

    switch (status) {
      case "approved":
        message = `Are you sure you want to ${
          $scope.user.status == "blocked" ? "unblock" : "approve"
        } this user?`;
        break;
      case "rejected":
        message = "Are you sure you want to reject this user?";
        break;
      case "blocked":
        message = "Are you sure you want to block this user?";
        break;
    }

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
            method: "post",
            url: "/admin/users/change_status",
            data: {
              id: $scope.user.id,
              status: status,
            },
          })
            .then(function (response) {
              if (response.data.success) {
                toastr.success(response.data.message);
                window.location.reload();
              }
            })
            .catch((error) => {
              toastr.error(error.data.message);
            });
        }
      },
    });
  };

  $scope.setOrderNo = function (no) {
    $scope.orderNo = no;

    if ($scope.cropper) {
      $scope.cropper.clear();
      $scope.cropper.reset();
      $scope.cropper.destroy();
    }
    let pic = $scope.user.skill_photos.filter(
      (sp) => sp.order_no == no && sp.is_uploaded == 1
    );

    if (pic.length > 0) {
      $scope.selectedPhoto = pic[0];
      // $scope.selectedPhoto.skills = pic[0].skills.map((s) => $scope.selectedSkills.push(s.skill_id));
      $scope.selectedSkills = pic[0].skills.map((s) => s.skill_id);

      let cropperOptions = {
        aspectRatio: 1 / 1,
        crop(event) {
          $scope.cropParams = $scope.cropper.getData();
        },
        minCanvasWidth: 450,
        minCanvasHeight: 450,
        minContainerWidth: 450,
        minContainerHeight: 450,
      };
      let cropBox = JSON.parse($scope.selectedPhoto.cropper_data);

      if (cropBox && cropBox.x) {
        cropperOptions.data = cropBox;
      }

      setTimeout(() => {
        const image = document.getElementById("skill-image");

        if (image) {
          $scope.cropper = new Cropper(image, cropperOptions);
        }
      }, 500);
    } else {
      $scope.selectedPhoto = {
        is_uploaded: 0,
      };
    }

    $("#skill-photo").modal("show");
  };

  $scope.closeSkillPhotoModal = function () {
    $("#skill-photo").modal("hide");
  };

  $scope.selectSkill = (v) => {
    if ($scope.selectedSkills.indexOf(v) === -1) {
      $scope.selectedSkills.push(v);
    } else {
      $scope.selectedSkills.splice($scope.selectedSkills.indexOf(v), 1);
    }
  };

  $scope.saveSkillPhoto = () => {
    if ($scope.selectedSkills.length == 0) {
      toastr.error("Please select at least one skill");
      return;
    }
    $scope.cropper.getCroppedCanvas().toBlob((blob) => {
      let data = {
        user_id: $scope.user.id,
        order_no: $scope.orderNo,
        skill_ids: $scope.selectedSkills,
        cropped_image: blob,
        cropper_data: JSON.stringify($scope.cropParams),
      };

      $scope
        .ajaxPost("/save-skill-photo", data)
        .then(({ data }) => {
          $scope.closeSkillPhotoModal();
          toastr.success(data.message);
          if ($scope.is_admin) {
            $scope.getUser($scope.user.id);
          } else {
            $scope.getUser();
          }
          // $scope.user = data.data;
        })
        .catch((message) => {
          toastr.error(message);
        });
      // .catch(({ data: { message } }) => {
      //   toastr.error(message);
      // });
    });
  };

  $scope.deletePhoto = function (no) {
    bootbox.confirm({
      title: "Confirm?",
      message: "Are you sure you want to delete this photo?",
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
          $scope
            .ajaxPost("/delete-skill-photo", {
              user_id: $scope.user.id,
              order_no: no,
            })
            .then(({ data }) => {
              toastr.success("Photo has been deleted successfully");
              if ($scope.id_admin) {
                $scope.getUser($scope.user.id);
              } else {
                $scope.getUser();
              }
            })
            .catch(({ data: { message } }) => {
              toastr.error(message);
            });
        }
      },
    });
  };

  $scope.setDefaultPhoto = function (skill_id, photo_id) {
    $scope
      .ajaxPost("/set-default-skill-photo", {
        user_id: $scope.user.id,
        skill_id: skill_id,
        photo_id: photo_id,
      })
      .then(({ data }) => {
        toastr.success(data.message);
        if ($scope.id_admin) {
          $scope.getUser($scope.user.id);
        } else {
          $scope.getUser();
        }
      });
  };

  $scope.toggleQualification = function (qualification) {
    if ($scope.profileModel[qualification] == 1) {
      $scope.profileModel[qualification] = 0;
    } else {
      $scope.profileModel[qualification] = 1;
    }
  };
});
