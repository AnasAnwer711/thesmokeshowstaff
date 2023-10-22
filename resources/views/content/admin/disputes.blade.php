@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/profile/stepper-horizontal-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/admin/jobs-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='adminDisputesCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">

            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Disputes</h4>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <div class="table-responsive" ng-show="disputes.length > 0">
                                    <table class="table table-xs mb-0 mt-3" id="disputeTable">
                                        <thead>
                                            <tr>
                                                <th>JOB</th>
                                                <th>CONCERN</th>
                                                <th>DISPUTED BY</th>
                                                <th>DISPUTED TO</th>
                                                <th>STATUS</th>
                                                <th>ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="dispute in disputes">
                                                <td class="text-capitalize">[[dispute.job_applicant.job.job_title]]</td>
                                                <td class="text-capitalize text-truncate">[[dispute.concern]]</td>
                                                <td class="text-capitalize">[[dispute.disputer.name]]</td>
                                                <td class="text-capitalize">[[dispute.disputed.name]]</td>
                                                <td class="text-capitalize">[[dispute.status]]</td>
                                                <td>
                                                    <button class="btn ms-1" ng-click="viewDispute(dispute)"><i
                                                            class="fa fa-eye"></i> View</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" ng-show="disputes.length == 0">
                                    <p>No disputes found</p>
                                </div>
                            </div>



                            <!-- Dispute Details -->
                            <div class="row" id="disputeDetail" style="display: none">
                                <div class="row">
                                    <div class="d-flex align-items-center bg-light p-2">
                                        <h5 class="font-weight-bold d-inline flex-fill mb-0">
                                            [[dispute.dispute_title.title]]</h5>
                                        <button class="btn btn-sm" ng-click="viewDisputes()"><i
                                                class="icofont-arrow-left me-1"></i>Back</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col p-2">
                                        <div class="timeline-steps">
                                            <div class="timeline-step">
                                                <div class="timeline-content">
                                                    <!-- <div class="inner-circle"></div> -->
                                                    <div class="img-col">
                                                        <img src="[[dispute.disputer.display_pic || '/images/Logo_SmokeShowStaff.png']]"
                                                            alt="Profile Pic"
                                                            class="img-fluid img-thumbnail rounded-circle pink-text-color"
                                                            style="width:60px;height:60px;border: 3px solid;" />
                                                    </div>
                                                    <h6 class="text-dark">Disputed By</h6>
                                                    <div class="box">
                                                        <div class="name">
                                                            <p class="mb-0 fst-italic">[[dispute.disputer.name]]</p>
                                                        </div>
                                                        <div class="email">
                                                            <p class="mb-0">
                                                                <i class="pink-text-color icofont-email me-1"></i>
                                                                <a class="text-decoration-none text-dark"
                                                                    href="mailto:[[dispute.disputer.email]]">[[dispute.disputer.email]]</a>
                                                            </p>
                                                        </div>
                                                        <div class="phone">
                                                            <p class="mb-0">
                                                                <i class="pink-text-color icofont-phone me-1"></i>
                                                                <a class="text-decoration-none text-dark"
                                                                    href="tel:[[dispute.disputer.phone]]">[[dispute.disputer.phone]]</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="timeline-step">
                                                <div class="timeline-content">
                                                    <!-- <div class="inner-circle"></div> -->
                                                    <div class="img-col">
                                                        <img src="[[dispute.disputed.display_pic || '/images/Logo_SmokeShowStaff.png']]"
                                                            alt="Profile Pic"
                                                            class="img-fluid img-thumbnail rounded-circle pink-text-color"
                                                            style="width:60px;height:60px;border: 3px solid;" />
                                                    </div>
                                                    <h6 class="text-dark">Disputed To</h6>
                                                    <div class="box">
                                                        <div class="name">
                                                            <p class="mb-0 fst-italic">[[dispute.disputed.name]]</p>
                                                        </div>
                                                        <div class="email">
                                                            <p class="mb-0">
                                                                <i class="pink-text-color icofont-email me-1"></i>
                                                                <a class="text-decoration-none text-dark"
                                                                    href="mailto:[[dispute.disputed.email]]">[[dispute.disputed.email]]</a>
                                                            </p>
                                                        </div>
                                                        <div class="phone">
                                                            <p class="mb-0">
                                                                <i class="pink-text-color icofont-phone me-1"></i>
                                                                <a class="text-decoration-none text-dark"
                                                                    href="tel:[[dispute.disputed.phone]]">[[dispute.disputed.phone]]</a>
                                                            </p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="d-flex align-items-center justify-content-center p-2 bg-light">
                                            <h6 class="me-2 text-dark">Concern:</h6>
                                            <p class="mb-0 text-capitalize">[[dispute.concern]]</p>
                                        </div>
                                    </div>
                                </div>
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
<script src="{{ ('/app/admin-disputes-controller.js') }}"></script>
@endsection