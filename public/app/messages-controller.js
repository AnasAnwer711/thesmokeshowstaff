app.controller("messagesCtrl", function ($scope, $http) {
    $scope.messages = [];
    $scope.is_admin;

    $scope.loadChats = function (selectTop = true) {
        let url_params = new URLSearchParams(window.location.search);
        let data = {};

        if (!!url_params.get("job_id")) {
            let job_id = parseInt(url_params.get("job_id"));
            data.job_id = job_id;
            $scope.job_id = job_id;
        }

        let url = "/chats";

        if (window.location.pathname.includes("admin")) {
            $scope.is_admin = true;
            url = "/admin/job-messages";
        }

        $scope
            .ajaxGet(url, data)
            .then((response) => {
                $scope.chats = response.data.data;

                $scope.chats = $scope.chats.map((chat) => {
                    if (window.location.pathname.includes("admin")) {
                        chat.user = chat.sender.id == chat.job.user_id ? chat.receiver : chat.sender;
                    } else if (chat.sender.id == $scope.auth_user.id) {
                        chat.user = chat.receiver;
                    } else {
                        chat.user = chat.sender;
                    }

                    delete chat.sender;
                    delete chat.receiver;

                    return chat;
                });

                if (!!$scope.job_id) {
                    index = $scope.chats.findIndex((c) => c.job_id == $scope.job_id);
                    $scope.selectChat($scope.chats[index]);
                    return;
                }

                if ($scope.chats.length > 0 && selectTop) {
                    $scope.selectChat($scope.chats[0]);
                } else {
                    $scope.loadMessages();
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

    $scope.scrollBottom = function () {
        var ca = document.getElementsByClassName("chatting-area");

        for (let a of ca) a.scrollTop = a.scrollHeight;
    };

    $scope.loadMessages = function () {
        if($scope.selectedChat){

            $scope
                .ajaxPost("/messages/", {
                    chat_id: $scope.selectedChat.id,
                })
                .then((response) => {
                    $scope.messages = response.data.data;
                    $scope.$apply();
                    $scope.scrollBottom();
                })
                .catch((response) => {
                    console.log(response);
                });
        }
    };

    $scope.sendMessage = function () {
        $scope
            .ajaxPost("/send-message", {
                chat_id: $scope.selectedChat.id,
                message: $scope.message,
            })
            .then((response) => {
                $scope.messages.push(response.data.data);
                $scope.message = "";
                $scope.$apply();
                $scope.scrollBottom();
            })
            .catch((response) => {
                console.log(response);
            });
    };

    $scope.reloadChats = function () {
        let cs = $("#chatScope");

        if (cs.length > 0) {
            $scope.loadChats();
        } else {
            console.log("new message received");
        }
    };

    $scope.deleteChat = function (id) {
        bootbox.confirm({
            title: "Confirm?",
            confirmationButton: false,
            closeButton: false,
            message: "Are you sure you want to delete this chat?",
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
                        .ajaxPost("/delete-chat", {
                            chat_id: id,
                        })
                        .then((response) => {
                            if (response.data.success) {
                                toastr.success(response.data.message);
                                $scope.loadChats();
                            }
                        })
                        .catch((response) => {
                            toastr.error(response.data.message);
                        });
                }
            },
        });
    };
});
