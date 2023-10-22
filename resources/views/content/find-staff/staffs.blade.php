@extends('content.find-staff.index')
@section('main-body')
<!-- products section -->
<section id="products" class="py-5">
    <div class="container">
        <div class="page-title d-flex align-items-center bg-light p-2">
            <h4 id="burgundy" class="flex-fill mb-0">Find Staff</h4>
            <div ng-if="staffs.length > 0" class="fst-italic pink-text-color"><small>Showing [[FilterRecords]] of
                    [[TotalRecords]] results</small>
            </div>
        </div>
        <div class="row m-0">
            <div ng-show="staffs.length == 0 " class="col-md-12 text-left p-3 bg-light">
                <p>
                    Unfortunately, there are no staff available that meet your criteria. Please refine your search, and
                    try again. Try being less specific.
                </p>
            </div>
            <div ng-repeat="staff in staffs" class="col-lg-4 col-md-6 col-sm-10 offset-md-0 offset-sm-1 mb-4">
                <div class="card border-light border flex-fill">
                    <div class="card-body p-0">
                        <div class="img-box bg-light p-2 rounded">
                            <a href="find_staff/[[staff.id]]/detail">
                                <img class="img-thumbnail"
                                    ng-src="[[staff.display_pic ? staff.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                    style="height: 250px;object-fit: cover;width:250px;">
                            </a>
                        </div>
                        <div class="content-box mt-3 px-3">
                            <h5 class="pink-text-color mb-0"><a class="pink-text-color text-decoration-none"
                                    href="find_staff/[[staff.id]]/detail">[[staff.display_name ? staff.display_name : staff.name]]</a></h5>
                            <div class="detail d-flex" style="visibility: [[staff.address.address_line1 ? 'visible': 'hidden']]">
                                <div class="text-muted age me-1"><i
                                        class="icofont-location-pin me-1 pink-text-color"></i>
                                    [[staff.address.address_line1]]
                                </div>
                            </div>
                            <div class="ratings-col d-flex justify-content-between align-items-center" style="visibility: [[staff.average_rating > 0 ? 'visible': 'hidden']]">
                                <div class="ratings">
                                    <i class="fa fa-star [[($index+1) <= staff.average_rating ? 'rating-color' : '']]" ng-repeat="x in [].constructor(5) track by $index"
                                    ></i>
                                </div>
                            </div>
                            <div ng-if="auth_user.id && auth_user.is_host">
                                <a class="btn btn-sm w-100 rounded my-2" href="javascript:void(0)"
                                    ng-click="invitationConfirmation(staff, 'invite')">INVITE</a>
                                <a class="btn btn-sm w-100 rounded mb-2 shortlistText[[staff.id]]"
                                    href="javascript:void(0)" ng-click="addToShortList(staff, 'staff')">[[
                                    staff.is_shortlisted ? 'ADDED' :
                                    'ADD']]
                                    TO SHORTLIST</a>
                            </div>
                            <div ng-if="!auth_user.id">
                                <a class="btn btn-sm w-100 rounded my-2" href="{{ route('login') }}">CONTACT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="pagination-container wow zoomIn mar-b-1x" data-wow-duration="0.5s" ng-if="TotalRecords > 12">

            <ul class="pagination">
                <li class="pagination-item--wide" ng-if="currentPage > 1"> <a class="pagination-link--wide first"
                        ng-click="previousPage()" href="javascript:void(0)"><i class="icofont-arrow-left"></i>
                        Previous</a> </li>
                <li class="pagination-item [[currentPage == $index+1 ? 'is-active' : '']]"
                    ng-repeat="x in [].constructor(lastPage) track by $index">
                    <a class="pagination-link" href="javascript:void(0)" ng-click="goToPage($index+1)">[[ $index+1
                        ]]</a>
                </li>
                <li class="pagination-item--wide "> <a class="pagination-link--wide last" ng-click="nextPage()"
                        ng-if="lastPage != currentPage" href="javascript:void(0)">Next <i
                            class="icofont-arrow-right"></i></a> </li>
            </ul>

        </div>
    </div>
</section>
@endsection