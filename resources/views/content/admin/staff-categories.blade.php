@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='staffCategoriesCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Staff Categories</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row" id="btnAddStaffCategory">
                                <div class="col-md-12">
                                    <button type="button" class="btn" ng-click="addStaffCategory()"><i
                                            class="fa fa-plus"></i> Add Staff Category</button>
                                </div>
                            </div>
                            <div class="row" id="formStaffCategory" style="display: none">
                                <div class="col-md-12">
                                    <div class="card-title mt-3 p-2 bg-secondary">
                                        <h6 class="text-light">[[staffCategory.id ? 'Edit' : 'Add']] Staff Category</h6>
                                    </div>

                                    <form ng-submit="saveStaffCategory()">
                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[staffCategory.title ? 'hasValue' : '']]">
                                                    <input maxlength="40" type="text" class="form-control"
                                                        ng-model="staffCategory.title">
                                                    <label class="form-label" style="margin-left: 0px;">Title <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[staffCategory.category_id ? 'hasValue' : '']]">
                                                    <select class="form-control" ng-model="staffCategory.category_id"
                                                        ng-change="selectCategory()">
                                                        <option ng-value="" ng-show="selectedCategory">Select Parent
                                                            Category</option>
                                                        <option ng-value="category.id"
                                                            ng-repeat="category in categories">[[category.title]]
                                                        </option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px;">Parent
                                                        Category</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline  [[staffCategory.gender ? 'hasValue' : '']]">
                                                    <select class="form-control" ng-model="staffCategory.gender"
                                                        ng-disabled="selected_category_has_gender">
                                                        <option value="">Not Specified</option>
                                                        <option value="male">Male</option>
                                                        <option value="female">Female</option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px;">Gender</label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline [[staffCategory.min_rate > 0 ? 'hasValue' : '']]">
                                                    <input type="text" numbers-only ng-trim="false" maxlength="3"
                                                        min="[[selectedCategory ? selectedCategory.min_rate : '10']]"
                                                        class="form-control" ng-model="staffCategory.min_rate">
                                                    <label class="form-label" style="margin-left: 0px;">Min. Rate <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div
                                                    class="form-outline  [[staffCategory.helpful_key_id ? 'hasValue' : '']]">
                                                    <select class="form-control" ng-model="staffCategory.helpful_key_id"
                                                        ng-change="selectHelpfulKey()">
                                                        <option ng-value="key.id" ng-repeat="key in helpfulKeys">
                                                            [[key.title]]</option>
                                                    </select>
                                                    <label class="form-label" style="margin-left: 0px;">Helpful Key
                                                        <small class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div ng-show="staffCategory.helpful_key_id" class="col-md-1 mt-3">
                                                <img class="bg-pink-color" width="40" height="40"
                                                    src="[[selectedHelpfulKey.icon]]" />
                                            </div>

                                            <div class="col-md-3 mt-3">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" ng-true-value="1"
                                                        ng-false-value="0" ng-model="staffCategory.is_active">
                                                    <label class="form-check-label">Active</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-outline">
                                                    <button type="submit" class="btn">[[staffCategory.id ? 'Update' :
                                                        'Save']]</button>
                                                    <button type="button" class="btn"
                                                        ng-click="cancelForm()">Cancel</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="row">
                                <div class="table-responsive-md" ng-show="staffCategories.length > 0">
                                    <table class="table table-xs mb-0 mt-3">
                                        <thead>
                                            <tr>
                                                <th>TITLE</th>
                                                <th>CATEGORY</th>
                                                <th>GENDER</th>
                                                <th>MIN RATE</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="category in staffCategories">
                                                <td class="text-capitalize">[[category.title]]</td>
                                                <td class="text-capitalize">[[category.category ?
                                                    category.category.title : '']]</td>
                                                <td class="text-capitalize">[[category.gender]]</td>
                                                <td class="text-capitalize">[[category.min_rate]]</td>
                                                <td>
                                                    <button class="btn ms-1" ng-click="editStaffCategory(category)"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button class="btn ms-1"
                                                        ng-click="confirmDeleteStaffCategory(category)"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="pagination-container wow zoomIn mar-b-1x" data-wow-duration="0.5s"
                                        ng-if="staffCategories.length > 3">
                                        <ul class="pagination">
                                            <li class="pagination-item--wide" ng-if="currentPage > 1"> <a
                                                    class="pagination-link--wide first" ng-click="previousPage()"
                                                    href="javascript:void(0)"><i class="icofont-arrow-left"></i>
                                                    Previous</a> </li>
                                            <li class="pagination-item [[currentPage == $index+1 ? 'is-active' : '']]"
                                                ng-repeat="x in [].constructor(lastPage) track by $index">
                                                <a class="pagination-link" href="javascript:void(0)"
                                                    ng-click="goToPage($index+1)">[[ $index+1
                                                    ]]</a>
                                            </li>
                                            <li class="pagination-item--wide "> <a class="pagination-link--wide last"
                                                    ng-click="nextPage()" ng-if="lastPage != currentPage"
                                                    href="javascript:void(0)">Next <i
                                                        class="icofont-arrow-right"></i></a> </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="text-center" ng-hide="staffCategories.length > 0">
                                    <p>No staff categories added yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Category -->
    <div class="modal fade" id="modalDeleteStaffCategory" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Staff Category</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this staff category?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideConfirmModal()">No</button>
                    <button type="button" class="btn" ng-click="deleteStaffCategory()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/staff-categories-controller.js') }}"></script>
@endsection