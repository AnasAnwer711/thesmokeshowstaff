@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/invitations-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/messages/messages-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='invitationsCtrl' ng-init="init();getJob({{ $job_id }});"
    ng-cloak class="ng-cloak">
    <!-- Modal -->
    <div class="modal fade" id="cardSelectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button> --}}
                    <h4 class="modal-title" id="myModalLabel">Card/Subscription Selection</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-outline">
                                <div class="alert alert-info">
                                    [[message]]
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" ng-show="activeSubscriptionExist">
                            <div class="form-outline">
                                <h5>Select from Subscription OR Card</h5>
                                <label>
                                    <input type="radio" ng-model="bookingModel.subscription_type"
                                        ng-value="active_subscription.id">
                                    [[active_subscription.title]]
                                </label>
                                <label>

                                    <input type="radio" ng-model="bookingModel.subscription_type" value="card">
                                    Charge from Card
                                </label>
                                <select class="form-control" ng-model="bookingModel.card_id"
                                    ng-show="bookingModel.subscription_type == 'card'">
                                    <option ng-repeat="card in auth_user.cards" ng-value="card.id">
                                        [[card.name]] | **** **** **** [[card.last4]]
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12" ng-show="activeSubscriptionNotExist">
                            <div class="form-outline">
                                <select class="form-control" ng-model="bookingModel.card_id">
                                    {{-- <option value="">Select your card</option> --}}
                                    <option ng-repeat="card in auth_user.cards" ng-value="card.id">
                                        [[card.name]] | **** **** **** [[card.last4]]</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" ng-show="haveCreditDetails">
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                    <button type="button" class="btn" ng-click="acceptBooking()">Confirm</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->

    @include('content.applications.feedback-modal')
    @include('content.applications.disputed-modal')


    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">[[job.title]] Invitations</h4>
                <button class="btn btn-sm align-self-end d-none" ng-click="toggleCardForm();"><i
                        class="icofont-credit-card me-2 "></i>back
                </button>
            </div>
            <div class="bg-white">
                <ul class="nav nav-tabs nav-fill tablist" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation" ng-click="hideChats()"> <button class="nav-link"
                            id="app_tab_1-applicants" data-bs-toggle="tab" data-bs-target="#app_tab_1" type="button"
                            role="tab" aria-controls="app_tab_1" aria-selected="true">
                            <div class="d-flex flex-row justify-content-center lh-lg"> <i class='bx bxs-plane-alt'></i>
                                <span>APPLICATIONS RECEIVED ([[job.applications_count]])</span>
                            </div>
                        </button> </li>
                    <li class="nav-item" role="presentation" ng-click="hideChats()"> <button class="nav-link"
                            id="app_tab_2-invitations" data-bs-toggle="tab" data-bs-target="#app_tab_2" type="button"
                            role="tab" aria-controls="app_tab_2" aria-selected="false">
                            <div class="d-flex flex-row justify-content-center lh-lg"> <i
                                    class='bx bxs-shopping-bag'></i> <span>INVITATIONS SENT
                                    ([[job.invitations_count]])</span> </div>
                        </button> </li>
                    <li class="nav-item" role="presentation" ng-click="hideChats()"> <button class="nav-link"
                            id="app_tab_3-booked" data-bs-toggle="tab" data-bs-target="#app_tab_3" type="button"
                            role="tab" aria-controls="app_tab_3" aria-selected="false">
                            <div class="d-flex flex-row justify-content-center lh-lg"> <i
                                    class='bx bx-check-circle'></i> <span>BOOKED STAFF ([[job.booked_count]])</span>
                            </div>
                        </button> </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade" id="app_tab_1" role="tabpanel" aria-labelledby="app_tab_1-applicants">

                        <!-- New Chat Content -->
                        <div class="row pt-3">
                            <div ng-show="job.applications_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No application received
                                </h5>
                            </div>
                            <div class="col-md-4 py-3 border border-light">
                                <div class="users-list">
                                    <div ng-click="selectApplicant(item.staff_id)" ng-repeat="item in job.applications"
                                        class=" cursor-pointer user-pill d-flex justify-content-between bg-light p-2 my-3 active">
                                        <div class="img-col img-col me-2">
                                            <img ng-src="[[item.staff.display_pic ? item.staff.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                                style="width:50px;height:50px;"
                                                class="rounded-circle img-thumbnail img-responsive" />
                                        </div>
                                        <div class="info flex-grow-1">
                                            <div class="name"><strong
                                                    class="text-capitalize text-truncate">[[item.staff.name]]</strong>
                                            </div>
                                        </div>

                                        <div class="status flex-shrink-1">
                                            <small class="badge border badge-sm pink-text-color">
                                                [[getCurrentStatus(item.current_status)]]
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="display: none" id="jobChat">
                                <div class="person-detail card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="img-col me-3">
                                                <img ng-src="[[selected_applicant.staff.display_pic ? selected_applicant.staff.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                                    style="width:100px;height:100px"
                                                    class="rounded-circle img-thumbnail img-responsive" />

                                            </div>
                                            <div class="detail">
                                                <div class="name mb-1">
                                                    <strong class="text-capitalize text-truncate">
                                                        <a class="text-decoration-none text-dark"
                                                            href="/find_staff/[[selected_applicant.staff.id]]/detail">[[selected_applicant.staff.name]]</a></strong>
                                                </div>
                                                <div class="addi-info d-flex align-items-center mb-2">
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-badge text-warning"></i><span
                                                            class="text-capitalize">[[job.title]]</span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-user-alt-5 text-info"></i><span><a
                                                                class="text-decoration-none"
                                                                href="#">[[job.staff_category.title]]</a></span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i
                                                            class="me-2 icofont-ui-calendar text-danger"></i><span>[[convertUtcToLocalDate(job.date)]]</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <div class="buttons "
                                                ng-if="getCurrentStatus(selected_applicant.current_status) == 'PENDING'">
                                                <a class="btn" href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_applicant.id, 'rejected', selected_applicant.user_id)">DECLINE</a>
                                                <a class="btn" href="javascript:void(0)"
                                                    ng-click="acceptApplication()">ACCEPT</a>
                                                <!-- <button class="btn btn-long btn-light buy "> <i class="fa fa-heart"></i> ADD TO SHORTLIST </button>  -->
                                            </div>
                                            <div class="buttons "
                                                ng-if="getCurrentStatus(selected_applicant.current_status) == 'CANCELLED'">
                                                <a class="btn"
                                                    ng-if="getCurrentStatus(selected_applicant.current_status) == 'CANCELLED'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_applicant.id, 'reinvited', selected_applicant.user_id)">REINVITE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="msg-box mt-2" ng-if="messages.length > 0">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="chat-content">
                                                <ul class="chatting-area">
                                                    <li class="[[message.source_id == auth_user.id ? 'me' : 'you']]"
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
                                <div class="input-group mt-2 msg-input">
                                    <input type="text" class="form-control" placeholder="Type Message"
                                        ng-model="chat_message">
                                    <button class="btn-sm btn " type="button" ng-click="sendMessage()">Send</button>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3" style="display: none">
                            <div ng-show="job.applications_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No application received
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="container p-3 scroll-auto">
                                    <div class="section_our_solution">
                                        <div class="our_solution_category">
                                            <div class="solution_cards_box">
                                                <!--user card start-->
                                                <div class="cursor-pointer solution_card inv inv-cancel [[selected_applicant.id == item.id ? 'active' : '']]"
                                                    ng-click="selectApplicant(item.staff_id)"
                                                    ng-repeat="item in job.applications">
                                                    <div class="hover_color_bubble"></div>
                                                    <div class="title-bar d-flex align-items-center">
                                                        <div class="so_top_icon">
                                                            <img ng-src="[[item.staff.display_pic ? item.staff.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                                alt="pic">
                                                        </div>
                                                        <div class="solu_title ">
                                                            <h3>[[item.staff.name]]</h3>
                                                            {{-- <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="ratings"> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star"></i> <span
                                                                        class="ml-1">4.6</span></div>

                                                            </div> --}}
                                                        </div>
                                                        <div class="solu_title-rate solu_title">
                                                            <h3>[[convertUtcToLocalDate(item.created_at)]]</h3>
                                                            {{-- <small class="badge bg-success">INTERESTED</small> --}}
                                                            <small
                                                                class="badge bg-[[getCurrentStatus(item.current_status) == 'PENDING' ? 'warning' : 'danger']]">
                                                                [[getCurrentStatus(item.current_status)]]
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--user card end-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" ng-show="selected_applicant">
                                <div class="row no-gutters">
                                    <div class="">
                                        <div class="card py-4">
                                            <div class="inv-info-top d-flex">
                                                <div class="inv-info-profile">
                                                    <img
                                                        ng-src="[[selected_applicant.staff.display_pic ? selected_applicant.staff.display_pic : '/images/Logo_SmokeShowStaff.png' ]]">
                                                </div>
                                                <div class="inv-info-detail d-flex flex-column">
                                                    <div class="about">
                                                        <h4 class="font-weight-bold">[[selected_applicant.staff.name]]
                                                        </h4>
                                                        <span
                                                            class="font-weight-bold">[[selected_applicant.staff.address.address_line1]]
                                                        </span>
                                                    </div>
                                                    {{-- <div class="d-flex justify-content-between align-items-center">
                                                        <div class="ratings"> <i class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star"></i> <span class="ml-1">4.6</span>
                                                        </div>

                                                    </div> --}}
                                                </div>
                                            </div>
                                            <hr>
                                            <p class="mb-0">[[selected_applicant.staff.resume]]</p>
                                            <hr ng-if="selected_applicant.staff.resume">
                                            <div class="buttons "
                                                ng-if="getCurrentStatus(selected_applicant.current_status) == 'PENDING'">
                                                <a class="btn btn-long btn-light cart " href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_applicant.id, 'rejected', selected_applicant.user_id)">DECLINE</a>
                                                <a class="btn btn-long btn-light cart " href="javascript:void(0)"
                                                    ng-click="acceptApplication()">ACCEPT</a>
                                                <!-- <button class="btn btn-long btn-light buy "> <i class="fa fa-heart"></i> ADD TO SHORTLIST </button>  -->
                                            </div>
                                            <div class="buttons "
                                                ng-if="getCurrentStatus(selected_applicant.current_status) == 'CANCELLED'">
                                                <a class="btn btn-long btn-light cart "
                                                    ng-if="getCurrentStatus(selected_applicant.current_status) == 'CANCELLED'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_applicant.id, 'reinvited', selected_applicant.user_id)">REINVITE</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="app_tab_2" role="tabpanel" aria-labelledby="app_tab_2-invitations">
                        <div class="row pt-3">
                            <div ng-show="job.invitations_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No invitation is sent
                                </h5>
                            </div>
                            <div class="col-md-4 py-3 border border-light">
                                <div class="users-list">
                                    <div ng-click="selectInvitation(item.staff_id)" ng-repeat="item in job.invitations"
                                        class="user-pill d-flex justify-content-between bg-light p-2 my-3 active align-items-center">
                                        <div class="img-col img-col me-2" style="display:contents;">
                                            <img ng-src="[[item.staff.display_pic ? item.staff.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                                style="width:50px;height:50px;"
                                                class="rounded-circle img-thumbnail img-responsive" />
                                        </div>
                                        <div class="info mx-2 flex-fill" style="display: flex;min-width: 0;">
                                            <div class="name text-truncate"><strong
                                                    class="text-capitalize text-truncate">[[item.staff.name]]</strong>
                                            </div>
                                        </div>

                                        <div class="status flex-shrink-1">
                                            <small class="badge border badge-sm pink-text-color">
                                                [[getCurrentStatus(item.current_status)]]
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="display: none" id="invitationChat">
                                <div class="person-detail card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="img-col me-3">
                                                <img class="img-fluid img-thumbnail rounded-circle"
                                                    src="{{asset('images/Logo_SmokeShowStaff.png')}}"
                                                    style="width:100px;height:100px" />
                                            </div>
                                            <div class="detail">
                                                <div class="name mb-1"><strong
                                                        class="text-capitalize text-truncate">[[selected_invitation.staff.name]]</strong>
                                                </div>
                                                <div class="addi-info d-flex align-items-center mb-2">
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-badge text-warning"></i><span
                                                            class="text-capitalize">[[job.title]]</span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-user-alt-5 text-info"></i><span><a
                                                                class="text-decoration-none"
                                                                href="#">[[job.staff_category.title]]</a></span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i
                                                            class="me-2 icofont-ui-calendar text-danger"></i><span>[[convertUtcToLocalDate(job.date)]]</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <div class="buttons ">
                                                <a class="btn"
                                                    ng-if="getCurrentStatus(selected_invitation.current_status) == 'PENDING'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_invitation.id, 'cancelled', selected_invitation.user_id)">Cancel
                                                    Invitation</a>
                                                <a class="btn"
                                                    ng-if="getCurrentStatus(selected_invitation.current_status) == 'CANCELLED'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_invitation.id, 'reinvited', selected_invitation.user_id)">REINVITE</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="msg-box mt-2" ng-if="messages.length > 0">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="chat-content">
                                                <ul class="chatting-area">
                                                    <li class="[[message.source_id == auth_user.id ? 'me' : 'you']]"
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
                                <div class="input-group mt-2 msg-input">
                                    <input type="text" class="form-control" placeholder="Type Message"
                                        ng-model="chat_message">
                                    <button class="btn-sm btn " type="button" ng-click="sendMessage()">Send</button>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3" style="display: none">
                            <div ng-show="job.invitations_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No invitation is sent
                                </h5>
                            </div>
                            <div class="col-md-6">
                                <div class="container p-3 scroll-auto">
                                    <div class="section_our_solution">
                                        <div class="our_solution_category">
                                            <div class="solution_cards_box">
                                                <!--user card start-->
                                                <div class="solution_card inv inv-cancel [[selected_invitation.id == item.id ? 'active' : '']]"
                                                    ng-click="selectInvitation(item.staff_id)"
                                                    ng-repeat="item in job.invitations">
                                                    <div class="hover_color_bubble"></div>
                                                    <div class="title-bar d-flex align-items-center">
                                                        <div class="so_top_icon">
                                                            <img ng-src="[[auth_user.display_pic ? auth_user.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                                alt="pic">
                                                        </div>
                                                        <div class="solu_title ">
                                                            <h3>[[item.staff.name]]</h3>
                                                            {{-- <div
                                                                class="d-flex justify-content-between align-items-center">
                                                                <div class="ratings"> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star rating-color"></i> <i
                                                                        class="fa fa-star"></i> <span
                                                                        class="ml-1">4.6</span></div>

                                                            </div> --}}
                                                        </div>
                                                        <div class="solu_title-rate solu_title">
                                                            <h3>[[convertUtcToLocalDate(item.created_at)]]</h3>
                                                            <small
                                                                class="badge bg-[[getCurrentStatus(item.current_status) == 'PENDING' ? 'warning' : 'danger']]">
                                                                [[getCurrentStatus(item.current_status)]]
                                                            </small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--user card end-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" ng-show="selected_invitation">
                                <div class="row no-gutters">
                                    <div class="">
                                        <div class="card py-4">
                                            <div class="inv-info-top d-flex">
                                                <div class="inv-info-profile">
                                                    <img
                                                        ng-src="[[selected_invitation.staff.display_pic ? selected_invitation.staff.display_pic : '/images/Logo_SmokeShowStaff.png' ]]">
                                                </div>
                                                <div class="inv-info-detail d-flex flex-column">
                                                    <div class="about">
                                                        <h4 class="font-weight-bold">[[selected_invitation.staff.name]]
                                                        </h4>
                                                        <span
                                                            class="font-weight-bold">[[selected_invitation.staff.address.address_line1]]
                                                        </span>
                                                    </div>
                                                    {{-- <div class="d-flex justify-content-between align-items-center">
                                                        <div class="ratings"> <i class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star rating-color"></i> <i
                                                                class="fa fa-star"></i> <span class="ml-1">4.6</span>
                                                        </div>

                                                    </div> --}}
                                                </div>
                                            </div>
                                            <hr>
                                            {{-- <span class="font-weight-bold">Description</span> --}}
                                            <p class="mb-0">[[selected_invitation.staff.resume]]</p>
                                            <hr ng-if="selected_applicant.staff.resume">
                                            <div class="buttons ">
                                                <a class="btn btn-long btn-light cart "
                                                    ng-if="getCurrentStatus(selected_invitation.current_status) == 'PENDING'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_invitation.id, 'cancelled', selected_invitation.user_id)">Cancel
                                                    Invitation</a>
                                                <a class="btn btn-long btn-light cart "
                                                    ng-if="getCurrentStatus(selected_invitation.current_status) == 'CANCELLED'"
                                                    href="javascript:void(0)"
                                                    ng-click="changeJobApplicantStatus(selected_invitation.id, 'reinvited', selected_invitation.user_id)">REINVITE</a>
                                                <!-- <button class="btn btn-long btn-light buy "> <i class="fa fa-heart"></i> ADD TO SHORTLIST </button>  -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="app_tab_3" role="tabpanel" aria-labelledby="app_tab_3-booked">
                        <div class="row pt-3">
                            <div ng-show="job.booked_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No booked staff
                                </h5>
                            </div>
                            <div class="col-md-4 py-3 border border-light">
                                <div class="users-list">
                                    <div ng-click="selectBooked(item.staff_id)" ng-repeat="item in job.booked"
                                        class="cursor-pointer user-pill d-flex justify-content-between bg-light p-2 my-3 active">
                                        <div class="img-col img-col me-2">
                                            <img ng-src="[[item.staff.display_pic ? item.staff.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                                style="width:50px;height:50px;"
                                                class="rounded-circle img-thumbnail img-responsive" />
                                        </div>
                                        <div class="info flex-grow-1">
                                            <div class="name"><strong
                                                    class="text-capitalize text-truncate">[[item.staff.name]]</strong>
                                            </div>
                                        </div>

                                        <div class="status flex-shrink-1">
                                            <small class="badge border badge-sm badge-theme-green">
                                                [[item.current_status ==
                                                'unbooked' ? 'Cancelled' : item.current_status]]
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8" style="display: none" id="bookedChat">
                                <div class="person-detail card bg-light">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="img-col me-3">
                                                <img class="img-fluid img-thumbnail rounded-circle"
                                                    src="{{asset('images/Logo_SmokeShowStaff.png')}}"
                                                    style="width:100px;height:100px" />
                                            </div>
                                            <div class="detail">
                                                <div class="name mb-1"><strong
                                                        class="text-capitalize text-truncate">[[selected_booked.staff.name]]</strong>
                                                </div>
                                                <div class="addi-info d-flex align-items-center mb-2">
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-badge text-warning"></i><span
                                                            class="text-capitalize">[[job.title]]</span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i class="me-2 icofont-user-alt-5 text-info"></i><span><a
                                                                class="text-decoration-none"
                                                                href="#">[[job.staff_category.title]]</a></span>
                                                    </div>
                                                    <div class="me-2">
                                                        <i
                                                            class="me-2 icofont-ui-calendar text-danger"></i><span>[[convertUtcToLocalDate(job.date)]]</span>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            {{-- <button class="btn btn-sm me-2" ng-if="selected_booked.job.job_status == 'open'"><i
                                                    class="icofont-ui-message me-2"></i>Messages</button> --}}
                                            <button style="cursor: default"
                                                ng-if="selected_booked.current_status == 'unbooked'"
                                                class="btn btn-sm me-2"><i class="icofont-ui-close me-2"></i>Booking
                                                Cancelled</button>
                                            <button
                                                ng-if="selected_booked.current_status == 'booked' && (selected_booked.job.job_status == 'open' || selected_booked.job.job_status == 'occupied')"
                                                class="btn btn-sm me-2"
                                                ng-click="changeJobApplicantStatus(selected_booked.id, 'unbooked', selected_booked.job.user_id);">
                                                <i class="icofont-ui-close me-2"></i>
                                                Cancel
                                            </button>
                                            <button
                                                ng-if="selected_booked.current_status == 'booked' && selected_booked.job.job_status != 'open' && selected_booked.job.job_status != 'occupied' && !selected_booked.host_status"
                                                class="btn btn-sm me-2"
                                                ng-click="changeJobApplicantStatus(selected_booked.id, 'completed', selected_booked.job.user_id);">
                                                <i class="icofont-ui-check me-2"></i>
                                                Mark Completed
                                            </button>
                                            <button
                                                ng-if="selected_booked.current_status == 'booked' && selected_booked.job.job_status != 'open' && selected_booked.job.job_status != 'occupied' && !selected_booked.host_status"
                                                class="btn btn-sm me-2"
                                                ng-click="disputeBooking(selected_booked.id, selected_booked.staff);">
                                                <i class="icofont-ui-close me-2"></i>
                                                Dispute
                                            </button>
                                            <button ng-show="showReviewButton"
                                                ng-if="(selected_booked.current_status == 'completed' || selected_booked.current_status == 'disputed') && selected_booked.job.job_status != 'open' && selected_booked.host_status  && !selected_booked.is_applicant_reviewed"
                                                class="btn btn-sm me-2"
                                                ng-click="giveFeedback(selected_booked.job.user, selected_booked.staff, selected_booked.job_id);">
                                                <i class="icofont-star me-2"></i>
                                                Give Feedback
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="msg-box mt-2" ng-if="messages.length > 0">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="chat-content">
                                                <ul class="chatting-area">
                                                    <li class="[[message.source_id == auth_user.id ? 'me' : 'you']]"
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
                                <div class="input-group mt-2 msg-input">
                                    <input type="text" class="form-control" placeholder="Type Message"
                                        ng-model="chat_message">
                                    <button class="btn-sm btn " type="button" ng-click="sendMessage()">Send</button>
                                </div>
                            </div>
                        </div>
                        <div class="row pt-3" style="display: none">
                            <div ng-show="job.booked_count < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    No booked staff
                                </h5>
                            </div>
                            {{-- <div class="table-responsive">
                                <table class="table table-xs mb-0 table-hover">
                                    <thead>
                                        <tr>
                                            <th>EVENT</th>
                                            <th>JOB TITLE</th>
                                            <th>STAFF</th>
                                            <th>DATE</th>
                                            <th>TIME</th>
                                            <th>PAY</th>
                                            <th>STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="item in job.booked">
                                            <td><b>[[item.job.title]]</b></td>
                                            <td>[[item.job.job_title]]</td>
                                            <td>[[item.staff.name]]</td>
                                            <td>[[convertUtcToLocalDate(item.job.date)]]</td>
                                            <td>[[convertUtcToLocalTime(item.job.start_time)]] -
                                                [[convertUtcToLocalTime(item.job.end_time)]]</td>
                                            <td>$[[item.job.pay_rate]] [[item.job.pay_type == 'per_hour' ? 'Per Hour' :
                                                'Per Party']]</td>
                                            <td>
                                                <div>
                                                    <span class="badge badge-theme-green"
                                                        style="text-transform: uppercase">[[item.current_status ==
                                                        'unbooked' ? 'Cancelled' : item.current_status]]</span>
                                                </div>
                                                <div class="mt-2 ">
                                                    <button class="btn btn-sm"><i
                                                            class="icofont-ui-message me-2"></i>Messages</button>
                                                    <button ng-if="item.current_status != 'unbooked'" class="btn btn-sm"
                                                        ng-click="changeJobApplicantStatus(item.id, 'unbooked', item.job.user_id);">
                                                        <i class="icofont-ui-close me-2"></i>
                                                        Cancel
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div> --}}
                            <table ng-show="job.booked_count > 0" class="table table-xs mb-0 table-hover">
                                <thead>
                                    <tr>
                                        <th>EVENT</th>
                                        <th>JOB TITLE</th>
                                        <th>STAFF</th>
                                        <th>DATE</th>
                                        <th>TIME</th>
                                        <th>PAY</th>
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in job.booked">
                                        <td><b>[[item.job.title]]</b></td>
                                        <td>[[item.job.job_title]]</td>
                                        <td>[[item.staff.name]]</td>
                                        <td>[[convertUtcToLocalDate(item.job.date)]]</td>
                                        <td>[[convertUtcToLocalTime(item.job.start_time)]] -
                                            [[convertUtcToLocalTime(item.job.end_time)]]</td>
                                        <td>$[[item.job.pay_rate]] [[item.job.pay_type == 'per_hour' ? 'Per Hour' :
                                            'Per Party']]</td>
                                        <td>
                                            <div>
                                                <span class="badge badge-theme-green"
                                                    style="text-transform: uppercase">[[item.current_status ==
                                                    'unbooked' ? 'Cancelled' : item.current_status]]</span>
                                            </div>
                                            <div class="mt-2 ">
                                                <button class="btn btn-sm" ng-if="item.job.job_status == 'open'"><i
                                                        class="icofont-ui-message me-2"></i>Messages</button>
                                                <button ng-if="item.current_status == 'unbooked'" class="btn btn-sm"><i
                                                        class="icofont-ui-close me-2"></i>Booking
                                                    Cancelled</button>
                                                <button
                                                    ng-if="item.current_status != 'unbooked' && item.job.job_status == 'open'"
                                                    class="btn btn-sm"
                                                    ng-click="changeJobApplicantStatus(item.id, 'unbooked', item.job.user_id);">
                                                    <i class="icofont-ui-close me-2"></i>
                                                    Cancel
                                                </button>
                                                <button
                                                    ng-if="item.current_status == 'booked' && item.job.job_status != 'open' && item.job.job_status != 'occupied' &&  !item.host_status"
                                                    class="btn btn-sm"
                                                    ng-click="changeJobApplicantStatus(item.id, 'completed', item.job.user_id);">
                                                    <i class="icofont-ui-check me-2"></i>
                                                    Mark Completed
                                                </button>
                                                <button
                                                    ng-if="item.current_status == 'booked' && item.job.job_status != 'open' && item.job.job_status != 'occupied' &&  !item.host_status"
                                                    class="btn btn-sm" ng-click="disputeBooking(item.id, item.staff);">
                                                    <i class="icofont-ui-close me-2"></i>
                                                    Dispute
                                                </button>
                                                <button ng-show="showReviewButton"
                                                    ng-if="(item.current_status == 'completed' || item.current_status == 'disputed') && item.job.job_status != 'open' && item.host_status  && !item.job.is_reviewed"
                                                    class="btn btn-sm"
                                                    ng-click="giveFeedback(item.job.user, item.staff, item.job_id);">
                                                    <i class="icofont-star me-2"></i>
                                                    Give Feedback
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/invitations-controller.js') }}"></script>
@endsection