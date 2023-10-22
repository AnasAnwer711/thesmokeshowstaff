@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='adminSubscriptionPlansCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Subscription Plans</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row" id="btnAddSubscriptionPlan">
                                <div class="col-md-12">
                                    <button type="button" class="btn" ng-click="addSubscriptionPlan()"><i
                                            class="fa fa-plus"></i> Add Subscription Plan</button>
                                </div>
                            </div>
                            <div class="row" id="formSubscriptionPlan" style="display: none">
                                <div class="col-md-12">
                                    <div class="card-title mt-3 p-2 bg-secondary">
                                        <h6 class="text-light">[[subscriptionPlan.id ? 'Edit' : 'Add']] Subscription
                                            Plan</h6>
                                    </div>

                                    <form ng-submit="saveSubscriptionPlan()">
                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[subscriptionPlan.title ? 'hasValue' : '']]">
                                                    <input type="text" title-only class="form-control"
                                                        ng-model="subscriptionPlan.title">
                                                    <label class="form-label" style="margin-left: 0px;">Title <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <!-- <div class="col-md-4 mt-3">
                                                <div class="form-outline [[subscriptionPlan.description ? 'hasValue' : '']]">
                                                    <input type="text" class="form-control" ng-model="subscriptionPlan.description"
                                                        >
                                                    <label class="form-label" style="margin-left: 0px;">Description</label>
                                                </div>
                                            </div> -->

                                            <div class="col-md-8 mt-3">
                                                <div
                                                    class="form-outline [[subscriptionPlan.additional_note ? 'hasValue' : '']]">
                                                    <input type="text" class="form-control"
                                                        ng-model="subscriptionPlan.additional_note">
                                                    <label class="form-label" style="margin-left: 0px;">Additional
                                                        Note</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[subscriptionPlan.duration_period ? 'hasValue' : '']]">
                                                    <select class="form-control"
                                                        ng-model="subscriptionPlan.duration_period">
                                                        <option value="week">Week</option>
                                                        <option value="month">Month</option>
                                                        <option value="year">Year</option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px">Period <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[subscriptionPlan.duration_number ? 'hasValue' : '']]">
                                                    <input type="text" numbers-only ng-trim="false" maxlength="2"
                                                        class="form-control"
                                                        ng-model="subscriptionPlan.duration_number">
                                                    <label class="form-label" style="margin-left: 0px;">Duration Number
                                                        <small class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[subscriptionPlan.amount ? 'hasValue' : '']]">
                                                    <input type="text" numbers-only ng-trim="false" maxlength="3"
                                                        class="form-control" ng-model="subscriptionPlan.amount">
                                                    <label class="form-label" style="margin-left: 0px;">Amount
                                                        ([[payment_configuration.currency.symbol]]) <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[subscriptionPlan.limit ? 'hasValue' : '']]">
                                                    <input type="text" numbers-only ng-trim="false" maxlength="3"
                                                        class="form-control" ng-model="subscriptionPlan.limit">
                                                    <label class="form-label" style="margin-left: 0px;">Limit <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[subscriptionPlan.status ? 'hasValue' : '']]">
                                                    <select class="form-control" ng-model="subscriptionPlan.status">
                                                        <option value="active">Active</option>
                                                        <option value="inactive">Inactive</option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px">Status <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-outline">
                                                    <button type="submit" class="btn">[[subscriptionPlan.id ? 'Update' :
                                                        'Save']]</button>
                                                    <button type="button" class="btn"
                                                        ng-click="cancelForm()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="table-responsive" ng-show="subscriptionPlans.length > 0">
                                    <table class="table table-xs mb-0 mt-3">
                                        <thead>
                                            <tr>
                                                <th>TITLE</th>
                                                <th>DURATION</th>
                                                <th>AMOUNT ([[payment_configuration.currency.symbol]])</th>
                                                <th>LIMIT</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="plan in subscriptionPlans">
                                                <td class="text-capitalize">[[plan.title]]</td>
                                                <td class="text-capitalize">[[plan.duration_number]]
                                                    [[plan.duration_period]][[plan.duration_number > 1 ? 's' : '']]</td>
                                                <td class="text-capitalize">[[plan.amount]]</td>
                                                <td class="text-capitalize">[[plan.limit]]</td>
                                                <td>
                                                    <button class="btn ms-1" ng-click="editSubscriptionPlan(plan)"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button class="btn ms-1"
                                                        ng-click="confirmDeleteSubscriptionPlan(plan)"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center">
                                    <p>No subscription plans added yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Subscription Plan -->
    <div class="modal fade" id="modalDeleteSubscriptionPlan" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Subscription Plan</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this subscription plan?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideConfirmModal()">No</button>
                    <button type="button" class="btn" ng-click="deleteSubscriptionPlan()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/admin-subscription-plans-controller.js') }}"></script>
@endsection