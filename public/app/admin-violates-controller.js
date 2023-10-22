app.controller("adminViolatesCtrl", function ($scope, $anchorScroll, $location, $http) {
  $scope.init = () => {
    $scope.getViolates();
  };
  $scope.showReviewedModal = (message_id) => {
    $scope.violationModal = {user_message_id: message_id,};
    $("#reviewedModal").modal("show");
  };
  $scope.hideReviewedModal = () => {
    $("#reviewedModal").modal("hide");
  };

  $scope.showtakeActionModal = (message_id) => {
    $scope.violationModal = {user_message_id: message_id,'is_penalized': 0, 'is_blocked': 0};
    $("#takeActionModal").modal("show");
  };
  $scope.hidetakeActionModal = () => {
    $("#takeActionModal").modal("hide");
  };

  $scope.getViolates = () => {
    $scope
      .ajaxGet("/admin/get-violates")
      .then((response) => {
        if (response.data.success) {
          $scope.violates = response.data.data;
          $scope.$apply();
        }
      })
      .catch((response) => {
        toastr.error(response);
      });
  };

  $scope.loadSingleChats = (chat_id) => {
    $scope
      .ajaxGet("/chat-detail", { chat_id: chat_id })
      .then((response) => {
        if (response.data.success) {
          $scope.chat = response.data.data.chat;
          $scope.violations = response.data.data.violations;
          $scope.chat.user =
            $scope.chat.sender.id == $scope.chat.job.user_id
              ? $scope.chat.receiver
              : $scope.chat.sender;
          // delete $scope.chat.sender;
          // delete $scope.chat.receiver;

          $scope.is_admin = true;

          if ($scope.chat) {
            $scope.selectChat($scope.chat);
          }

          $scope.$apply();
        }
      })
      .catch((response) => {
        toastr.error(response);
      });
  };

  $scope.selectChat = function (chat) {
    $scope.selectedChat = angular.copy(chat);

    $scope.selectedUser = $scope.selectedChat.user;

    $scope.loadMessages();
  };

  $scope.loadMessages = function (source_id = null) {
    if ($scope.selectedChat) {
      $scope
        .ajaxPost("/messages/", {
          chat_id: $scope.selectedChat.id,
          source_id: source_id,
        })
        .then((response) => {
          $scope.messages = response.data.data;

          $scope.messages = $scope.messages.map((m) => {
            if (
              $scope.violations.findIndex((v) => v.user_message_id == m.id && v.notes == null) > -1
            ) {
              m.is_violated = true;
            } else {
              m.is_violated = false;
            }
            return m;
          });
          $scope.$apply();
          $scope.scrollBottom();
        })
        .catch((response) => {
          console.log(response);
        });
    }
  };

  $scope.goToMessage = function(user_message_id){
    console.log(user_message_id);
    var newHash = 'anchor' + user_message_id;
      if ($location.hash() !== newHash) {
        // set the $location.hash to `newHash` and
        // $anchorScroll will automatically scroll to it
        $location.hash('anchor' + user_message_id);
      } else {
        // call $anchorScroll() explicitly,
        // since $location.hash hasn't changed
        $anchorScroll();
      }
  }

  $scope.updateViolation = function(){
    // $scope.violationModal.notes;
    if(!$scope.violationModal.notes)
      return toastr.error("Please enter notes");

    if($scope.violationModal.is_penalized)
      if(!$scope.violationModal.penalized_amount)
        return toastr.error("Please enter penalize amount");
    
    $scope
      .ajaxPost("/admin/update-violation", $scope.violationModal, true)
      .then((response) => {
        if (response.data.success) {
          toastr.success(response.data.message);
          $scope.loadMessages();
          $('.violationNo'+$scope.violationModal.user_message_id).css('display', 'none');

          $('.modal').modal('hide');
        }
      })
      .catch((response) => {
        toastr.error(response);
      }
    );
  }
});
