@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/applications-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='applicationsCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <!-- Modal -->
    <div class="modal fade" id="cardSelectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
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
    @include('content.applications.extended-modal')

    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Job Dashboard</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="card px-0 pb-0 mb-3">
                <div class="bg-white">
                    <ul class="nav nav-tabs nav-fill tablist" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="app_tab_1-applicants"
                                data-bs-toggle="tab" data-bs-target="#app_tab_1" type="button" role="tab"
                                aria-controls="app_tab_1" aria-selected="true">
                                <div class="d-flex flex-row justify-content-center lh-lg"> <i
                                        class='bx bxs-plane-alt'></i>
                                    <span>APPLICATIONS SENT ([[applications.length]])</span>
                                </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="app_tab_2-invitations"
                                data-bs-toggle="tab" data-bs-target="#app_tab_2" type="button" role="tab"
                                aria-controls="app_tab_2" aria-selected="false">
                                <div class="d-flex flex-row justify-content-center lh-lg"> <i
                                        class='bx bxs-shopping-bag'></i> <span>INVITATIONS RECEIVED
                                        ([[invitations.length]])</span> </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="app_tab_3-booked"
                                data-bs-toggle="tab" data-bs-target="#app_tab_3" type="button" role="tab"
                                aria-controls="app_tab_3" aria-selected="false">
                                <div class="d-flex flex-row justify-content-center lh-lg"> <i
                                        class='bx bx-check-circle'></i> <span>BOOKED JOBS ([[bookings.length]])</span>
                                </div>
                            </button> </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade mt-2" id="app_tab_1" role="tabpanel"
                            aria-labelledby="faq_tab_1-tab app_tab_1-applicant">
                            <div class="row pt-3">
                                <div class="table-responsive-md">
                                    <div ng-show="applications.length < 1" class="col-md-12 text-center p-3 bg-light">
                                        <h5>
                                            No application is sent
                                        </h5>
                                    </div>
                                    <table ng-hide="applications.length < 1"
                                        class="table table-xs mb-0 table-hover table-striped">
                                        <thead>
                                            <tr>
                                                <th>EVENT</th>
                                                <th>JOB TITLE</th>
                                                <th>DATE</th>
                                                <th>TIME</th>
                                                <th>PAY</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat="item in applications">
                                            <tr>
                                                <td><b>[[item.job.title]]</b></td>
                                                <td>[[item.job.job_title]]</td>
                                                <td>[[convertUtcToLocalDate(item.job.date)]]</td>
                                                <td>[[convertUtcToLocalTime(item.job.start_time)]] -
                                                    [[convertUtcToLocalTime(item.job.end_time)]]</td>
                                                <td>$[[item.job.pay_rate]] [[item.job.pay_type == 'per_hour' ? 'Per
                                                    Hour' : 'Per Party']]</td>
                                                <td>
                                                    <div>
                                                        <span
                                                            class="badge bg-[[getCurrentStatus(item.current_status) == 'PENDING' ? 'warning' : 'danger']]">[[getCurrentStatus(item.current_status)]]</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="mt-2 d-flex justify-content-end align-items-center ">
                                                        <button class="btn btn-sm me-2"
                                                            ng-click="openMessages(item.job.id)">
                                                            <i class="icofont-ui-message me-2"></i>Messages
                                                        </button>
                                                        <button class="btn btn-sm"
                                                            ng-click="changeJobApplicantStatus(item.id, 'cancelled', item.staff.id)"><i
                                                                class="icofont-ui-close me-2"></i>Cancel</button>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-2" id="app_tab_2" role="tabpanel"
                            aria-labelledby="app_tab_2-invitations faq_tab_2-tab">
                            <div class="row pt-3">
                                <div class="table-responsive-md">
                                    <div ng-show="invitations.length < 1" class="col-md-12 text-center p-3 bg-light">
                                        <h5>
                                            No invitation is received
                                        </h5>
                                    </div>
                                    <table ng-hide="invitations.length < 1" class="table table-xs mb-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th>EVENT</th>
                                                <th>JOB TITLE</th>
                                                <th>DATE</th>
                                                <th>TIME</th>
                                                <th>PAY</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat="item in invitations">
                                            <tr>
                                                <td><b>[[item.job.title]]</b></td>
                                                <td>[[item.job.job_title]]</td>
                                                <td>[[convertUtcToLocalDate(item.job.date)]]</td>
                                                <td>[[convertUtcToLocalTime(item.job.start_time)]] -
                                                    [[convertUtcToLocalTime(item.job.end_time)]]</td>
                                                <td>$[[item.job.pay_rate]] [[item.job.pay_type == 'per_hour' ? 'Per
                                                    Hour' : 'Per Party']]</td>
                                                <td>
                                                    <div>
                                                        <span
                                                            class="badge bg-[[getCurrentStatus(item.current_status) == 'PENDING' ? 'warning' : 'danger']]">[[getCurrentStatus(item.current_status)]]</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="mt-2 d-flex justify-content-end align-items-center ">
                                                        <button class="btn btn-sm me-2"
                                                            ng-click="openMessages(item.job.id)">
                                                            <i class="icofont-ui-message me-2"></i>Messages
                                                        </button>
                                                        <div class="d-flex"
                                                            ng-if="getCurrentStatus(item.current_status) == 'PENDING'">
                                                            <button class="btn btn-sm me-2"
                                                                ng-click="changeJobApplicantStatus(item.id, 'cancelled', item.staff.id)">
                                                                <i class="icofont-ui-close me-2"></i>Cancel
                                                            </button>
                                                            <button class="btn btn-sm me-2"
                                                                ng-click="acceptApplication(item)">
                                                                <i class="icofont-ui-check me-2"></i>Accept
                                                            </button>
                                                            <button class="btn btn-sm"
                                                                ng-click="changeJobApplicantStatus(item.id, 'rejected', item.staff.id)">
                                                                <i class="icofont-ban me-2"></i>Decline
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade mt-2" id="app_tab_3" role="tabpanel"
                            aria-labelledby="app_tab_3-booked faq_tab_3-tab">
                            <div class="row pt-3">
                                <div class="table-responsive-md">
                                    <div ng-show="bookings.length < 1" class="col-md-12 text-center p-3 bg-light">
                                        <h5>
                                            No job is booked
                                        </h5>
                                    </div>
                                    <table ng-hide="bookings.length < 1" class="table table-xs mb-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th>EVENT</th>
                                                <th>JOB TITLE</th>
                                                <th>DATE</th>
                                                <th>TIME</th>
                                                <th>PAY</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat="item in bookings">
                                            <tr>
                                                <td><b>[[item.job.title]]</b></td>
                                                <td>[[item.job.job_title]]</td>
                                                <td>[[convertUtcToLocalDate(item.job.date)]]</td>
                                                <td>[[convertUtcToLocalTime(item.job.start_time)]] -
                                                    [[convertUtcToLocalTime(item.job.end_time)]]</td>
                                                <td>$[[item.job.pay_rate]] [[item.job.pay_type == 'per_hour' ? 'Per
                                                    Hour' :
                                                    'Per Party']]</td>
                                                <td>
                                                    <div>
                                                        <span class="badge badge-theme-green"
                                                            style="text-transform: uppercase">[[item.current_status ==
                                                            'unbooked' ? 'Cancelled' : item.current_status]]</span>
                                                    </div>

                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="mt-2 d-flex justify-content-end align-items-center ">
                                                        <button ng-click="openMessages(item.job.id)"
                                                            class="btn btn-sm me-2"
                                                            ng-if="item.job.job_status == 'open' || item.job.job_status == 'occupied'"><i
                                                                class="icofont-ui-message me-2"></i>Messages</button>
                                                        <button
                                                            ng-if="item.current_status == 'booked' && (item.job.job_status == 'open' || item.job.job_status == 'occupied')"
                                                            class="btn btn-sm me-2"
                                                            ng-click="changeJobApplicantStatus(item.id, 'unbooked', item.staff_id);"><i
                                                                class="icofont-ui-close me-2"></i>Cancel</button>
                                                        <button
                                                            ng-if="item.current_status == 'booked' && item.job.job_status != 'open' && item.job.job_status != 'occupied' && !item.staff_status"
                                                            class="btn btn-sm me-2"
                                                            ng-click="changeJobApplicantStatus(item.id, 'completed', item.job.user_id);">
                                                            <i class="icofont-ui-check me-2"></i>
                                                            Mark Completed
                                                        </button>
                                                        <button
                                                            ng-if="item.current_status == 'booked' && item.job.job_status != 'open' && item.job.job_status != 'occupied' &&  !item.staff_status"
                                                            class="btn btn-sm me-2"
                                                            ng-click="disputeBooking(item.id, item.job.user);">
                                                            <i class="icofont-ui-close me-2"></i>
                                                            Dispute
                                                        </button>
                                                        <button
                                                            ng-if="item.job_pay_type == 'per_hour' && !item.job_extended_hours && (item.current_status == 'booked' && item.job.job_status != 'open' && item.job.job_status != 'occupied' &&  !item.staff_status)"
                                                            class="btn btn-sm me-2" ng-click="extendedHours(item);">
                                                            <i class="icofont-external me-2"></i>
                                                            Extended
                                                        </button>
                                                        <button ng-show="showReviewButton"
                                                            ng-if="(item.current_status == 'completed' || item.current_status == 'disputed') && item.job.job_status != 'open' && item.staff_status  && !item.job.is_reviewed"
                                                            class="btn btn-sm "
                                                            ng-click="giveFeedback(item.staff, item.job.user, item.job_id);">
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
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/applications-controller.js') }}"></script>
@endsection