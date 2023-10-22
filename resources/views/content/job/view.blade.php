@extends('layouts.app')
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />
<link rel='stylesheet' href="{{asset('css/find-job/find-job-style.css')}}" media='all' />
@section('content')
<div id="content" class="site-content" ng-controller="jobCtrl"  ng-init="viewJob({{ $job->id }})" ng-cloak class="ng-cloak">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="bg-white">
                    {{-- <ul class="nav nav-tabs tablist nav-fill" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <button class="nav-link active" id="faq_tab_1-tab" data-bs-toggle="tab" data-bs-target="#faq_tab_1" type="button" role="tab" aria-controls="faq_tab_1" aria-selected="true">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-plane-alt'></i> <span>JOB LIST</span> </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="faq_tab_2-tab" data-bs-toggle="tab" data-bs-target="#faq_tab_2" type="button" role="tab" aria-controls="faq_tab_2" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-shopping-bag'></i> <span>REFINE</span> </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" id="faq_tab_3-tab" data-bs-toggle="tab" data-bs-target="#faq_tab_3" type="button" role="tab" aria-controls="faq_tab_3" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bx-check-circle'></i> <span>SHORTLIST</span> </div>
                            </button> </li>
                    </ul> --}}
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="faq_tab_1" role="tabpanel" aria-labelledby="faq_tab_1-tab">
                            <div class="container p-3 scroll-y">
                                <div class="section_our_solution">
                                    <div class="our_solution_category">
                                        <div class="solution_cards_box">
                                            <div class="solution_card">
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
                                                        </strong><small>[[job.no_of_positions-job.occupied_positions]]/[[job.no_of_positions]]</small></div>
                                                </div>
                                                <div class="solu_description" ng-if="auth_user.id && auth_user.is_staff" style="display: none">
                                                    <p>
                                                        [[job.description]]
                                                    </p>
                                                    <button type="button" class="read_more_btn" ng-click="applyJob(job.id)">APPLY</button>
                                                    <button type="button" ng-click="addToShortList(job, 'job')"
                                                        class="read_more_btn shortlistText[[job.id]]">ADD TO SHORTLIST</button>
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
                    <div class="job-detail-card">
                        <div class="card">
                            <div class="card-header bg-dark">
                                <h5 class="card-title d-inline text-white">
                                    [[job.title]]
                                    <small class="float-end">
                                        [[job.no_of_positions-job.occupied_positions]]/[[job.no_of_positions]] Positions Available
                                    </small>
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="charges-col pb-3 border-bottom">
                                            <span class="charges">
                                                <h1 class="text-danger fw-bold mb-0 d-inline">$[[job.pay_rate]]</h1>
                                                <small class="text-muted fw-bold"> [[job.pay_type == 'per_party' ? 'Per
                                                    Party' : 'Per Hour']]</small>
                                            </span>
                                        </div>
                                        <div class="reviews py-3 border-bottom">
                                            <ul class="reviews-listing ms-0 ps-0 mt-2 mb-0 ">
                                                <li class="review">
                                                    <img ng-src="[[job.user.display_pic ? job.user.display_pic  : '/images/alt-pic.png']]" alt=""
                                                        class="img-thumbnail me-1" height="40px" width="40px">
                                                    <i class="fa fa-star text-success"></i>
                                                    <i class="fa fa-star text-success"></i>
                                                    <i class="fa fa-star text-success"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="enquiry-btn pt-3">
                                            <button class="pink-btn text-uppercase">Inquiry</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-7">
                                        <div class="detail py-2 border-bottom">
                                            <h6 class="mb-0 fw-bold text-dark">[[convertUtcToLocalDate(job.date)]]</h6>

                                            <p class="mb-0">[[job.address.address_line1]]</p>
                                            <p class="mb-0">[[job.address.state.name]], [[job.address.suburb]], [[job.address.postal_code]]</p>
                                            <p class="mb-0">[[convertUtcToLocalTime(job.start_time)]] - [[convertUtcToLocalTime(job.start_time)]]</p>
                                            <p class="mb-0">Looking For: [[job.gender == 'male' ? 'Male' : (job.gender ==
                                                'female' ? 'Female' : 'Don`t Care') ]]</p>
                                        </div>
                                        <div class="description py-3 border-bottom">
                                            <p class="mb-0">[[job.description]]</p>
                                        </div>

                                        <div class="action-buttons py-3 border-bottom" ng-if="auth_user.id && auth_user.is_staff && job.job_status == 'open'">
                                            <button class="pink-btn add-to-shortlist-btn text-uppercase shortlistText[[job.id]]" ng-click="addToShortList(job, 'job')">Add to
                                                Shortlist</button>
                                            <button class="pink-btn apply-btn text-uppercase" ng-click="applyJob(job.id)">Apply</button>
                                            <button class="pink-btn reportt-btn text-uppercase" ng-click="contactReport(job.id)">Report</button>
                                            
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

@endsection