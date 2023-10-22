@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/transaction-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='transactionCtrl' ng-init="init();" ng-cloak class="ng-cloak">
    <div class="p-3 py-5">
        <div class="row">
            <div class="page-title d-flex align-items-center bg-light p-2">
                <h4 id="burgundy" class="flex-fill mb-0">Transactions</h4>
                <div class="referral-credits">
                    <span class="vst-md text-center credit-tooltip" data-toggle="tooltip" title=""
                        data-original-title="You currently have [[auth_user.credit]] credits">$[[auth_user.credit]]</span>
                    <div class="credit-title">credits</div>
                </div>
                <button class="btn btn-sm align-self-end d-none"><i class="icofont-arrow-left me-2"></i>Back</button>
            </div>
            <div class="active-member">
                <div class="table-responsive-md">
                    <div ng-show="transactions.length < 1" class="col-md-12 text-center p-3 bg-light">
                        <h5>
                            No transaction is available
                        </h5>
                    </div>
                    <table ng-hide="transactions.length < 1" class="table table-xs mb-0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Card Reference</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="transaction in transactions">
                                <td>[[convertUtcToLocalDate(transaction.created_at)]]</td>
                                <td>[[transaction.purpose]]</td>
                                <td><span class="amnt h5">$[[transaction.amount]]</span></td>
                                <td>**** **** **** [[transaction.user_card.last4]]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/transaction-controller.js') }}"></script>
@endsection