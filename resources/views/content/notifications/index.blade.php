@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/notifications/notifications-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='notificationsCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Notifications</h4>
                <div ng-if="allNotifications.length > 0" class="fst-italic pink-text-color"><small>Showing [[FilterRecords]] of
                    [[TotalRecords]] results</small>
                </div>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div ng-if="allNotifications.length > 0" class=" d-flex align-items-center justify-content-end fst-italic pink-text-color">
                <button class="btn btn-sm align-self-end" ng-click="deleteAllNotifications()"><i class="icofont-ui-delete me-2"></i>Clear All</button>
            </div>
            <div ng-show="allNotifications.length < 1" class="col-md-12 text-center p-3 bg-light">
                <h5>
                    You don`t have any new notification.
                </h5>
            </div>
            <div class="active-member" ng-show="allNotifications.length > 1">
                <div class="">
                    <div ng-repeat="notification in allNotifications" class="col-md-12 p-3 bg-light mb-2">
                        <div class="d-flex align-items-center">
                            <div class="img-col" style="display: contents;">
                                <img style="width: 65px;height: 60px;"
                                    ng-src="[[notification.source.display_pic ? notification.source.display_pic : '/images/Logo_SmokeShowStaff.png']]"
                                    class="img-thumbanil img-fluid rounded-circle" />
                            </div>
                            <a href="[[notification.link]]" class="ms-3 text-dark text-decoration-none flex-fill">

                                <div class="text-col flex-fill me-2">
                                    <small class="d-block"> <strong> [[notification.title]]</strong>
                                        [[convertUtcToLocalTime(notification.created_at)]]
                                        [[convertUtcToLocalDate(notification.created_at)]] </small>
                                    <p>[[notification.description]]</p>
                                </div>
                            </a>
                            <div class="action-btn" ng-click="deleteNotification(notification.id)">
                                <i class="icofont-ui-delete text-danger delete-icon"></i>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="pagination-container wow zoomIn mar-b-1x" data-wow-duration="0.5s" ng-if="TotalRecords > 5">
                    <ul class="pagination">
                        <li class="pagination-item--wide" ng-if="currentPage > 1"> <a
                                class="pagination-link--wide first" ng-click="previousPage()"
                                href="javascript:void(0)"><i class="icofont-arrow-left"></i>
                                Previous</a> </li>
                        <li class="pagination-item [[currentPage == $index+1 ? 'is-active' : '']]"
                            ng-repeat="x in [].constructor(lastPage) track by $index">
                            <a class="pagination-link" href="javascript:void(0)" ng-click="goToPage($index+1)">[[
                                $index+1
                                ]]</a>
                        </li>
                        <li class="pagination-item--wide "> <a class="pagination-link--wide last" ng-click="nextPage()"
                                ng-if="lastPage != currentPage" href="javascript:void(0)">Next <i
                                    class="icofont-arrow-right"></i></a> </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/notifications-controller.js') }}"></script>
@endsection