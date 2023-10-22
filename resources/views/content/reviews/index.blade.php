@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/reviews-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='reviewsCtrl' ng-init="init();" ng-cloak class="ng-cloak">
    @include('content.applications.feedback-modal')

    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Reviews</h4>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="col-md-12">
                <div class="bg-white">
                    <ul class="nav nav-tabs tablist nav-fill" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation"> <button class="nav-link active" id="faq_tab_2-tab"
                                data-bs-toggle="tab" data-bs-target="#faq_tab_2" type="button" role="tab"
                                aria-controls="faq_tab_2" aria-selected="false">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-shopping-bag'></i>
                                    <span>Rating ([[reviews_count]])</span>
                                </div>
                            </button> </li>
                        <li class="nav-item" role="presentation"> <button class="nav-link" ng-click="activeProfileTab()"
                                id="faq_tab_1-tab" data-bs-toggle="tab" data-bs-target="#faq_tab_1" type="button"
                                role="tab" aria-controls="faq_tab_1" aria-selected="true">
                                <div class="d-flex flex-column lh-lg"> <i class='bx bxs-plane-alt'></i>
                                    <span>My Reviews ([[my_reviews_count]])</span>
                                </div>
                            </button> </li>

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="faq_tab_2" role="tabpanel"
                            aria-labelledby="faq_tab_2-tab">
                            <div class="card mt-2">
                                <div class="comment-section">
                                    <div ng-repeat="review in reviews">

                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="img-col" style="display:contents">
                                                <img src="[[review.source.display_pic ? review.source.display_pic : '/images/alt-pic.png']]"
                                                    class="rounded-circle profile-image img-fluid img-thumbnail" width="80" height="80">
                                            </div>
                                            <div class="comments ms-2">
                                                <div ng-if="review.rating > 0" class="ratings">
                                                    <i class="fa fa-star [[($index+1) <= review.rating ? 'rating-color' : '']]"
                                                        ng-repeat="x in [].constructor(5) track by $index"></i>
                                                </div>
                                                <div class="username"> <strong>[[review.job.title]]</strong></div>
                                                <div class="username">[[review.source.name]]</div>
                                                <div>
                                                    <p class="mb-0" style="font-size: 14px; word-break: break-word;">[[review.comments]]</p>
                                                    <small
                                                        class="font-style-italic text-muted d-block">[[convertUtcToLocalDate(review.created_at)]]</small>
                                                </div>
                                            </div>
                                            {{-- <div class="name flex-grow-1">
                                                <div ng-if="review.rating > 0" class="ratings">
                                                    <i class="fa fa-star [[($index+1) <= review.rating ? 'rating-color' : '']]"
                                                        ng-repeat="x in [].constructor(5) track by $index"></i>
                                                </div>
                                                <div class="username my-2">[[review.source.name]]</div>
                                            </div>
                                            <div class="date">
                                                <span
                                                    class="text-muted">[[convertUtcToLocalDate(review.created_at)]]</span>
                                            </div> --}}

                                            {{-- <div class="d-flex flex-row align-items-center">
                                                
                                                <div class="ratings-col d-flex justify-content-center my-1 align-items-center" ng-if="review.source.average_rating > 0">
                                                    <div class="ratings">
                                                        <i class="fa fa-star [[($index+1) <= review.source.average_rating ? 'rating-color' : '']]" ng-repeat="x in [].constructor(5) track by $index"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ml-1 comment-profile">
                                                    <span class="username">[[review.source.name]]</span>
                                                </div>
                                            </div>
                                            <div class="date"> <span
                                                    class="text-muted">[[convertUtcToLocalDate(review.created_at)]]</span> </div> --}}
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faq_tab_1" role="tabpanel" aria-labelledby="faq_tab_1-tab">
                            <div class="card mt-2">
                                <div class="comment-section">
                                    <div ng-repeat="review in my_reviews">

                                        <div class="d-flex justify-content-start align-items-center">
                                            <div class="img-col" style="display:contents">
                                                <img src="[[review.target.display_pic ? review.target.display_pic : '/images/alt-pic.png']]"
                                                    class="rounded-circle profile-image img-fluid img-thumbnail"
                                                    width="80" height="80">
                                            </div>
                                            {{-- <div class="name flex-grow-1">
                                                <div ng-if="review.target.average_rating > 0" class="ratings">
                                                    <i class="fa fa-star [[($index+1) <= review.target.average_rating ? 'rating-color' : '']]" ng-repeat="x in [].constructor(5) track by $index"
                                                    ></i>
                                                </div>
                                                <div class="username my-2">[[review.target.name]]</div>
                                            </div> --}}
                                            <div class="comments ms-2">
                                                <div ng-if="review.rating > 0" class="ratings">
                                                    <i class="fa fa-star [[($index+1) <= review.rating ? 'rating-color' : '']]"
                                                        ng-repeat="x in [].constructor(5) track by $index"></i>
                                                </div>
                                                <div class="username"><strong>[[review.job.title]]</strong></div>
                                                <div class="username">[[review.target.name]]</div>
                                                <div>
                                                    <p class="mb-0" style="font-size: 14px">[[review.comments]]</p>
                                                    <small
                                                        class="font-style-italic text-muted d-block">[[convertUtcToLocalDate(review.created_at)]]</small>
                                                </div>
                                                <div class="action-btns mt-1">
                                                    <button class="btn btn-sm m1-2"
                                                        ng-click="giveFeedback(review.source, review.target, review.job_id, review, true);">Edit</button>
                                                    <button class="btn btn-sm"
                                                        ng-click="deleteFeedback(review.id);">Delete</button>
                                                </div>
                                            </div>
                                            {{-- <div class="date">
                                                <span class="text-muted"></span>
                                            </div> --}}

                                            {{-- <div class="d-flex flex-row align-items-center">
                                                
                                                <div class="ratings-col d-flex justify-content-center my-1 align-items-center" ng-if="review.source.average_rating > 0">
                                                    <div class="ratings">
                                                        <i class="fa fa-star [[($index+1) <= review.source.average_rating ? 'rating-color' : '']]" ng-repeat="x in [].constructor(5) track by $index"
                                                        ></i>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-column ml-1 comment-profile">
                                                    <span class="username">[[review.source.name]]</span>
                                                </div>
                                            </div>
                                            <div class="date"> <span
                                                    class="text-muted">[[convertUtcToLocalDate(review.created_at)]]</span> </div> --}}
                                        </div>

                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


            <!--Review old section-->
            {{-- <div class="card mt-2">
                <div class="badges"> <span class="badge bg-dark ">All ([[my_reviews_count]])</span>
                </div>
                <hr>
                <div class="comment-section">
                    <div ng-repeat="review in my_reviews">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-row align-items-center">
                                <img src="[[review.source.display_pic ? review.source.display_pic : 'https://source.unsplash.com/random/150x150']]"
                                    class="rounded-circle profile-image" width="120" height="120">
                                <div class="d-flex flex-column ml-1 comment-profile">
                                    <div class="comment-ratings">
                                        <i class="fa fa-star"
                                            ng-repeat="x in [].constructor(review.rating) track by $index"></i>
                                    </div>
                                    <span class="username">[[review.source.name]]</span>
                                </div>
                            </div>
                            <div class="date"> <span
                                    class="text-muted">[[convertUtcToLocalDate(review.created_at)]]</span> </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div> --}}
            <!--Close old review section-->

        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/reviews-controller.js') }}"></script>
@endsection