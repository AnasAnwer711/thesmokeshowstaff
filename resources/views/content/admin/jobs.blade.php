@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/admin/jobs-style.css')}}" media='all' />
<!-- <link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' /> -->
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='jobCtrl' ng-init="getJobs();" ng-cloak class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" ng-hide="view_job" class="flex-fill mb-0">Jobs</h4>
                    <div class="form-group" ng-hide="view_job">
                        <select class="form-control" ng-change="filterJobs({'job_status':refineModel.job_status})" ng-model="refineModel.job_status">
                            <option value="" disabled selected>Filter job with status</option>
                            <option value="open">open</option>
                            <option value="occupied">occupied</option>
                            <option value="started">started</option>
                            <option value="elapsed">elapsed</option>
                            <option value="closed">closed</option>

                        </select>
                    </div>
                </div>

                <div class="card" ng-hide="view_job">
                    <div class="card-body">
                        <div class="active-member">
                            <div class="table-responsive" ng-show="jobs.length > 0">
                                <table class="table table-xs mb-0">
                                    <thead>
                                        <tr>
                                            <th>TITLE</th>
                                            <th>GENDER</th>
                                            <th>STAFF CATEGORY</th>
                                            <th>DATE</th>
                                            <th>STATUS</th>
                                            <th>ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="job in jobs">
                                            <td>[[job.title]]</td>
                                            <td>[[job.gender]]</td>
                                            <td>[[job.job_title]]</td>
                                            <td>[[convertUtcToLocalDate(job.date)]]</td>
                                            <td>[[job.job_status]]</td>
                                            <td><button ng-click="showSelectedJobCard(job.id)" class="btn btn-sm">View
                                                    Job</button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center" ng-show="jobs.length == 0">
                                <p>No jobs found</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card job-detail-card" ng-show="view_job">
                    <h5 class="card-header bg-pink text-white">[[selected_job.title]] <span class="float-end"> <button
                                class="btn btn-sm" ng-click="hideSelectedJobCard()"><i
                                    class="icofont-arrow-left me-2"></i>Back</button></span></h5>
                    <div class="card-body px-0 pt-3">
                        <h5 class="card-title text-dark">[[selected_job.job_title]] <span><i ng-click="showMessages()" class="icofont-ui-message pink-text-color float-end" style="font-size: 20px;"></i></span></h5>
                        <div class="d-flex basic-detail">
                            <div class="dflex-element"><span class="label"><b><i
                                            class="icofont-ui-calendar"></i></b></span>
                                <span>[[convertUtcToLocalDate(selected_job.date)]]</span>
                            </div>
                            <div class="dflex-element"><span class="label"><b><i
                                            class="icofont-ui-clock"></i></b></span>
                                <span>[[convertUtcToLocalTime(selected_job.start_time)]] -
                                    [[convertUtcToLocalTime(selected_job.end_time)]]</span>
                            </div>
                            <div class="dflex-element"><span class="label"><b><i
                                            class="icofont-users-alt-2"></i></b></span>
                                <span>[[selected_job.occupied_positions]]/[[selected_job.no_of_positions]]</span>
                            </div>
                            <div class="dflex-element"><span class="label"><b><i class="icofont-dollar"></i></b></span>
                                <span>[[payment_configuration.currency ? payment_configuration.currency.symbol : '$']][[selected_job.pay_rate]]/[[selected_job.pay_type=='per_hour'
                                    ? 'hr' : 'party']]</span>
                            </div>
                            <div class="dflex-element flex-grow-1"><span class="label"><b><i
                                            class="icofont-google-map"></i></b></span>
                                <span>[[selected_job.location]]</span>
                            </div>
                        </div>
                        <div class="d-flex basic-detail">
                            <div class="dflex-element flex-grow-1"><span class="label"><b>Job Desc:</b></span>
                                <span>[[selected_job.description]]</span>
                            </div>
                        </div>
                        <div class="card-text job-created-by text-end">
                            <p><b class="me-1">Posted by:</b><img
                                    ng-src="[[selected_job.user.display_pic || '/images/Logo_SmokeShowStaff.png' ]]"
                                    alt="" /> [[selected_job.user.name]]</p>
                        </div>
                    </div>

                    <div class="card-body px-0 pt-3 staff-detail">
                        <h5 class="card-title text-dark">Booked Staff ([[selected_job.booked_applicants.length]])</h5>
                        <table class="table table-xs table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Book Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="user in selected_job.booked">
                                    <td><span><img style="width: 30px;height: 30px;border-radius: 25px; ;"
                                                ng-src="[[user.staff.display_pic ? user.staff.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                alt=""></span><span>[[user.staff.name]]</span></td>
                                    <td>[[convertUtcToLocalDate(user.created_at)]]</td>
                                    <td><span class="badge bg-pink-color text-uppercase">[[user.current_status]]</span>
                                    </td>
                                    <td><button class="btn btn-sm" ng-click="showNoShowModal(user)">No Show</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="card-body px-0 pt-3 staff-detail">
                        <h5 class="card-title text-dark">Pending Requests ([[selected_job.applicant_users.length]])</h5>
                        <table class="table table-xs table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Staff</th>
                                    <th>Book Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="user in selected_job.not_booked">
                                    <td><span><img style="width: 30px;height: 30px;border-radius: 25px; ;"
                                                ng-src="[[user.display_pic ? user.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                alt=""></span><span>[[user.staff.name]]</span></td>
                                    <td>[[convertUtcToLocalDate(user.created_at)]]</td>
                                    <td><span
                                            class="badge bg-pink-color text-uppercase">[[user.current_status]]</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-body px-0 pt-3 earning-detail" ng-show="view_job">
                    <h5 class="card-title text-dark">Smokeshow Earnings</h5>
                    <table class="table table-xs table-striped table-hover">
                        <thead>
                            <!-- <tr class="table-iner-title"><th colspan="4">Earn From Posted Job <small>10% of job rate</small></th></tr> -->
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Payment Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>[[selected_job.user.name]]</td>
                                <td>Hirestaff</td>
                                <th>Paid</th>
                                <th>@[[payment_configuration.host_transaction_fee]]$/per applicant</th>
                                <th>[[selected_job.booked_applicants.length]]</th>
                                <th>[[payment_configuration.host_transaction_fee * selected_job.booked_applicants.length]]$</th>
                            </tr>

                            <tr ng-repeat="user in selected_job.booked_applicants">
                                <td>[[user.staff.name]]</td>
                                <td>Staff</td>
                                <th>Pending</th>
                                <th>@[[user.job_pay_rate]]$/[[user.job_pay_type=='per_hour' ? 'hr' : 'party']]</th>
                                <th>[[user.job_pay_type=='per_hour' ? user.job_actual_hours : 1]]</th>
                                <th>[[user.job_pay]]$</th>
                            </tr>

                            <tr>
                                <td colspan="5">Total</td>
                                <th>[[(selected_job.booked_applicants.length * payment_configuration.host_transaction_fee) +
                                    (selected_job.booked_applicants.length * selected_job.pay_rate *
                                    selected_job.duration)]]$</th>
                            </tr> -->
                            <tr ng-repeat="earning in earnings">
                                <td class="text-capitalize">[[earning.name]]</td>
                                <td class="text-capitalize">[[earning.type]]</td>
                                <td class="text-capitalize">[[earning.payment_status]]</td>
                                <td>[[payment_configuration.currency ? payment_configuration.currency.symbol : '$']][[earning.total]]</td>
                            </tr>

                            <tr>
                                <td colspan="3">Total</td>
                                <td>[[payment_configuration.currency ? payment_configuration.currency.symbol : '$']][[total_earnings  | number : 2]]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="row" ng-show="view_job">
                    <div class="col-md-12 mt-3 d-flex justify-content-end">
                        <!-- <button class="btn btn-sm me-2" ng-click="markCompleted()">Mark as Completed</button> -->
                        <button ng-if="selected_job.job_status != 'closed'" class="btn btn-sm" ng-click="confirmClose()">Mark as Closed</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Confirm Job Close Modal -->
    <div class="modal fade" id="confirmCloseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Job Close</h5>
                </div>
                <div class="modal-body">
                    <span class="">
                        <div class="demo--content demo--place-center mt-3">
                            <label class="form-control-760">
                                <input type="checkbox" name="checkbox-checked-state"
                                    ng-checked="closeForm.option == 'completed'"
                                    ng-click="selectOption('completed')">Complete
                            </label>
                        </div>
                    </span>

                    <span class="">
                        <div class="demo--content demo--place-center mt-3">
                            <label class="form-control-760">
                                <input type="checkbox" name="checkbox-checked-state"
                                    ng-checked="closeForm.option == 'refund'" ng-click="selectOption('refund')">Refund
                            </label>
                        </div>
                    </span>

                    <span class="">
                        <div class="demo--content demo--place-center mt-3">
                            <label class="form-control-760">
                                <input type="checkbox" name="checkbox-checked-state"
                                    ng-checked="closeForm.option == 'penalize'"
                                    ng-click="selectOption('penalize')">Event
                                Not Organized
                            </label>
                        </div>
                    </span>

                    <!-- Reason -->
                    <div class="form-outline [[closing_reason ? 'hasValue' : '']] mt-3">
                        <textarea class="form-control" ng-model="closing_reason" value="" required
                            style="min-height: 100px" ng-model="closeForm.reason"></textarea>
                        <label class="form-label" style="margin-left: 0px;">Reason</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideCloseModal()">No</button>
                    <button type="button" class="btn" ng-click="markClose()">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmNoShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Status Change</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this job as 'no-show' ?</p>

                    <p>Doing this will apply staff cancellation policy on [[selected_staff.staff.name]]. Also the
                        booking amount ([[payment_configuration.currency ? payment_configuration.currency.symbol : '$']][[selected_staff.host_fee]]) will be
                        refunded to the [[selected_job.user.name]]</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideNoShowModal()">No</button>
                    <button type="button" class="btn" ng-click="noShow()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js-controller')
<script src="{{ ('/app/job-controller.js') }}"></script>
@endsection