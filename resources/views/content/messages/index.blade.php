@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/messages/messages-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='messagesCtrl' ng-init="loadChats();" ng-cloak
    class="ng-cloak">
    <div id="chatScope"></div>
    <div class="p-3 py-5">
        <div class="row" ng-show="chats.length > 0">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">My Messages</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="row">
                <div ng-hide="chats.length > 0" class="col-md-12 text-center my-2 p-3 bg-light">
                    <h5>
                        No chat initiated.
                    </h5>
                </div>
                <div class="col-lg-4 py-3">
                    <div class="section-heading py-4 px-3 bg-light">
                        <h6 class="mb-0 pink-text-color">Most recent</h6>
                    </div>
                    <div class="users-list">
                        <div ng-repeat="chat in chats"
                            class="user-pill cursor-pointer d-flex flex-wrap justify-content-between bg-light p-2 my-3 active"
                            ng-click="selectChat(chat)">
                            <div class="img-col img-col" style="display: contents;">
                                <img ng-src="[[chat.user.display_pic ? chat.user.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                    style="width:50px;height:50px;"
                                    class="rounded-circle img-thumbnail img-responsive" />
                            </div>
                            <div class="info flex-grow-1 ms-2">
                                <div class="name">
                                    <strong class="text-capitalize text-truncate">[[chat.user.name]]
                                    </strong>
                                </div>
                                <div class="last-msg d-none">
                                    <small>[[chat.last_message.message]]</small>
                                </div>
                                <div class="date">
                                    <!-- <small>[[convertUtcToLocalDate(chat.last_message_at)]]</small> -->
                                    <small>[[convertUtcToLocalMonthDate(chat.last_message_at)]]</small>
                                </div>
                            </div>

                            <div class="status flex-shrink-1 my-md-2 my-lg-0 my-lg-2 ms-lg-auto"
                                ng-show="chat.last_message.is_seen == 0">
                                <small class="badge border badge-sm pink-text-color">
                                    Pending
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 my-sm-4 p-sm-0">
                    <div class="person-detail card bg-light">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="img-col" style="display:contents;">
                                    <img class="img-fluid img-thumbnail rounded-circle"
                                        ng-src="[[selectedChat.user.display_pic ? selectedChat.user.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                        style="width:100px;height:100px" />
                                </div>
                                <div class="detail ms-3">
                                    <div class="name mb-1"><strong
                                            class="text-capitalize text-truncate">[[selectedChat.user.name]]<span ng-show="is_admin"> - [[selectedChat.job.user.name]]</span></strong>
                                    </div>
                                    <div class="addi-info d-flex flex-wrap align-items-center mb-2">
                                        <div class="me-2">
                                            <i class="me-2 icofont-badge text-warning"></i><span
                                                class="text-capitalize">[[selectedChat.job.title]]</span>
                                        </div>
                                        <div class="me-2">
                                            <i class="me-2 icofont-user-alt-5 text-info"></i><span><a
                                                    class="text-decoration-none"
                                                    href="#">[[selectedChat.job.staff_category.title]]</a></span>
                                        </div>
                                        <div class="me-2 my-sm-2">
                                            <i
                                                class="me-2 icofont-ui-calendar text-danger"></i><span>[[convertUtcToLocalDate(date)]]</span>
                                        </div>

                                    </div>
                                    <!-- <div class="job-name d-flex align-items-center mb-2">
                                        <span class="me-2"><i class="icofont-briefcase-1 text-info"></i></span>
                                        <span>DJ</span>
                                    </div>
                                    <div class="mbl-num d-flex align-items-center mb-2">
                                        <span class="me-2"><i class="icofont-ui-call text-info"></i></span>
                                        <span>123 123 123 213</span>
                                    </div> -->
                                </div>
                            </div>
                            <div class="d-flex justify-content-end" ng-hide="is_admin">
                                <button ng-click="deleteChat(selectedChat.id)" type="button" class="btn btn-sm"><i
                                        class="icofont-ui-delete delete-icon cursor-pointer"></i>
                                    Delete Chat</button>
                            </div>
                        </div>
                    </div>

                    <div class="msg-box mt-2">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="chat-content">
                                    <ul class="chatting-area">
                                        <li class="[[message.source_id == auth_user.id || (is_admin && selectedChat.job.user.id == message.source_id) ? 'me' : 'you']]"
                                            ng-repeat="message in messages" ng-cloak>
                                            <div class="msg" ng-show="message.message">
                                                <div class="msg-text"><span>[[message.message]]</span></div>
                                                <div class="msg-time">
                                                    <small>[[convertUtcToLocalDate(message.created_at)]]
                                                        [[convertUtcToLocalTime(message.created_at)]]</small>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mt-2 msg-input d-flex" ng-hide="is_admin">
                        <!-- <input type="text" class="form-control" placeholder="Type Message" ng-model="message"> -->
                        <textarea style="resize:none;" type="text" class="form-control me-2 flex-fill"
                            placeholder="Type Message" ng-model="message">
                        </textarea>
                        <button class="btn-sm btn align-self-end" type="button" ng-click="sendMessage()">
                            <!-- <i style="transform: rotate(90deg)" class="fa fa-paper-plane"></i> -->
                            Send
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center" ng-show="chats.length == 0">
            <p>You have no messages</p>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/messages-controller.js') }}"></script>
@endsection