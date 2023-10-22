<div class="col-md-4 col-lg-3 border-right">
    <div class="py-sm-0 py-md-5">
        <ul class="side-menu">
            <li class="@if(Request::path()  == 'profile') active @endif"><a href="{{route('profile')}}">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">MY PROFILE</h6>
                </a></li>
            <li class="@if(Request::path()  == 'job' || Request::path()  == 'applications') active @endif">
                <a href="javascript:void(0);" ng-click="accessToRoute('/job')" ng-if="auth_user.is_host">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">JOB DASHBOARD</h6>
                </a>
                <a href="javascript:void(0);" ng-click="accessToRoute('/applications')" ng-if="auth_user.is_staff">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">JOB DASHBOARD</h6>
                </a>
            </li>
            <li class="@if(Request::path()  == 'job/create') active @endif" ng-if="auth_user.is_host"><a
                    href="javascript:void(0);" ng-click="accessToRoute('/job/create')">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">POST A JOB</h6>
                </a></li>
            <li class="@if(Request::path()  == 'shortlists') active @endif"><a href="javascript:void(0)"
                    ng-click="accessToRoute('/shortlists')">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">[[auth_user.is_host ? 'STAFF' : 'JOB']] SHORTLIST</h6>
                </a></li>
            <li class="@if(Request::path()  == 'credit_card') active @endif">
                <a href="javascript:void(0)" ng-click="accessToRoute('/credit_card')">
                    <span>
                        <i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i>
                    </span>
                    <h6 class="d-inline">[[(auth_user.cards && auth_user.cards.length > 0) ? 'CREDIT CARD' :
                        'REGISTRATION FEE']]
                    </h6>
                </a>
            </li>
            <li class="@if(Request::path()  == 'transaction') active @endif"><a href="javascript:void(0)"
                    ng-click="accessToRoute('/transaction')">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">TRANSACTIONS</h6>
                </a></li>

            <li class="@if(Request::path()  == 'subscription_plans') active @endif" ng-if="auth_user.is_host">
                <a href="javascript:void(0)" ng-click="accessToRoute('/subscription_plans')">
                    <span>
                        <i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i>
                    </span>
                    <h6 class="d-inline">BUY A NEW PACK</h6>
                </a>
            </li>

            <li class="@if(Request::path()  == 'referral_program') active @endif" ng-if="auth_user.is_host"><a
                    href="javascript:void(0)" ng-click="accessToRoute('/referral_program')">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">REFERRAL PROGRAM</h6>
                </a></li>
            <li class="@if(Request::path()  == 'reviews') active @endif"><a href="javascript:void(0)"
                    ng-click="accessToRoute('/reviews')">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">REVIEWS</h6>
                </a></li>
            <li><a href="{{route('logout')}}">
                    <span><i class="fa fa-arrow-circle-right me-2" aria-hidden="true"></i></span>
                    <h6 class="d-inline">LOGOUT</h6>
                </a></li>
        </ul>
    </div>
</div>