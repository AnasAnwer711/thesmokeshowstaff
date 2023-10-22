@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/messages/messages-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='adminViolatesCtrl'
    ng-init="loadSingleChats({{ $violate->chat_thread_id }});" ng-cloak class="ng-cloak">

    <div id="chatScope"></div>
    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">[[selectedChat.job.title]]'s Messages</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="row">

                <div class="col-lg-8 my-sm-4 p-sm-0">
                    <div class="person-detail card bg-light">
                        <div class="card-body">
                            <div class="rounded-images d-flex">
                                <div class="overlap-images me-2" ng-click="loadMessages()">
                                    <img src="[[selectedChat.sender.display_pic ||'/images/Logo_SmokeShowStaff.png' ]]"
                                        style="position: relative;width:65px;height:65px;z-index: 1;"
                                        class="img-fluid img-thumbnail rounded-circle" alt="">
                                    <img src="[[selectedChat.receiver.display_pic ||'/images/Logo_SmokeShowStaff.png' ]]"
                                        style="position: relative;width:65px;height:65px;margin-left: -45px;z-index: 0;"
                                        class="img-fluid img-thumbnail rounded-circle" alt="">
                                </div>
                                <div class="single-image me-2" ng-click="loadMessages(selectedChat.sender.id)">
                                    <img src="[[selectedChat.sender.display_pic ||'/images/Logo_SmokeShowStaff.png']]" style="width:65px;height:65px;z-index:1; cursor:pointer"
                                        class="img-fluid img-thumbnail rounded-circle" alt="">
                                </div>
                                <div class="single-image" ng-click="loadMessages(selectedChat.receiver.id)">
                                    <img src="[[selectedChat.receiver.display_pic ||'/images/Logo_SmokeShowStaff.png']]" style="width:65px;height:65px;z-index:1; cursor:pointer"
                                        class="img-fluid img-thumbnail rounded-circle" alt="">
                                </div>
                            </div>
                            <div class="d-flex align-items-center d-none">
                                <div class="img-col" style="display:contents;">
                                    <img class="img-fluid img-thumbnail rounded-circle"
                                        ng-src="[[selectedChat.user.display_pic ? selectedChat.user.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                        style="width:100px;height:100px" />
                                </div>
                                <div class="detail ms-3">
                                    <div class="name mb-1"><strong
                                            class="text-capitalize text-truncate">[[selectedChat.user.name]]<span
                                                ng-show="is_admin"> - [[selectedChat.job.user.name]]</span></strong>
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

                        </div>
                    </div>

                    <div class="msg-box mt-2">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="chat-content">
                                    <ul class="chatting-area">
                                        <li class="[[message.source_id == auth_user.id || (is_admin && selectedChat.job.user_id == message.source_id) ? 'me' : 'you']]"
                                            ng-repeat="message in messages" ng-cloak>
                                            <div class="msg" id="anchor[[message.id]]" ng-show="message.message">
                                                <div class="text-start d-flex">
                                                    <div class="text-left flex-grow-1">[[message.message]]</div>
                                                    <div class="text-muted dropdown violationNo[[message.id]]"
                                                        ng-if="message.is_violated">
                                                        <i class="fas fa-ellipsis-v cursor-pointer mt-1"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown"
                                                            aria-expanded="false"></i>
                                                        <ul class="dropdown-menu p-0"
                                                            aria-labelledby="dropdownMenuButton1">
                                                            <li class="mb-0">
                                                                <small class="dropdown-item cursor-pointer"
                                                                    ng-click="showReviewedModal(message.id)">Reviewed</small>
                                                            </li>
                                                            <li class="mb-0">
                                                                <small class="dropdown-item cursor-pointer"
                                                                    ng-click="showtakeActionModal(message.id)">Take
                                                                    action</small>
                                                            </li>

                                                        </ul>
                                                    </div>

                                                    <!-- <label class="badge badge-success">[[message.is_violated ? 'Show
                                                        Dots'
                                                        : '']]
                                                    </label> -->
                                                </div>

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
                <div class="col-lg-4 my-sm-4 px-2">
                    <div class="section-heading py-4 px-3 bg-light">
                        <h6 class="mb-0 pink-text-color">Violations</h6>
                    </div>
                    <div class="users-list">
                        <div ng-repeat="violation in violations track by $index" ng-cloak
                            class="user-pill cursor-pointer d-flex flex-wrap justify-content-between bg-light p-2 my-3 active">
                            <div class="info flex-grow-1 ms-2">
                                <div class="name">
                                    <strong class="" ng-click="goToMessage(violation.user_message_id)">#[[$index+1]]
                                        :[[violation.matched_string ?
                                        violation.matched_string : 'Violation No: ' ]] [[violation.matched_string ? '' :
                                        $index+1]] </strong>
                                    </strong>
                                </div>
                                {{-- <div class="last-msg d-none">
                                    <small>[[chat.last_message.message]]</small>
                                </div>
                                <div class="date">
                                    <!-- <small>[[convertUtcToLocalDate(chat.last_message_at)]]</small> -->
                                    <small>[[convertUtcToLocalMonthDate(chat.last_message_at)]]</small>
                                </div> --}}
                            </div>

                            <div class="status flex-shrink-1 my-md-2 my-lg-0 my-lg-2 ms-lg-auto"
                                ng-show="chat.last_message.is_seen == 0">
                                <small class="badge border badge-sm pink-text-color">
                                    Pending
                                </small>
                            </div>
                        </div>
                        {{-- <div ng-repeat="chat in chats"
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
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>

        <div class="row text-center" ng-show="chats.length == 0">
            <p>You have no messages</p>
        </div>
    </div>

    <!-- reviewed modal -->
    <div class="modal fade" id="reviewedModal" tabindex="-1" role="dialog" aria-labelledby="reviewedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewedModalLabel">Reviewed</h5>
                </div>
                <div class="modal-body">
                    <div class="form-outline mt-3">
                        <textarea class="form-control" ng-model="violationModal.notes" value="" required
                            style="min-height: 100px"></textarea>
                        <label class="form-label" style="margin-left: 0px;">Review</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideReviewedModal()">Cancel</button>
                    <button type="button" class="btn" ng-click="updateViolation()">Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- take action modal -->
    <div class="modal fade" id="takeActionModal" tabindex="-1" role="dialog" aria-labelledby="takeActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="takeActionModalLabel">Take Action</h5>
                </div>
                <div class="modal-body">
                    <div class="form-outline">
                        <label class="form-control-760">
                            <input type="checkbox" ng-true-value="1" ng-false-value="0"
                                ng-model="violationModal.is_penalized">Is Penalized
                        </label>
                    </div>
                    <div class="form-outline mt-3" ng-if="violationModal.is_penalized">
                        <input type="text" ng-model="violationModal.penalized_amount" numbers-only maxlength="3">
                        <label class="form-label" style="margin-left: 0px;"> Penalized Amount
                        </label>
                    </div>
                    <div class="form-outline mt-3">
                        <label class="form-control-760">
                            <input type="checkbox" ng-true-value="1" ng-false-value="0"
                                ng-model="violationModal.is_blocked">Is Blocked
                        </label>
                    </div>

                    <div class="form-outline mt-4">
                        <textarea class="form-control" ng-model="violationModal.notes" value="" required
                            style="min-height: 100px"></textarea>
                        <label class="form-label" style="margin-left: 0px;">Please tell reason behind your
                            action</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hidetakeActionModal()">Cancel</button>
                    <button type="button" class="btn" ng-click="updateViolation()">Save</button>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@section('js-controller')
<script src="{{ ('/app/admin-violates-controller.js') }}"></script>
@endsection