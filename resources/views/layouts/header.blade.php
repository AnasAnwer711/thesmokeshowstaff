<link rel='stylesheet' href="{{asset('css/header.css')}}" media='all' />
<div data-elementor-type="header" data-elementor-id="83" class="elementor elementor-83 elementor-location-header"
    data-elementor-settings="[]">
    <div class="elementor-section-wrap">
        <section
            class="elementor-section elementor-top-section elementor-element elementor-element-d81541e elementor-section-full_width elementor-section-content-middle elementor-section-height-min-height elementor-section-height-default elementor-section-items-middle"
            data-id="d81541e" data-element_type="section"
            data-settings="{&quot;sticky&quot;:&quot;top&quot;,&quot;background_background&quot;:&quot;classic&quot;,&quot;sticky_on&quot;:[&quot;desktop&quot;,&quot;tablet&quot;,&quot;mobile&quot;],&quot;sticky_offset&quot;:0,&quot;sticky_effects_offset&quot;:0}">
            <div class="elementor-container elementor-column-gap-default">
                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-e70aa7c"
                    data-id="e70aa7c" data-element_type="column">
                    <div class="elementor-widget-wrap elementor-element-populated">
                        <div class="elementor-element elementor-element-6e748aa elementor-nav-menu__align-right elementor-nav-menu--dropdown-tablet elementor-nav-menu__text-align-aside elementor-nav-menu--toggle elementor-nav-menu--burger elementor-widget elementor-widget-nav-menu"
                            data-id="6e748aa" data-element_type="widget"
                            data-settings="{&quot;layout&quot;:&quot;horizontal&quot;,&quot;submenu_icon&quot;:{&quot;value&quot;:&quot;&lt;i class=\&quot;fas fa-caret-down\&quot;&gt;&lt;\/i&gt;&quot;,&quot;library&quot;:&quot;fa-solid&quot;},&quot;toggle&quot;:&quot;burger&quot;}"
                            data-widget_type="nav-menu.default">
                            <div class="elementor-widget-container">
                                <nav migration_allowed="1" migrated="0" role="navigation"
                                    class="elementor-nav-menu--main elementor-nav-menu__container elementor-nav-menu--layout-horizontal e--pointer-none">
                                    <ul id="menu-1-6e748aa" class="elementor-nav-menu position-static">
                                        <li ng-if="auth_user.is_host || !auth_user.id"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-621 nav-pink-btn">
                                            <a href="{{ route('job.create') }}" class="elementor-item menu-link">Post
                                                Job</a>
                                        </li>
                                        <li ng-if="auth_user.is_staff"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-621 nav-pink-btn">
                                            <a href="{{ route('find-job') }}" class="elementor-item menu-link">Find
                                                Job</a>
                                        </li>
                                        <li ng-if="auth_user.is_host || !auth_user.id"
                                            class="bt-menu menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-360 current_page_item menu-item-417 nav-item dropdown dropdown-mega position-static">
                                            <a href="JavaScript:void(0)" aria-current="page"
                                                class="dd-mn-show elementor-item menu-link nav-link dropdown-toggle"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                aria-expanded="false">Find staff <span class="arrow"><i
                                                        class="icofont-rounded-down"></i></span></a>
                                            <div class="dropdown-menu shadow" data-bs-popper="none">
                                                <div class="mega-content px-4">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-4 col-md-3 py-4"
                                                                ng-repeat="staff_category in staff_categories">
                                                                <h5>[[staff_category.title]]</h5>
                                                                <div class="list-group"
                                                                    ng-repeat="sub_category in staff_category.sub_categories">
                                                                    <a class="list-group-item"
                                                                        href="/find_staff?skillvalues=[[sub_category.id]]">
                                                                        <i class="fa fa-arrow-circle-right me-2"
                                                                            aria-hidden="true"></i>
                                                                        [[sub_category.title]]
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('howitworks') }}" class="elementor-item menu-link">How it
                                                works</a>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('faqs') }}" class="elementor-item menu-link">FAQ</a>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('contactus') }}" class="elementor-item menu-link">Contact
                                                us</a>
                                        </li>



                                        <li class="menu-item menu-item-type-post_type menu-item-object-page"
                                            ng-if="!auth_user.id">
                                            <a href="{{route('signup')}}" class="elementor-item menu-link">Sign up</a>
                                            <a href="{{route('login')}}" class="elementor-item menu-link">Login </a>
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page">
                                        </li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418"
                                            ng-if="auth_user.id">
                                            <a href="{{route('messages') }}" class="elementor-item menu-link"><i
                                                    class="icofont-ui-message pink-text-color"
                                                    style="font-size: 20px;"></i></a>
                                            <span class="unread-message-dot" style="display: none;">
                                            </span>
                                        </li>
                                        <!-- hide notification for temp purpose added d-none class -->
                                        <li class="menu-item menu-item-type-post_type dropdown notification-ui show"
                                            ng-if="auth_user.id" ng-click="unRead=''">
                                            <a class="elementor-item menu-link dropdown-toggle notification-ui_icon"
                                                href="#" ng-click="showNotification()" id="navbarDropdown" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="icofont-notification pink-text-color"></i>
                                                <span class="ng-class:unRead"></span>
                                            </a>
                                            <div class="dropdown-menu notification-ui_dd"
                                                aria-labelledby="navbarDropdown">
                                                <div class="notification-ui_dd-header p-4">
                                                    <h6 class="text-center mb-0 pink-text-color">Notification</h6>
                                                </div>
                                                <div class="notification-ui_dd-content">
                                                    <div ng-show="notifications.length > 0"
                                                        class="notification-list notification-list--unread  d-flex position-relative"
                                                        ng-repeat="notification in notifications">
                                                        <a href="[[notification.link]]" class="text-dark
                                                        text-decoration-none"
                                                            style="position: absolute;width: 100%;left: 0;right: 0;margin: 0 auto;height: 100%;top: 0;">
                                                        </a>
                                                        <div class="notification-list_img" style="display: contents;">
                                                            <img class="rounded-circle img-thumbnail img-fluid bg-light"
                                                                ng-src="[[notification.source.display_pic ? notification.source.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                                alt="user">
                                                        </div>
                                                        <div class="notification-list_detail d-flex flex-wrap">
                                                            <p class="mb-0 ">[[notification.title]]</p>
                                                            <small>[[notification.description]]</small>
                                                        </div>

                                                    </div>
                                                    <!-- <div
                                                        class="notification-list notification-list--unread  d-flex flex-wrap">
                                                        <div class="notification-list_img">
                                                            <img class="rounded-circle img-thumbnail img-fluid"
                                                                ng-src="[[notification.source.display_pic ? notification.source.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                                alt="user">
                                                        </div>
                                                        <div class="notification-list_detail">
                                                            <p class="mb-0">[[notification.title]]</p>
                                                            <small>[[notification.description]]</small>
                                                        </div>
                                                    </div> -->
                                                    <div ng-hide="notifications.length > 0"
                                                        class="no-notification-panel">
                                                        <p
                                                            class="mb-0 no-notification-panel text-center p-2 bg-light text-muted">
                                                            You dont have any notification yet.</p>
                                                    </div>
                                                </div>
                                                <div ng-if="notifications.length > 0"
                                                    class="notification-ui_dd-footer mt-4 text-center">
                                                    <a href="{{route('see-all-notifications') }}"
                                                        class="d-block pink-text-color"><i
                                                            class="icofont-eye-alt me-2"></i>View All</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    <div id="loginPrivate" class="login-private" ng-if="auth_user.id">
                                        <button class="dropdown-toggle p-0" type="button" id="dropdownMenuButton1"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <div class="user-pic">
                                                <img ng-src="[[auth_user.display_pic ? auth_user.display_pic : '/images/Logo_SmokeShowStaff.png' ]]"
                                                    alt="">
                                            </div>
                                            <div class="user-name">
                                                <span class="name">[[auth_user.name]]
                                                </span>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            @if (Auth::check())
                                            @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                                            <li class="dropdown-item"><a href="{{route('admin-panel')}}">
                                                    ADMIN PANEL
                                                </a></li>
                                            <li>
                                                @endif
                                                @endif
                                            <li class="dropdown-item"><a href="{{route('profile')}}">
                                                    MY PROFILE
                                                </a></li>
                                            <li>
                                                <a class="dropdown-item" href="{{route('job.index')}}"
                                                    ng-if="auth_user.is_host">
                                                    JOB DASHBOARD
                                                </a>
                                                <a class="dropdown-item" href="{{route('applications.index')}}"
                                                    ng-if="auth_user.is_staff">
                                                    JOB DASHBOARD
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{route('job.create')}}"
                                                    ng-if="auth_user.is_host">
                                                    POST A JOB
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('shortlists.index')}}">
                                                    [[auth_user.is_host ? 'STAFF' : 'JOB']]
                                                    SHORTLIST
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('credit_card.index')}}">
                                                    [[(auth_user.cards && auth_user.cards.length >
                                                    0) ? 'CREDIT CARD' : 'REGISTRATION FEE']]
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('transaction.index')}}">
                                                    TRANSACTIONS
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('subscription_plans.index')}}"
                                                    ng-if="auth_user.is_host">
                                                    BUY A NEW PACK
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('referral-program')}}"
                                                    ng-if="auth_user.is_host">
                                                    REFERRAL PROGRAM
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('reviews.index')}}">
                                                    REVIEWS
                                                </a></li>
                                            <li><a class="dropdown-item" href="{{route('logout')}}">
                                                    LOGOUT
                                                </a></li>
                                        </ul>

                                    </div>

                                </nav>
                                <div id="menuToggle" class="elementor-menu-toggle" role="button" tabindex="0"
                                    aria-label="Menu Toggle" aria-expanded="false">
                                    <i ng-click="showMblMenu()" id="burger-menu-icon" aria-hidden="true"
                                        role="presentation" class="icofont-navigation-menu"></i>
                                    <!-- <i  class="eicon-menu-bar"></i>  -->
                                    <span class="elementor-screen-only">Menu</span>
                                </div>
                                <nav class="elementor-nav-menu--dropdown elementor-nav-menu__container mbl-menu"
                                    role="navigation" aria-hidden="true">
                                    <ul id="menu-2-6e748aa" class="elementor-nav-menu mbl-menu-ul">
                                        <li ng-if="auth_user.is_host || !auth_user.id"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-621 nav-pink-btn">
                                            <a href="{{ route('job.create') }}" class="elementor-item menu-link">Post
                                                Job</a>
                                        </li>
                                        <li ng-if="auth_user.is_staff"
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-621 nav-pink-btn">
                                            <a href="{{ route('find-job') }}" class="elementor-item menu-link">Find
                                                Job</a>
                                        </li>
                                        <li ng-if="auth_user.is_host || !auth_user.id"
                                            class="bt-menu menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-360 current_page_item menu-item-417 nav-item dropdown dropdown-mega position-static">
                                            <a href="JavaScript:void(0)" aria-current="page"
                                                class="dd-mn-show elementor-item menu-link nav-link dropdown-toggle"
                                                data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                                aria-expanded="false">Find staff <span class="arrow"><i
                                                        class="icofont-rounded-down"></i></span></a>
                                            <div class="dropdown-menu shadow" data-bs-popper="none">
                                                <div class="mega-content px-4">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-12 col-sm-4 col-md-3 py-4"
                                                                ng-repeat="staff_category in staff_categories">
                                                                <h5>[[staff_category.title]]</h5>
                                                                <div class="list-group"
                                                                    ng-repeat="sub_category in staff_category.sub_categories">
                                                                    <a class="list-group-item"
                                                                        href="/find_staff?skillvalues=[[sub_category.id]]">
                                                                        <i class="fa fa-arrow-circle-right me-2"
                                                                            aria-hidden="true"></i>
                                                                        [[sub_category.title]]
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('howitworks') }}" class="elementor-item menu-link">How it
                                                works</a>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('faqs') }}" class="elementor-item menu-link">FAQ</a>
                                        </li>
                                        <li
                                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-418">
                                            <a href="{{route('contactus') }}" class="elementor-item menu-link">Contact
                                                us</a>
                                        </li>



                                        <li class="menu-item menu-item-type-post_type menu-item-object-page"
                                            ng-if="!auth_user.id">
                                            <a href="{{route('signup')}}" class="elementor-item menu-link">Sign up</a>
                                            <a href="{{route('login')}}" class="elementor-item menu-link">Login </a>
                                        </li>


                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="elementor-element elementor-element-cf81d48 elementor-widget-mobile__width-initial elementor-absolute elementor-widget elementor-widget-image"
                            data-id="cf81d48" data-element_type="widget"
                            data-settings="{&quot;_position&quot;:&quot;absolute&quot;}"
                            data-widget_type="image.default">
                            <div class="elementor-widget-container">

                                <a href="{{ route('home') }}">
                                    <img width="384" height="101" src="{{asset('images/logo-the-smokeshow-staff.png')}}"
                                        class="attachment-full size-full" alt="" /> </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<div class="sticky-banner review-profile-banner" ng-cloak
    ng-show="auth_user && auth_user.is_profile_details && auth_user.status != 'approved'">
    <div class="row m-0">
        <div class="col-12 bg-theme-pink">
            <p class="text-white mb-0 py-3 text-center">Your profile is currently in review. Once approved by the system
                admin, you will have
                access to other
                pages.
            </p>
        </div>
    </div>
</div>