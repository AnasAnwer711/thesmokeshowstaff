@extends('content.menu.index')
<style>
    .disabled{
        pointer-events: none;
        cursor: default;
        color: #cb00745c !important;
    }
</style>
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='jobCtrl' ng-init="init();getUserJobs();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Job Dashboard</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="bg-white">
                <div class="section_our_solution">
                    <div class="our_solution_category">
                        <div class="solution_cards_box">
                            <div ng-show="jobs.length < 1" class="col-md-12 text-center p-3 bg-light">
                                <h5>
                                    This page will show the list of Jobs. There are currently no jobs.
                                    Do you want <a href="{{ route('job.create') }}">Post a Job</a> now?
                                </h5>
                            </div>
                            <!--Card Start-->
                            <div ng-repeat="job in jobs" class="solution_card pub-job">
                                <div class="job-card-header"></div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <span ng-if="job.job_status == 'closed'" class="badge bg-pink-color badge-sm">COMPLETED</span>
                                        <div class="title-bar d-flex align-items-center">
                                            <div class="solu_title">
                                                <h3 class="my-2">[[job.title]]</h3>
                                                <small class="text-muted">[[job.job_title]]</small>
                                            </div>
                                            <div class="solu_title-rate solu_title">
                                                <h3 class="my-2">$<span class="amount-count">[[job.pay_rate]]</span></h3>
                                                <small class="text-muted">[[job.pay_type]]</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-lg-4 d-flex justify-content-end">
                                        <div class="action-box d-flex flex-row" data-toggle="tooltip"
                                            data-placement="top" title="View">
                                            <a href="/job/[[job.id]]">
                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                <!--<strong>View</strong>-->
                                            </a>
                                        </div>
                                        <div class="action-box d-flex flex-row" data-toggle="tooltip"
                                            data-placement="top" title="Duplicate">
                                            <a href="/duplicate_job/[[job.id]]">
                                                <i class="fa fa-clone" aria-hidden="true"></i>
                                                <!--<strong>Duplicate</strong>-->
                                            </a>
                                        </div>
                                        <div class="action-box d-flex flex-row" data-toggle="tooltip"
                                            data-placement="top" title="Edit">
                                            <a href="/job/[[job.id]]/edit" class="[[job.job_status == 'open' || job.job_status == 'occupied' ? '' : 'disabled']]">
                                                <i class="fa fa-edit" aria-hidden="true"></i>
                                                <!--<strong>Edit</strong>-->
                                            </a>
                                        </div>
                                        <div class="action-box d-flex flex-row" data-toggle="tooltip"
                                            data-placement="top" title="[[job.status ? 'Unpublish' : 'Publish']]">
                                            <a href="javascript:void(0)" class="[[job.job_status == 'open' || job.job_status == 'occupied' ? '' : 'disabled']]" ng-click="changeJobStatus(job.id, job.status)">
                                                <i class="[[job.status ? 'icofont-ban' : 'icofont-upload']]"
                                                    aria-hidden="true"></i>
                                                <!--<strong>Unpublish</strong>-->
                                            </a>
                                        </div>
                                        <div class="action-box d-flex flex-row" data-toggle="tooltip"
                                            data-placement="top" title="Delete">
                                            <a href="javascript:void(0)" class="[[job.job_status == 'open' || job.job_status == 'occupied' ? '' : 'disabled']]" ng-click="deleteJob(job.id);">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                <!--<strong>Delete</strong>-->
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between my-2">
                                    <div class="job-point"><strong>Date: </strong>
                                        <small>
                                            <span
                                                class="">[[convertUtcToLocalDate(job.date)]]</span>
                                        </small>
                                    </div> |
                                    <div class="job-point"><strong>Duration: </strong>
                                        <small>
                                            <span
                                                class="job-start-time">[[convertUtcToLocalTime(job.start_time)]]</span>
                                            -
                                            <span class="job-end-time">[[convertUtcToLocalTime(job.end_time)]]</span>
                                        </small>
                                    </div> |
                                    <div class="job-point"><strong>Looking For: </strong><small>[[job.gender == 'male' ?
                                            'Male'
                                            : (job.gender == 'female' ? 'Female' : 'Don`t Care') ]]</small></div> |
                                    <div class="job-point"><strong>Positions:
                                        </strong><small>[[job.no_of_positions-job.occupied_positions]]/[[job.no_of_positions]]</small>
                                    </div>
                                </div>
                                <div class="job-adv-detail table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>BOOKINGS</th>
                                                <th>INVITATIONS</th>
                                                <th>APPLICATIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex">
                                                        <span class="value">[[job.booked_count]]</span>
                                                        <a href="invitations/[[job.id]]#app_tab_3"
                                                            class="text-white ml-auto"><span
                                                                class="badge bg-primary "><i class="fa fa-eye"
                                                                    aria-hidden="true"></i> View</span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <span class="value">[[job.invitations_count]]</span>
                                                        <a href="invitations/[[job.id]]#app_tab_2"
                                                            class="text-white ml-auto"><span
                                                                class="badge bg-primary "><i class="fa fa-eye"
                                                                    aria-hidden="true"></i> View</span></a>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex">
                                                        <span class="value">[[job.applications_count]]</span>
                                                        <a href="invitations/[[job.id]]#app_tab_1"
                                                            class="text-white ml-auto"><span
                                                                class="badge bg-primary "><i class="fa fa-eye"
                                                                    aria-hidden="true"></i> View</span></a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--Card End-->


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/job-controller.js') }}"></script>
@endsection