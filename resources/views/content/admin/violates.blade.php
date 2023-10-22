@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/profile/stepper-horizontal-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/admin/jobs-style.css')}}" media='all' />
@section('main-css')

<style>
.content-box {
    border: 2px solid #71c0c7;
}
</style>

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='adminViolatesCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">

            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Violates</h4>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <div class="text-center" ng-show="violates.length == 0">
                                    <p>No violates found</p>
                                </div>
                                <div class="text-center row" ng-show="violates.length > 0">
                                    <div ng-repeat="violate in violates" class="col-md-4 card mb-2">
                                        <div class="card-body p-0">
                                            <div class="box card px-2 bg-light rounded-sm cursor-pointer">
                                                <a class="text-dark text-decoration-none"
                                                    href="/admin/violates/[[violate.id]]">
                                                    <div class="line text-end">
                                                        <div class="item pink-text-color " style="font-size: 11px;">
                                                            <small>Dated:</small>
                                                            <small>[[violate.created_at ?
                                                                convertUtcToLocalDate(violate.created_at) : '']]</small>
                                                        </div>

                                                    </div>
                                                    <div class="line">
                                                        <div class="d-flex align-items-center ">
                                                            <div class="item">
                                                                <span>Job Title:</span>
                                                                <span>[[violate.user_message.chat.job ?
                                                                    violate.user_message.chat.job.title : '']]</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="line">
                                                        <div class="d-flex align-items-start ">
                                                            <div class="item">
                                                                <span>Violated By:</span>
                                                                <span>[[violate.user.name ? violate.user.name :
                                                                    '']]</span>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="line">
                                                        <div class="d-flex justify-content-end">
                                                            <div class="item">
                                                                <small>Violated Counts:</small>
                                                                <small class="fs-1 fw-bolder fst-italic pink-text-color"
                                                                    style="line-height:0.5rem ;">[[violate.violates_count
                                                                    ?
                                                                    violate.violates_count :
                                                                    '']]</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>


                                            </div>
                                            <!-- <div class="content-box mt-3 px-3">
                                                <a class="pink-text-color text-decoration-none"
                                                    href="/admin/violates/[[violate.id]]">

                                                    <div class="detail d-flex">
                                                        <div class="me-1">
                                                            <h5 class="pink-text-color mb-0">Job Title:</h5>
                                                        </div>
                                                        <div class="text-muted ms-1">
                                                            [[violate.user_message.chat.job ?
                                                            violate.user_message.chat.job.title : '']]
                                                        </div>
                                                    </div>
                                                    <div class="detail d-flex">
                                                        <div class="me-1">
                                                            <h5 class="pink-text-color mb-0">Violated By:</h5>
                                                        </div>
                                                        <div class="text-muted ms-1">
                                                            [[violate.user.name ? violate.user.name : '']]
                                                        </div>
                                                    </div>
                                                    <div class="detail d-flex">
                                                        <div class="me-1">
                                                            <h5 class="pink-text-color mb-0">Violated Count:</h5>
                                                        </div>
                                                        <div class="text-muted ms-1">
                                                            [[violate.violates_count ? violate.violates_count : '']]
                                                        </div>
                                                    </div>
                                                    <div class="detail d-flex">
                                                        <div class="me-1">
                                                            <h5 class="pink-text-color mb-0">Violated Date:</h5>
                                                        </div>
                                                        <div class="text-muted ms-1">
                                                            [[violate.created_at ?
                                                            convertUtcToLocalDate(violate.created_at) : '']]
                                                        </div>
                                                    </div>
                                                </a>
                                            </div> -->
                                        </div>
                                        <!-- <div class="card border-light border flex-fill">
                                        </div> -->
                                    </div>
                                </div>
                            </div>



                            <!-- Dispute Details -->
                            <div class="row" id="disputeDetail" style="display: none">

                                <div class="card job-detail-card col-md-12">
                                    <!-- <h5 class="card-header bg-pink text-white">[[dispute.dispute_title.title]] <span
                                            class="float-end"> <button class="btn btn-sm" ng-click="viewDisputes()"><i
                                                    class="icofont-arrow-left me-1"></i>Back</button></span></h5> -->

                                    <!-- <div class="card-body row">
                                        <div class="card col-md-6">
                                            <h5>DISPUTED BY</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="[[dispute.disputer.display_pic || '/images/Logo_SmokeShowStaff.png']]"
                                                        alt="Profile Pic" class="img-fluid">
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-dark">[[dispute.disputer.name]]</p>
                                                    <p><a
                                                            href="mailto:[[dispute.disputer.email]]">[[dispute.disputer.email]]</a>
                                                    </p>
                                                    <p><i class="icocont-phone"></i><a
                                                            href="tel:[[dispute.disputer.phone]]">[[dispute.disputer.phone]]</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card col-md-6">
                                            <h5>DISPUTED TO</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <img src="[[dispute.disputed.display_pic || '/images/Logo_SmokeShowStaff.png']]"
                                                        alt="Profile Pic" class="img-fluid">
                                                </div>
                                                <div class="col-md-8">
                                                    <p class="text-dark">[[dispute.disputed.name]]</p>
                                                    <p><a
                                                            href="mailto:[[dispute.disputed.email]]">[[dispute.disputed.email]]</a>
                                                    </p>
                                                    <p><a
                                                            href="tel:[[dispute.disputed.phone]]">[[dispute.disputed.phone]]</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <h5>Concern</h5>
                                        <p>[[dispute.concern]]</p>
                                    </div> -->

                                    <div class="card-body px-0 pt-3">
                                        <h5>Job Details</h5>
                                        <h5 class="card-title text-dark">[[job.job_title]]</h5>
                                        <div class="d-flex basic-detail">
                                            <div class="dflex-element"><span class="label"><b><i
                                                            class="icofont-ui-clock"></i></b></span>
                                                <span>[[convertUtcToLocalTime(job.start_time)]] -
                                                    [[convertUtcToLocalTime(job.end_time)]]</span>
                                            </div>
                                            <div class="dflex-element"><span class="label"><b><i
                                                            class="icofont-users-alt-2"></i></b></span>
                                                <span>[[job.occupied_positions]]/[[job.no_of_positions]]</span>
                                            </div>
                                            <div class="dflex-element"><span class="label"><b><i
                                                            class="icofont-dollar"></i></b></span>
                                                <span>[[payment_configuration.currency.symbol]][[job.pay_rate]]/[[job.pay_type=='per_hour'
                                                    ? 'hr' : 'party']]</span>
                                            </div>
                                            <div class="dflex-element flex-grow-1"><span class="label"><b><i
                                                            class="icofont-google-map"></i></b></span>
                                                <span>[[job.location]]</span>
                                            </div>
                                        </div>
                                        <div class="d-flex basic-detail">
                                            <div class="dflex-element flex-grow-1"><span class="label"><b>Job
                                                        Desc:</b></span>
                                                <span>[[job.description]]</span>
                                            </div>
                                        </div>
                                        <div class="card-text job-created-by text-end">
                                            <p><b class="me-1">Posted by:</b><img
                                                    ng-src="[[job.user.display_pic ||'/images/Logo_SmokeShowStaff.png' ]]"
                                                    alt="" /> [[job.user.name]]</p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn float-end" ng-click="showModal()">
                                                Resolve
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Helpful Key -->
    <div class="modal fade" id="modalChangeStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Resolve Dispute</h5>
                </div>
                <div class="modal-body">
                    <div class="form-outline hasValue mt-3">
                        <select class="form-control" ng-model="modalForm.status">
                            <option value="resolved">Resolved</option>
                            <option value="no-issue">Not an Issue</option>
                        </select>
                        <label class="form-label" style="margin-left: 0px;">Status</label>
                    </div>
                    <div class="form-outline hasValue mt-3">
                        <textarea class="form-control" ng-model="modalForm.remarks" value="" required
                            style="min-height: 100px"></textarea>
                        <label class="form-label" style="margin-left: 0px;">Reason</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideModal()">Cancel</button>
                    <button type="button" class="btn" ng-click="resolveDispute()">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/admin-violates-controller.js') }}"></script>
@endsection