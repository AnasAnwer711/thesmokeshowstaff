@extends('layouts.app')

@section('content')
<link rel='stylesheet' href="{{asset('css/staff-detail/staff-detail-style.css')}}" media='all' />
<link rel='stylesheet' href='https://sachinchoolur.github.io/lightslider/dist/css/lightslider.css'>
<link rel='stylesheet' href="{{asset('css/profile/profile-style.css')}}" media='all' />
<div id="content" class="site-content" ng-controller='staffDetailCtrl' id="staffDetailCtrl" ng-init="init({{$id}})"
    ng-cloak class="ng-cloak">
    <div class="container-fluid p-0">
        <div class="container">
            <div class="container-fluid mt-2 mb-3">

                <div class="row no-gutters">
                    <div class="col-md-5 pr-2">
                        <div class="card">
                            <div class="demo">
                                <ul id="lightSlider">

                                    <li ng-repeat="photo in detail.uploaded_skill_photos"
                                        class="[[photo.is_default ? 'active' : '']]"
                                        data-thumb="[[photo.picture ? photo.picture : '/images/Logo_SmokeShowStaff.png']]">
                                        <img
                                            ng-src="[[photo.picture ? photo.picture : '/images/Logo_SmokeShowStaff.png']]" />
                                    </li>
                                </ul>

                                {{-- <ul id="lightSlider">
                                    <li class="active" data-thumb="{{asset ('images/staff-img/8-8.jpg')}}"> <img
                                    src="{{asset ('images/staff-img/8.jpg')}}" />
                                </li>
                                <li data-thumb="{{asset ('images/staff-img/1-1.jpg')}}"> <img
                                        src="{{asset ('images/staff-img/1-1.jpg')}}" />
                                </li>


                                </ul> --}}
                            </div>
                        </div>
                        <div class="card mt-2 d-none">
                            <h6>Reviews</h6>
                            <hr>
                            <div class="badges"> <span class="badge bg-dark ">All (230)</span> <span
                                    class="badge bg-dark "> <i class="fa fa-images"></i> 23 </span> <span
                                    class="badge bg-dark "> <i class="fa fa-comments"></i> 23 </span> <span
                                    class="badge bg-warning"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <span
                                        class="ml-1">2,123</span> </span> </div>
                            <hr>
                            <div class="comment-section">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center"> <img
                                            src="https://i.imgur.com/o5uMfKo.jpg" class="rounded-circle profile-image">
                                        <div class="d-flex flex-column ml-1 comment-profile">
                                            <div class="comment-ratings"> <i class="fa fa-star"></i> <i
                                                    class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                            </div> <span class="username">Lori Benneth</span>
                                        </div>
                                    </div>
                                    <div class="date"> <span class="text-muted">2 May</span> </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center"> <img
                                            src="https://i.imgur.com/tmdHXOY.jpg" class="rounded-circle profile-image">
                                        <div class="d-flex flex-column ml-1 comment-profile">
                                            <div class="comment-ratings"> <i class="fa fa-star"></i> <i
                                                    class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                            </div> <span class="username">Timona Simaung</span>
                                        </div>
                                    </div>
                                    <div class="date"> <span class="text-muted">12 May</span> </div>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex flex-row align-items-center"> <img
                                            src="https://i.imgur.com/tmdHXOY.jpg" class="rounded-circle profile-image">
                                        <div class="d-flex flex-column ml-1 comment-profile">
                                            <div class="comment-ratings"> <i class="fa fa-star"></i> <i
                                                    class="fa fa-star"></i>
                                                <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                            </div> <span class="username">Timona Simaung</span>
                                        </div>
                                    </div>
                                    <div class="date"> <span class="text-muted">12 May</span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card">
                            <div class="about">
                                <h4 class="font-weight-bold">[[detail.name]]</h4>
                                <span class="font-weight-bold">[[detail.address ?
                                    detail.address.address_line1+' , '+detail.address.postal_code :
                                    '']]</span>
                            </div>
                            <div class="ratings-col d-flex justify-content-between align-items-center"
                                ng-if="detail.average_rating > 0">
                                <div class="ratings">
                                    <i class="fa fa-star [[($index+1) <= detail.average_rating ? 'rating-color' : '']]"
                                        ng-repeat="x in [].constructor(5) track by $index"></i>
                                </div>
                            </div>

                            <hr>
                            <p class="mb-0">
                                [[detail.resume]]
                            </p>

                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Languages Spoken</h4>
                                    <div class="row ms-3">

                                        <div ng-repeat="l in detail.languages">
                                            <span class="small" style="display: list-item">[[l.language.name]] </span>
                                        </div>
    
                                    </div>
                                </div>
                                <div class="col-md-6 skills">
                                    <h4>Skills</h4>
                                    <div class="row">
                                        {{-- <div class="col-sm-2" ng-repeat="skill in detail.skills | unique:'skill.sub_categories.helpful_key_id'">
                                            <div class="skill-icn mb-3" ng-if="skill.sub_categories.helpful_key_id"><i class="[[skill.sub_categories.helpful_key.icon]]"></i></div>
                                        </div> --}}
                                        <div class="d-flex flex-wrap my-2">
                                            <div class="img-col me-2"
                                                ng-repeat="skill in detail.skills |  unique: 'sub_categories.helpful_key_id'">
                                                <img class="img-thumbnail img-fluid border bg-pink-color"
                                                    src="[[skill.sub_categories.helpful_key.icon]]" alt=""
                                                    style="height: 50px; width: 50px">
                                            </div>
                                            {{-- <div class="img-col me-2">
                                                <img class="img-thumbnail img-fluid border bg-pink-color" src="/images/helpful-icons/PS_Website_Icons_White_Burlesque.png"  alt="" style="height: 50px; width: 50px">
                                            </div>
                                            <div class="img-col me-2">
                                                <img class="img-thumbnail img-fluid border bg-pink-color" src="/images/helpful-icons/PS_Website_Icons_White_Fire_Dancer.png"  alt="" style="height: 50px; width: 50px">
                                            </div>
                                            <div class="img-col me-2">
                                                <img class="img-thumbnail img-fluid border bg-pink-color" src="/images/helpful-icons/PS_Website_Icons_White_Promotion.png"  alt="" style="height: 50px; width: 50px">
                                            </div>
                                            <div class="img-col me-2">
                                                <img class="img-thumbnail img-fluid border bg-pink-color" src="/images/helpful-icons/PS_Website_Icons_White_R18.png"  alt="" style="height: 50px; width: 50px">
                                            </div> --}}
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="buttons" ng-if="auth_user.id && auth_user.is_host">
                                <button ng-click="invitationConfirmation(detail, 'invite')" class="btn">
                                    <i class="icofont-ui-message"></i> INVITE
                                </button>
                                <button ng-click="addToShortList(detail, 'staff')"
                                    class="[[detail.is_shortlisted ? 'disabled' : '' ]] btn shortlistText[[detail.id]]">
                                    <i class="fa fa-heart"></i> [[ detail.is_shortlisted ? 'ADDED' : 'ADD']] TO
                                    SHORTLIST
                                </button>

                            </div>
                            <hr>
                            <div class="product-description">
                                <div class="bullets row">
                                    <h4>Experiences</h4>
                                    <div class="d-flex flex-wrap col-md-12 d-contents">
                                        <div class="align-items-center col-4 mt-2" ng-repeat="skill in detail.skills">
                                            {{-- <span class="dot"></span>
                                            <span class="bullet-text">[[skill.sub_categories.title]]</span> --}}
                                            <div class="info-group">
                                                <strong>[[skill.sub_categories.title]]</strong>
                                                <div class="staff-info-result">
                                                    <small class="d-block">
                                                        <i>[[skill.experience]] Year experience at</i>
                                                        <br>
                                                        [[skill.work_detail]]
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                            <hr class="mt-4">
                            <div class="buttons mt-4" ng-if="!auth_user.id"> <a href="{{ route('login') }}"
                                    class="btn btn-light btn-block wishlist contact-btn"> <i class="icofont-card"></i>
                                    CONTACT</a>
                            </div>
                            <div class="buttons mt-4" ng-if="auth_user.id"> <a href="javascript:void(0)"
                                    ng-click="contactMessage(detail)"
                                    class="btn btn-light btn-block wishlist contact-btn"> <i class="icofont-card"></i>
                                    CONTACT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Staff Modal -->
    <div class="modal fade" id="contactStaffModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Contact Staff</h5>
                </div>
                <div class="modal-body">
                    <div class="form-outline hasValue">
                        <select class="form-control" ng-model="contactForm.job_id">
                            <option ng-repeat="job in auth_user.jobs" ng-value="[[job.id]]">[[job.title]]</option>
                        </select>

                        <label class="form-label" style="margin-left: 0px">Select Job</label>
                    </div>

                    <div class="form-outline hasValue mt-3">
                        <textarea class="form-control" ng-model="contactForm.message" value="" required
                            style="min-height: 100px"></textarea>
                        <label class="form-label" style="margin-left: 0px;">Message</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideContactModal()">Cancel</button>
                    <button type="button" class="btn" ng-click="sendMessage()">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('javascripts')
<script src="{{ ('/app/staff-detail-controller.js') }}"></script>
{{-- <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js'></script> --}}
<script src='https://sachinchoolur.github.io/lightslider/dist/js/lightslider.js'></script>
<script>
// $(document).ready(function() {
//     $('#lightSlider').lightSlider({
//         gallery: true,
//         item: 1,
//         loop: true,
//         slideMargin: 0,
//         thumbItem: 9
//     });
// });
</script>
@endsection