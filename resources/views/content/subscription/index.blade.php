@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/packages-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='subscriptionCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <!-- Modal -->
    <div class="modal fade" id="subscriptionDetail" tabindex="-1" role="dialog" aria-labelledby="subscriptionDetail">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header p-2 d-flex align-items-center justify-content-start">
                    <h5 class="modal-title mb-0 me-2" id="subscriptionDetail">
                        [[detail_subscription.subscription_plan.title]]</h5>
                    <span class="badge-pink badge text-white text-capitalize">[[detail_subscription.status]]</span>
                </div>
                <div class="modal-body p-2">
                    <div class="content">
                        <div class="dflex mb-2 amount me-2">
                            <span class="me-2">Amount: </span>
                            <span>$[[detail_subscription.amount]]</span>
                        </div>
                        <div class="dflex mb-2 subcribed-date">
                            <span class="me-2">Date of Subscription:
                            </span>
                            <span>[[convertUtcToLocalDate(detail_subscription.subscribed_date)]]</span>
                        </div>
                        <div class="dflex mb-2 utilized">
                            <span class="me-2">Utilized Limit:
                            </span>
                            <span>[[detail_subscription.calculated_limit]]% out of 100%</span>
                        </div>
                        <div class="dflex mb-2 subcribed-date">
                            <span class="me-2">Subscription Type:
                            </span>
                            <span
                                class="text-capitalize">[[detail_subscription.subscription_plan.duration_period]]</span>
                        </div>

                        <div class="dflex mb-2 expiration-date">
                            <span class="me-2">Expiration:
                            </span>
                            <span>[[convertUtcToLocalDate(detail_subscription.expiry_date)]]</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="cardSelectionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                    <h4 class="modal-title" id="myModalLabel">Card Selection</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-outline" ng-show="haveCreditDetails">
                                <div class="alert alert-info">
                                    You have been charged for <strong>$[[plan_amount]]</strong>.
                                </div>
                            </div>
                            <div class="form-outline" ng-show="haveNoCreditDetails">
                                <div class="alert alert-info">
                                    You need to link your card to buy a new pack for your bookings. <strong> <a
                                            href="{{route('credit_card.index')}}">Add Card</a></strong>.
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" ng-show="haveCreditDetails">
                            <div class="form-outline">
                                <select class="form-control" ng-model="card_id">
                                    <option value="">Select your card</option>
                                    <option ng-repeat="card in auth_user.cards" ng-value="card.id">
                                        [[card.name]] | **** **** **** [[card.last4]]</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" ng-show="haveCreditDetails">
                    <button type="button" class="btn    " data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn" ng-click="postSubscribe()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="p-3 py-5" ng-show="subscriptionNotExist">
        <div class="row package">
            <div class="col-md-4" ng-repeat="plan in subscription_plans">
                <div id="part[[plan.id]]" class="parts" ng-click="selectPlan(plan.id);">
                    <p class="mt-4 h1"><span class="small">$ </span>[[plan.amount]]</p>
                    <p class="small mb-0">$[[plan.unit_price]] PER BOOKING</p>
                    <hr class="hrline mt-1">
                    <p class="storage h3">[[plan.title]]</p>
                    {{-- <p class="storage h3">Savvy</p> --}}
                    <p class="site h1"><i class="fa fa-check" aria-hidden="true"></i></p>
                    <hr class="mt-1 mb-0">
                    <p class="price">Pack of [[plan.limit]]</p>
                    <small>[[plan.additional_note]]</small> |
                    <small>[[plan.duration_number]] [[plan.duration_period]] Expiry</small>
                    <!-- <button class="buy">Continue <i class="fas fa-arrow-circle-right fa-xs"></i></button> -->
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <a href="javascript:void(0)" class="btn btn-block btnbuy-package" ng-click="subscribe()">BUY PACK</a>
            </div>
        </div>
    </div>
    <div class="p-3 py-5" ng-show="subscriptionExist">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">My Subscriptions</h4>
                <button class="btn btn-sm align-self-end" ng-show="activeSubscriptionNotExist" ng-click="togglePackage();"><i
                        class="icofont-package me-2 "></i>Add New Pack
                </button>
            </div>
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Utilized Limit</th>
                                            <th>Expiry</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="subscription in subscriptions">
                                            <td>[[subscription.title]]</td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: [[subscription.calculated_limit]]%;"
                                                        aria-valuenow="[[subscription.calculated_limit]]"
                                                        aria-valuemin="0" aria-valuemax="100">
                                                        [[subscription.calculated_limit]]%</div>
                                                </div>

                                            </td>
                                            <td>[[convertUtcToLocalDate(subscription.expiry_date)]]</td>
                                            <td><button class="btn btn-sm"
                                                    ng-click="viewSubscriptionDetail(subscription.id)">View
                                                    Details</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div  class="parts active" >
                    <p class="mt-4 h1"><span class="small">$ </span>[[subscription.amount]]</p>
                    <p class="small mb-0">[[subscription.subscription_plan.description]]</p>
                    <hr class="hrline mt-1">
                    <p class="storage h3">[[subscription.title]]</p>
                    <p class="site h1"><i class="fa fa-check" aria-hidden="true"></i></p>
                    <hr class="mt-1 mb-0">
                    <p class="price">Total Limit [[subscription.total_limit]]</p>
                    <p class="h3">Utilized Limit [[subscription.utilized_limit]]</p>
                    <small>[[subscription.subscription_plan.additional_note]]</small> |
                    <small>[[subscription.subscription_plan.duration_number]] [[subscription.subscription_plan.duration_period]] Expiry</small>
                    <br>
                    <small>[[convertUtcToLocalDate(subscription.subscribed_date)]]</small> -
                    <small>[[convertUtcToLocalDate(subscription.expiry_date)]]</small> 
                </div> --}}
            </div>
        </div>
    </div>

    {{-- @include('subscription.card-selection-modal') --}}
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/subscription-controller.js') }}"></script>
@endsection