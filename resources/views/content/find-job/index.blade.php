@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/find-job/find-job-style.css')}}" media='all' />
@section('content')
<div id="content" class="site-content" ng-controller="jobCtrl" ng-init="getJobs();getShortlists();" ng-cloak class="ng-cloak">
    <div class="container pt-3" id="refineCtrl" >
        <div class="row">
            <div class="col-md-6">
                <div class="bg-white">
                    <ul class="nav nav-tabs tablist nav-fill m-0" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <button class="nav-link active" id="job_tab_1-list"
                                data-bs-toggle="tab" data-bs-target="#job_tab_1" type="button" role="tab"
                                aria-controls="job_tab_1" aria-selected="true">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-plane-alt'></i> <span>JOB
                                        LIST</span> </div>
                            </button> </li>
                        <li class="nav-item" role="presentation" ng-click="getStates()"> <button class="nav-link" id="job_tab_2-refine"
                                data-bs-toggle="tab" data-bs-target="#job_tab_2" type="button" role="tab"
                                aria-controls="job_tab_2" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-shopping-bag'></i>
                                    <span>REFINE</span>
                                </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="job_tab_3-shortlist"
                                data-bs-toggle="tab" data-bs-target="#job_tab_3" type="button" role="tab"
                                aria-controls="job_tab_3" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bx-check-circle'></i>
                                    <span>SHORTLIST</span>
                                </div>
                            </button> </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="job_tab_1" role="tabpanel"
                            aria-labelledby="job_tab_1-list">
                            <div class="container p-3" style="height: 65vh; overflow: auto;">
                                <div class="section_our_solution">
                                    <div class="our_solution_category">
                                        <div class="solution_cards_box">
                                            <div class="solution_card card-[[job.id]]" ng-repeat="job in jobs"
                                                ng-click="selectedJob(job.id)">
                                                <div class="hover_color_bubble"></div>
                                                <div class="title-bar d-flex align-items-center">
                                                    <div class="so_top_icon">
                                                        <img src="{{ asset('/images/Layer_1.png') }}" alt=""
                                                            width="30px" height="30px">
                                                    </div>
                                                    <div class="solu_title ">
                                                        <h3>[[job.title]]</h3>
                                                        <small class="text-muted">[[job.job_title]]</small>
                                                    </div>
                                                    <div class="solu_title-rate solu_title">
                                                        <h3>$ <span class="amount-count">[[job.pay_rate]]</span></h3>
                                                        <small class="text-muted">[[job.pay_type == 'per_party' ? 'Per
                                                            Party' : 'Per Hour']]</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between my-2">
                                                    <div class="job-point"><strong>Duration: </strong><small><span
                                                                class="job-start-time">[[convertUtcToLocalTime(job.start_time)]]</span>
                                                            - <span
                                                                class="job-end-time">[[convertUtcToLocalTime(job.end_time)]]</span></small>
                                                    </div> |
                                                    <div class="job-point"><strong>Looking For:
                                                        </strong><small>[[job.gender == 'male' ? 'Male' : (job.gender ==
                                                            'female' ? 'Female' : 'Don`t Care') ]]</small></div> |
                                                    <div class="job-point"><strong>Positions:
                                                        </strong>
                                                        <small
                                                            ng-if="job.job_status == 'open'">[[job.no_of_positions-job.occupied_positions]]/[[job.no_of_positions]]</small>
                                                        <small class="badge badge-theme-green text-uppercase"
                                                            ng-if="job.job_status != 'open'">[[job.job_status]]</small>
                                                    </div>
                                                </div>
                                                <div class="solu_description">
                                                    <p>
                                                        [[job.description]]
                                                    </p>
                                                    <div class="d-flex justify-content-end"
                                                        ng-if="auth_user.id && auth_user.is_staff && job.job_status == 'open'">

                                                        <button type="button" class=" btn btn-sm text-white  me-2"
                                                            ng-if="!job.is_applied && !job.is_invited"
                                                            ng-click="invitationConfirmation(job, 'received')">APPLY</button>
                                                        <button type="button" class=" btn btn-sm text-white me-2"
                                                            ng-if="job.is_applied"
                                                            style="cursor: default">APPLIED</button>
                                                        <button type="button" class=" btn btn-sm text-white me-2"
                                                            ng-if="job.is_invited"
                                                            style="cursor: default">INVITED</button>
                                                        <button type="button"
                                                            ng-click="addToShortList(job, 'job');getJobs();getShortlists();"
                                                            class="[[job.is_shortlisted ? 'disabled' : '']] btn btn-sm text-white shortlistText[[job.id]] ">[[job.is_shortlisted
                                                            ? 'ADDED' : 'ADD']] TO SHORTLIST</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="job_tab_2" role="tabpanel" aria-labelledby="job_tab_2-refine">
                            <div class="container p-3" style="height: 65vh; overflow: auto;">
                                <fieldset>
                                    <div class="form-card">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-outline">
                                                    <input type="text" class="form-control"
                                                    ng-model="refineModel.title" value="" required="" placeholder="Search with Event Title">
                                                    <label class="form-label" style="margin-left: 0px;">Title</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-outline">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" id="autocomplete"
                                                            ng-model="refineModel.suburb" value="" required="">
                                                        <input type="hidden" class="form-control"
                                                            ng-model="refineModel.postal_code" value="" required="">
                                                        <input type="hidden" class="form-control"
                                                            ng-model="refineModel.state_id" value="" required="">

                                                        {{-- <input type="text" class="form-control" value="" required=""> --}}
                                                        <label class="form-label"
                                                            style="margin-left: 0px;">Suburb/Postcode</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="card border-0">
                                                    <div class="set-notification d-flex p-2 cursor-pointer">
                                                        <h6 ng-click="toggleallSkill()"
                                                            class="text-white mb-0 flex-grow-1">Job Categories</h6>
                                                        <i class="icofont-caret-down text-white dd-icon"
                                                            ng-click="toggleallSkill()"></i>
                                                    </div>
                                                    <div style="display:none;" class="card-body p-2 all_skills"
                                                        ng-repeat="skill in staff_categories">
                                                        <div class="set-notification p-2 ">
                                                            <h6 class="text-white mb-0">[[skill.title]]</h6>
                                                        </div>
                                                        <div class="demo--content demo--place-center p-2">
                                                            <label ng-repeat="sub_category in skill.sub_categories"
                                                                class="form-control-760 mt-3 mb-0">
                                                                <input type="checkbox" class="skill"
                                                                    name="checkbox-checked-state" ng-model="refineModel.sub_categories[sub_category.title]" />
                                                                [[sub_category.title]]
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mt-2 border-top border-light pt-3">
                                            <button class="btn btn-sm me-2" ng-click="refineModel = {};filterJobs(refineModel);">Reset</button>
                                            <button class="btn btn-sm" ng-click="filterJobs(refineModel);">Search</button>
                                        </div>
                                    </div>
                                </fieldset>


                            </div>
                        </div>
                        <div class="tab-pane fade" id="job_tab_3" role="tabpanel" aria-labelledby="job_tab_3-shortlist">
                            <div class="container p-3" style="height: 65vh; overflow: auto;">
                                <div class="section_our_solution">
                                    <div class="our_solution_category">
                                        <div class="solution_cards_box">
                                            <div class="solution_card card-[[shortlist.id]]" ng-repeat="shortlist in shortlists"
                                                ng-click="selectedJob(shortlist.id)">
                                                <div class="hover_color_bubble"></div>
                                                <div class="title-bar d-flex align-items-center">
                                                    <div class="so_top_icon">
                                                        <img src="{{ asset('/images/Layer_1.png') }}" alt=""
                                                            width="30px" height="30px">
                                                    </div>
                                                    <div class="solu_title ">
                                                        <h3>[[shortlist.title]]</h3>
                                                        <small class="text-muted">[[shortlist.job_title]]</small>
                                                    </div>
                                                    <div class="solu_title-rate solu_title">
                                                        <h3>$ <span class="amount-count">[[shortlist.pay_rate]]</span></h3>
                                                        <small class="text-muted">[[shortlist.pay_type == 'per_party' ? 'Per
                                                            Party' : 'Per Hour']]</small>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between my-2">
                                                    <div class="job-point"><strong>Duration: </strong><small><span
                                                                class="job-start-time">[[convertUtcToLocalTime(shortlist.start_time)]]</span>
                                                            - <span
                                                                class="job-end-time">[[convertUtcToLocalTime(shortlist.end_time)]]</span></small>
                                                    </div> |
                                                    <div class="job-point"><strong>Looking For:
                                                        </strong><small>[[shortlist.gender == 'male' ? 'Male' : (shortlist.gender ==
                                                            'female' ? 'Female' : 'Don`t Care') ]]</small></div> |
                                                    <div class="job-point"><strong>Positions:
                                                        </strong>
                                                        <small
                                                            ng-if="shortlist.job_status == 'open'">[[shortlist.no_of_positions-shortlist.occupied_positions]]/[[shortlist.no_of_positions]]</small>
                                                        <small class="badge badge-theme-green text-uppercase"
                                                            ng-if="shortlist.job_status != 'open'">[[shortlist.job_status]]</small>
                                                    </div>
                                                </div>
                                                <div class="solu_description">
                                                    <p>
                                                        [[shortlist.description]]
                                                    </p>
                                                    <div class="d-flex justify-content-end"
                                                        ng-if="auth_user.id && auth_user.is_staff && shortlist.job_status == 'open'">

                                                        <button type="button" class=" btn btn-sm text-white  me-2"
                                                            ng-if="!shortlist.is_applied && !shortlist.is_invited"
                                                            ng-click="invitationConfirmation(job, 'received')">APPLY</button>
                                                        <button type="button" class=" btn btn-sm text-white me-2"
                                                            ng-if="shortlist.is_applied"
                                                            style="cursor: default">APPLIED</button>
                                                        <button type="button" class=" btn btn-sm text-white me-2"
                                                            ng-if="shortlist.is_invited"
                                                            style="cursor: default">INVITED</button>
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
            </div>
            <div class="col-md-6">
                <div class="map-container">
                    <div class="job-detail-card" style="display: none">
                        <div class="card" ng-if="selected_job">
                            <div class="set-notification p-2">
                                <h5 class="card-title d-inline text-white">
                                    [[selected_job.title]]
                                    <small class="float-end" ng-if="selected_job.job_status == 'open'">
                                        [[selected_job.no_of_positions-selected_job.occupied_positions]]/[[selected_job.no_of_positions]]
                                        Positions Available
                                    </small>
                                    <small class="float-end text-uppercase" ng-if="selected_job.job_status != 'open'">
                                        [[selected_job.job_status]]
                                    </small>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="charges-col pb-3 border-bottom">
                                            <span class="charges">
                                                <h1 class="text-danger fw-bold mb-0 d-inline">$[[selected_job.pay_rate]]
                                                </h1>
                                                <small class="text-muted fw-bold"> [[selected_job.pay_type ==
                                                    'per_party' ? 'Per
                                                    Party' : 'Per Hour']]</small>
                                            </span>
                                        </div>
                                        <div class="reviews py-3 border-bottom">
                                            <ul class="reviews-listing ms-0 ps-0 mt-2 mb-0 ">
                                                <li class="review">
                                                    <img ng-src="[[selected_job.user.display_pic ? selected_job.user.display_pic  : '/images/alt-pic.png']]"
                                                        alt="" class="img-thumbnail me-1" height="40px" width="40px">
                                                    <span>[[selected_job.user.name]]</span>
                                                    <br />
                                                    <i class="fa fa-star text-success"
                                                        ng-repeat="x in [].constructor(selected_job.user.average_rating) track by $index"></i>

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="enquiry-btn pt-3">
                                            <button id="messageBtn" type="button" class="pink-btn text-uppercase"
                                                ng-click="sendInquiry()">Inquiry</button>
                                            <form id="messageForm" style="display:none">
                                                <div class="col-md-12 mt-3">
                                                    <div class="form-outline hasValue">
                                                        <textarea rows="5" cols="50" class="form-control"
                                                            ng-model="$parent.inquiry_message"
                                                            style="height:150px;resize:none" required></textarea>
                                                        <label class="form-label" style="margin-left: 0px;">Message
                                                            <small class="text-danger">*</small></label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-3">
                                                    <div class="form-outline">
                                                        <button type="button" ng-click="sendMessage()"
                                                            class="btn">Send</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="detail py-2 border-bottom">
                                            <h6 class="mb-0 fw-bold text-dark">
                                                [[convertUtcToLocalDate(selected_job.date)]]</h6>

                                            <p class="mb-0">[[selected_job.address.address_line1]]</p>
                                            <p class="mb-0">[[selected_job.address.state.name]],
                                                [[selected_job.address.suburb]], [[selected_job.address.postal_code]]
                                            </p>
                                            <p class="mb-0">[[convertUtcToLocalTime(selected_job.start_time)]] -
                                                [[convertUtcToLocalTime(selected_job.start_time)]]</p>
                                            <p class="mb-0">Looking For: [[selected_job.gender == 'male' ? 'Male' :
                                                (selected_job.gender ==
                                                'female' ? 'Female' : 'Don`t Care') ]]</p>
                                        </div>
                                        <div class="description py-3 border-bottom">
                                            <p class="mb-0">[[selected_job.description]]</p>
                                        </div>

                                        <div class="action-buttons py-3 border-bottom"
                                            ng-if="auth_user.id && auth_user.is_staff && selected_job.job_status == 'open'">
                                            <button
                                                class="[[selected_job.is_shortlisted ? 'disabled' : '']] btn btn-sm add-to-shortlist-btn text-uppercase shortlistText[[selected_job.id]]"
                                                ng-click="addToShortList(selected_job, 'job');getJobs();">[[selected_job.is_shortlisted
                                                ? 'ADDED' : 'ADD']] to
                                                Shortlist</button>
                                            <button class="btn btn-sm apply-btn text-uppercase"
                                                ng-if="!selected_job.is_applied && !selected_job.is_invited"
                                                ng-click="invitationConfirmation(selected_job, 'received')">Apply</button>
                                            <button class="btn btn-sm apply-btn text-uppercase"
                                                ng-if="selected_job.is_applied" style="cursor: default">APPLIED</button>
                                            <button class="btn btn-sm apply-btn text-uppercase"
                                                ng-if="selected_job.is_invited" style="cursor: default">INVITED</button>
                                            <button class="btn btn-sm reportt-btn text-uppercase"
                                                ng-click="contactReport(selected_job.id)">Report</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card my-3">
                        <div class="card-body">
                            <div id="map" style="width:100%; height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascripts')
<script src="{{ ('/app/job-controller.js') }}"></script>
<script src="{{asset('/js/refine-address.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {

});
</script>
@endsection