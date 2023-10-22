@extends('content.menu.admin')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />
@section('main-css')

@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='adminHelpfulKeysCtrl' ng-init="init();" ng-cloak
    class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Helpful Keys</h4>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row" id="btnAddHelpfulKey">
                                <div class="col-md-12">
                                    <button type="button" class="btn" ng-click="addHelpfulKey()"><i
                                            class="fa fa-plus"></i> Add Helpful Key</button>
                                </div>
                            </div>
                            <div class="row" id="formHelpfulKey" style="display: none">
                                <div class="col-md-12">
                                    <div class="card-title mt-3 p-2 bg-secondary">
                                        <h6 class="text-light">[[helpfulKey.id ? 'Edit' : 'Add']] Helpful Key</h6>
                                    </div>

                                    <form ng-submit="saveHelpfulKey()">
                                        <div class="row">
                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline">
                                                    <button class="text-dark" type="button"
                                                        ng-click="selectHelpfulKeyIcon()">Icon <small
                                                            class="text-danger">*</small></button>
                                                    <label class="text-truncate" id="lblHelpfulKeyIcon"
                                                        for="HelpfulKeyIcon">[[helpfulKey.icon ? helpfulKey.icon :
                                                        'Choose File']]</label>
                                                    <input id="helpfulKeyIcon" type="file" class="form-control" value=""
                                                        onchange="angular.element(this).scope().uploadHelpfulKeyIcon(this)"
                                                        hidden>
                                                    <button id="btnRemoveHelpfulKeyIcon"
                                                        class="text-dark bg-transparent border-0 float-end my-1"
                                                        type="button" ng-click="removeHelpfulKeyIcon()"
                                                        style="display:none"><i class="fa fa-close"></i></button>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[helpfulKey.title ? 'hasValue' : '']]">
                                                    <input type="text" title-only class="form-control"
                                                        ng-model="helpfulKey.title">
                                                    <label class="form-label" style="margin-left: 0px;">Title <small
                                                            class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-4 mt-3">
                                                <div class="form-outline [[helpfulKey.description ? 'hasValue' : '']]">
                                                    <input type="text" description class="form-control"
                                                        ng-model="helpfulKey.description">
                                                    <label class="form-label" style="margin-left: 0px;">Description
                                                        <small class="text-danger">*</small></label>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                <div class="form-outline">
                                                    <button type="submit" class="btn">[[helpfulKey.id ? 'Update' :
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
                                <div class="table-responsive" ng-show="helpfulKeys.length > 0">
                                    <table class="table table-xs mb-0 mt-3">
                                        <thead>
                                            <tr>
                                                <th>TITLE</th>
                                                <th>DESCRIPTION</th>
                                                <th>ICON</th>
                                                <th>ACTIONS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="key in helpfulKeys">
                                                <td class="text-capitalize">[[key.title]]</td>
                                                <td class="text-capitalize">[[key.description]]</td>
                                                <td class="text-capitalize">[[key.icon]]</td>
                                                <td>
                                                    <button class="btn ms-1" ng-click="editHelpfulKey(key)"><i
                                                            class="fa fa-edit"></i></button>
                                                    <button class="btn ms-1" ng-click="confirmDeleteHelpfulKey(key)"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-center" ng-show="helpfulKeys.length == 0">
                                    <p>No helpful keys added yet</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Helpful Key -->
    <div class="modal fade" id="modalDeleteHelpfulKey" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirm Delete Helpful Key</h5>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this helpful key?</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn" ng-click="hideConfirmModal()">No</button>
                    <button type="button" class="btn" ng-click="deleteHelpfulKey()">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/admin-helpful-keys-controller.js') }}"></script>
@endsection