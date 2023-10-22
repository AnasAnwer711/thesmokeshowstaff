@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='defaultSettingsCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Default Settings</h4>
                </div>
                <ul class="nav tablist nav-tabs nav-fill">
                    <li class="nav-item lh-lg col-md-4 text-uppercase">
                        <a class="nav-link [[currentTab=='Basic Settings' ? 'active' : '']]"
                            ng-click="showTab('Basic Settings')">Basic Settings</a>
                    </li>
                    <li class="nav-item lh-lg col-md-4 text-uppercase">
                        <a class="nav-link [[currentTab=='Payment Configuration' ? 'active' : '']]"
                            ng-click="showTab('Payment Configuration')">Payment Configuration</a>
                    </li>
                    <li class="nav-item lh-lg col-md-4 text-uppercase">
                        <a class="nav-link [[currentTab=='Cancellation Policies' ? 'active' : '']]"
                            ng-click="showTab('Cancellation Policies')">Cancellation Policies</a>
                    </li>
                </ul>
                <div class="card" ng-show="currentTab=='Basic Settings'">
                    <div class="card-body">
                        <div>
                            <form ng-submit="saveBasicSettings()">
                                <div class="row">
                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline">
                                            <button class="text-dark" type="button" ng-click="selectSiteLogo()">Site
                                                Logo</button>
                                            <label class="text-truncate" id="lblLogo"
                                                for="siteLogo">[[basicSettings.logo ? basicSettings.logo : 'Choose
                                                File']]</label>
                                            <input id="siteLogo" accept="image/*" type="file" class="form-control"
                                                value="" onchange="angular.element(this).scope().uploadSiteLogo(this)"
                                                hidden>
                                            <button id="btnRemoveLogo"
                                                class="text-dark bg-transparent border-0 float-end my-1" type="button"
                                                ng-click="removeSiteLogo()" style="display: none"><i
                                                    class="fa fa-close"></i></button>
                                        </div>
                                        <small class="pink-text-color">* Recommended size for logo is 200x200px</small>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline">
                                            <button class="text-dark" type="button" ng-click="selectFavIcon()">Fav
                                                Icon</button>
                                            <label id="lblFavIcon" for="favIcon">[[basicSettings.fav_icon ?
                                                basicSettings.fav_icon : "Choose File"]]</label>
                                            <input id="favIcon" accept="image/*" type="file" class="form-control"
                                                onchange="angular.element(this).scope().uploadFavIcon(this)" hidden>
                                            <button id="btnRemoveFavIcon"
                                                class="text-dark bg-transparent border-0 float-end my-1" type="button"
                                                ng-click="removeFavIcon()" style="display: none"><i
                                                    class="fa fa-close"></i></button>
                                        </div>
                                        <small class="pink-text-color">* Recommended size for fav icon is
                                            50x50px</small>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline">
                                            <button class="text-dark" type="button" ng-click="selectCoverVideo()">Cover
                                                Video</button>
                                            <label id="lblCoverVideo" for="coverVideo">[[basicSettings.cover_video ?
                                                basicSettings.cover_video : "Choose File"]]</label>
                                            <input id="coverVideo" accept="video/*" type="file" class="form-control"
                                                onchange="angular.element(this).scope().uploadCoverVideo(this)" hidden>
                                            <button id="btnRemoveCoverVideo"
                                                class="text-dark bg-transparent border-0 float-end my-1" type="button"
                                                ng-click="removeCoverVideo()" style="display: none"><i
                                                    class="fa fa-close"></i></button>
                                        </div>
                                        <small class="pink-text-color">* Recommended size for video is
                                            1280x720px</small>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline [[basicSettings.name ? 'hasValue' : '']]">
                                            <input title-only type="text" class="form-control"
                                                ng-model="basicSettings.name">
                                            <label class="form-label" style="margin-left: 0px;">Name</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline [[basicSettings.cover_text ? 'hasValue' : '']]">
                                            <input type="text" class="form-control" ng-model="basicSettings.cover_text">
                                            <label class="form-label" style="margin-left: 0px;">Cover Text</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline [[basicSettings.sender_name ? 'hasValue' : '']]">
                                            <input type="text" title-only class="form-control"
                                                ng-model="basicSettings.sender_name">
                                            <label class="form-label" style="margin-left: 0px;">Email Sender
                                                Name</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-outline [[basicSettings.sender_email ? 'hasValue' : '']]">
                                            <input type="email" class="form-control"
                                                ng-model="basicSettings.sender_email">
                                            <label class="form-label" style="margin-left: 0px;">Email Sender
                                                Email</label>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mt-3">
                                        <button type="submit" class="btn float-right">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div>
                            <div class="card-title mt-3 p-2 bg-secondary text-light">Footer Links</div>
                            <div class="row" id="btnAddFooterLink">
                                <div class="col-md-12">
                                    <button type="button" class="btn" ng-click="addSocialLink()"><i
                                            class="fa fa-plus"></i> Add Social Link</button>
                                </div>
                            </div>
                            <div class="row" id="formSocialLink" style="display: none">
                                <div class="col-md-12">
                                    <form ng-submit="saveSocialLink()">
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-outline">
                                                    <button class="text-dark" type="button"
                                                        ng-click="selectSocialLinkIcon()">Icon <small
                                                            class="text-danger">*</small></button>
                                                    <label class="text-truncate" id="lblSocialLinkIcon"
                                                        for="socialLinkIcon">[[socialLink.icon ? socialLink.icon :
                                                        'Choose File']]</label>
                                                    <input id="socialLinkIcon" type="file" class="form-control" value=""
                                                        onchange="angular.element(this).scope().uploadSocialLinkIcon(this)"
                                                        hidden>
                                                    <button id="btnRemoveSocialLinkIcon"
                                                        class="text-dark bg-transparent border-0 float-end my-1"
                                                        type="button" ng-click="removeSocialLinkIcon()"
                                                        style="display:none"><i class="fa fa-close"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[socialLink.title ? 'hasValue' : '']]">
                                                    <input title-only type="text" class="form-control"
                                                        ng-model="socialLink.title">
                                                    <label class="form-label" style="margin-left: 0px;">Title <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[socialLink.url ? 'hasValue' : '']]">
                                                    <input type="text" class="form-control" ng-model="socialLink.url">
                                                    <label class="form-label" style="margin-left: 0px;">URL <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mt-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" ng-true-value="1"
                                                        ng-false-value="0" ng-model="socialLink.is_display">
                                                    <label class="form-check-label">Displayed</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <button type="submit" class="btn ms-1">[[socialLink.id ? 'Update' :
                                                    'Save']]</button>
                                                <button type="button" class="btn ms-1"
                                                    ng-click="cancelSocialLinkForm()">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div ng-show="socialLinks.length > 0" class="table-responsive">
                                    <table class="table table-xs mb-0 mt-3">
                                        <thead>
                                            <tr>
                                                <th>TITLE</th>
                                                <th>URL</th>
                                                <th>ICON</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="link in socialLinks">
                                                <td class="text-capitalize">[[link.title]]</td>
                                                <td>[[link.url]]</td>
                                                <td>[[link.icon]]</td>
                                                <td>
                                                    <button class="btn ms-1" ng-click="editSocialLink(link)"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button class="btn ms-1" ng-click="confirmDeleteSocialLink(link)"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" ng-show="socialLinks.length == 0">
                                    <p>No social links added yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card" ng-show="currentTab=='Payment Configuration'">
                    <div class="card-body">
                        <div>
                            <form ng-submit="savePaymentConfiguration()">
                                <div class="row">
                                    <div class="card-title mt-3 p-2 bg-secondary">
                                        <h6 class="text-light">Payment Configuration <small
                                                class="text-danger">*</small></h6>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.publishable_key ? 'hasValue' : '']]">
                                            <input type="text" class="form-control"
                                                ng-model="paymentConfiguration.publishable_key">
                                            <label class="form-label" style="margin-left: 0px;">Stripe API Key <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="form-outline [[paymentConfiguration.secret_key ? 'hasValue' : '']]">
                                            <input type="text" class="form-control"
                                                ng-model="paymentConfiguration.secret_key">
                                            <label class="form-label" style="margin-left: 0px;">Stripe Secret <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-4 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.currency_id ? 'hasValue' : '']]">
                                            <select class="form-control" ng-model="paymentConfiguration.currency_id">
                                                <option ng-value="" selected>Select Currency </option>
                                                <option ng-repeat="currency in currencies" ng-value="[[currency.id]]">
                                                    [[currency.description]] ([[currency.symbol]])</option>
                                            </select>

                                            <label class="form-label" style="margin-left: 0px">Currency <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="card-title p-2 mt-3 bg-secondary">
                                        <h6 class="text-light">Staff Configuration</h6>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.staff_signup_fee ? 'hasValue' : '']]">
                                            <input type="text" numbers-only ng-trim="false" maxlength="3"
                                                class="form-control" ng-model="paymentConfiguration.staff_signup_fee">
                                            <label class="form-label" style="margin-left: 0px;">Signup Fee
                                                ([[payment_configuration.currency.symbol]])</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.staff_minimum_transaction ? 'hasValue' : '']]">
                                            <input type="number" max="999" class="form-control"
                                                ng-model="paymentConfiguration.staff_minimum_transaction">
                                            <label class="form-label" style="margin-left: 0px;">Minimum Transaction Fee
                                                ([[payment_configuration.currency.symbol]])</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.staff_transaction_type ? 'hasValue' : '']]">
                                            <select class="form-control"
                                                ng-model="paymentConfiguration.staff_transaction_type">
                                                <option value="flat" ng-click="selectStaffTransactionType('flat')">Flat
                                                </option>
                                                <option value="percentage"
                                                    ng-click="selectStaffTransactionType('percentage')">Percentage
                                                </option>
                                            </select>

                                            <label class="form-label" style="margin-left: 0px">Transaction Type <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.staff_transaction_fee ? 'hasValue' : '']]">
                                            <input type="number"
                                                max="[[paymentConfiguration.staff_transaction_type == 'percentage' ? '100' : '999']]"
                                                class="form-control"
                                                ng-model="paymentConfiguration.staff_transaction_fee">
                                            <label class="form-label" style="margin-left: 0px;">Transaction Fee <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" ng-true-value="1"
                                                ng-false-value="0" ng-model="paymentConfiguration.staff_cancellation">
                                            <label class="form-check-label">Cancellation</label>
                                        </div>
                                    </div>

                                    <div class="card-title p-2 mt-3 bg-secondary">
                                        <h6 class="text-light">Host Configuration</h6>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.host_signup_fee ? 'hasValue' : '']]">
                                            <input type="number" max="999" class="form-control"
                                                ng-model="paymentConfiguration.host_signup_fee">
                                            <label class="form-label" style="margin-left: 0px;">Signup Fee
                                                ([[payment_configuration.currency.symbol]])</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.host_minimum_transaction ? 'hasValue' : '']]">
                                            <input type="number" max="999" class="form-control"
                                                ng-model="paymentConfiguration.host_minimum_transaction">
                                            <label class="form-label" style="margin-left: 0px;">Minimum Transaction Fee
                                                ([[payment_configuration.currency.symbol]])</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.host_transaction_type ? 'hasValue' : '']]">
                                            <select class="form-control"
                                                ng-model="paymentConfiguration.host_transaction_type">
                                                <option value="flat" ng-click="selectHostTransactionType('flat')">Flat
                                                </option>
                                                <option value="percentage"
                                                    ng-click="selectHostTransactionType('percentage')">Percentage
                                                </option>
                                            </select>
                                            <label class="form-label" style="margin-left: 0px">Transaction Type <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.host_transaction_fee ? 'hasValue' : '']]">
                                            <input type="number"
                                                max="[[paymentConfiguration.host_transaction_type == 'percentage' ? '100' : '999']]"
                                                class="form-control"
                                                ng-model="paymentConfiguration.host_transaction_fee">
                                            <label class="form-label" style="margin-left: 0px;">Transaction Fee <small
                                                    class="text-danger">*</small></label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div
                                            class="form-outline [[paymentConfiguration.referral_reward ? 'hasValue' : '']]">
                                            <input type="number" max="999" class="form-control"
                                                ng-model="paymentConfiguration.referral_reward">
                                            <label class="form-label" style="margin-left: 0px;">Referral Reward </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" ng-true-value="1"
                                                ng-false-value="0" ng-model="paymentConfiguration.host_cancellation">
                                            <label class="form-check-label">Cancellation</label>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mt-3">
                                        <div class="form-outline">
                                            <button type="submit" class="btn">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card" ng-show="currentTab=='Cancellation Policies'">
                    <div class="card-body">
                        <div>
                            <div class="row" id="btnAddCancellationPolicy">
                                <div class="col-md-12">
                                    <button type="button" class="btn" ng-click="addCancellationPolicy('host')"><i
                                            class="fa fa-plus"></i> Add Host Policy</button>
                                    <button type="button" class="btn" ng-click="addCancellationPolicy('staff')"><i
                                            class="fa fa-plus"></i> Add Staff Policy</button>
                                </div>
                            </div>
                            <div class="row" id="formCancellationPolicy" style="display: none">
                                <div class="col-md-12">
                                    <div class="card-title mt-3 p-2 bg-secondary">
                                        <h6 class="text-light">[[cancellationPolicy.id ? 'Edit' : 'Add']] Cancellation
                                            Policy</h6>
                                    </div>

                                    <form ng-submit="saveCancellationPolicy()">
                                        <div class="row">
                                            <div class="col-md-12 mt-3">
                                                <p>Applied when remaining time is: </p>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[cancellationPolicy.days ? 'hasValue' : '']]">
                                                    <input type="text" maxlength="2" numbers-only ng-trim="false"
                                                        class="form-control" ng-model="cancellationPolicy.days">
                                                    <label class="form-label" style="margin-left: 0px;">Days <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[cancellationPolicy.hours ? 'hasValue' : '']]">
                                                    <input type="text" maxlength="2" numbers-only ng-trim="false"
                                                        class="form-control" ng-model="cancellationPolicy.hours">
                                                    <label class="form-label" style="margin-left: 0px;">Hours <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[cancellationPolicy.rule_type ? 'hasValue' : '']]">
                                                    <select class="form-control"
                                                        ng-model="cancellationPolicy.rule_type">
                                                        <option value="cancel" ng-click="selectUserType('cancel')">
                                                            Cancel</option>
                                                        <option value="no-show" ng-click="selectUserType('no-show')">No
                                                            Show</option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px">Rule Type <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[cancellationPolicy.transaction_type ? 'hasValue' : '']]">
                                                    <select class="form-control"
                                                        ng-model="cancellationPolicy.transaction_type">
                                                        <option value="flat">Flat</option>
                                                        <option value="percentage">Percentage</option>
                                                    </select>

                                                    <label class="form-label" style="margin-left: 0px">Transaction Type
                                                        <small class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[cancellationPolicy.charges ? 'hasValue' : '']]">
                                                    <input type="text" numbers-only ng-trim="false" maxlength="3"
                                                        class="form-control" ng-model="cancellationPolicy.charges">
                                                    <label class="form-label" style="margin-left: 0px;">Charges <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-outline">
                                                    <button type="submit" class="btn">[[cancellationPolicy.id ? 'Update'
                                                        : 'Save']]</button>
                                                    <button type="button" class="btn"
                                                        ng-click="cancelPolicy()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="table-responsive" ng-show="cancellationPolicies.length > 0">
                                    <table class="table table-xs mb-0 mt-3">
                                        <thead>
                                            <tr>
                                                <th>USER</th>
                                                <th>DURATION</th>
                                                <th>CHARGES</th>
                                                <th>RULE</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="policy in cancellationPolicies">
                                                <td class="text-capitalize">[[policy.user_type]]</td>
                                                <td><span ng-if="policy.days">[[policy.days]] day[[policy.days > 1 ? 's'
                                                        : '']]</span> <span ng-if="policy.hours">[[policy.hours]]
                                                        hour[[policy.hours > 1 ? 's' : '']]</span></td>
                                                <td>[[policy.charges]]</td>
                                                <td class="text-capitalize">[[policy.rule_type]]</td>
                                                <td>
                                                    <button class="btn ms-1"
                                                        ng-click="editCancellationPolicy(policy)"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button class="btn ms-1"
                                                        ng-click="confirmDeleteCancellationPolicy(policy)"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" ng-show="cancellationPolicies.length == 0">
                                    <p>No cancellation policy added yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Policy -->
    <div class="modal fade" id="modalDeleteCancellationPolicy" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Policy</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this policy?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideConfirmModal()">No</button>
                    <button type="button" class="btn" ng-click="deleteCancellationPolicy()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Social Icon -->
    <div class="modal fade" id="modalDeleteSocialLink" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Social Link</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this footer link?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideConfirmDeleteSocial()">No</button>
                    <button type="button" class="btn" ng-click="deleteSocialLink()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/default-settings-controller.js') }}"></script>
@endsection