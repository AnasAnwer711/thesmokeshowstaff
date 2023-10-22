@extends('content.menu.index')
<link rel='stylesheet' href="{{asset('css/profile/credit-card-style.css')}}" media='all' />

@section('main-css')
<style>

</style>
@endsection
@section('main-body')
<div class="col-md-8 col-lg-9 border-right" ng-controller='creditCardCtrl' ng-init="init();" ng-cloak class="ng-cloak">
    <div class="p-3 py-5">
        <div class="saved-cards">
            <div class="row">
                <div class="page-title d-flex align-items-center bg-light p-2">
                    <h4 id="burgundy" class="flex-fill mb-0">Registration Fee</h4>

                    <button ng-if="cards.length > 0" class="btn btn-sm align-self-end" ng-click="toggleCardForm();"><i
                            class="icofont-credit-card me-2"></i>[[showPaymentInfo ? 'View Cards':'Add Card']]
                    </button>
                </div>
                <div>

                    <p class="py-2" ng-if="cards.length == 0">Credit Card Verification: We will charge $1 to verify your
                        credit card details now. You will only be charged the remainder of the booking fee once you have
                        booked the required staff for your party.</p>
                </div>
            </div>
            <table class="table table-xs mb-0" ng-hide="showPaymentInfo" ng-if="cards.length > 0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Card Number</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="card in cards">
                        <td>[[card.name]]</td>
                        <td>**** **** **** [[card.last4]]
                        </td>
                        <td>[[card.brand]]</td>
                        <td><span ng-if="cards.length > 0" style="cursor:pointer" ng-click="removeCard(card.id)"><i
                                    class="fa fa-trash"></i></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row m-0" ng-show="showPaymentInfo || cards.length == 0">

            <div class="personal-information">
                <h5 class="text-white primary-heading mb-0 p-2">Add Card Detail</h5>
            </div> <!-- end of personal-information -->


            <form>
                <div class="row m-0">
                    <div class="col-md-12 col-lg-6 g-3">
                        <div class="row">
                            <div class="col-md-12 g-3">
                                <div class="form-outline hasvalue">
                                    <input type="text" id="column-left" ng-model="cardModel.name" name="first-name"
                                        class="form-control jp-card-valid" value="" required="" maxlength="50"
                                        onkeydown="return /^([\s.]?[a-z A-Z]+)+$/i.test(event.key)">
                                    <label class="form-label" style="margin-left: 0px;"><span
                                            class="text-danger">*</span> Name On Card</label>
                                </div>
                            </div>
                            <div class="col-md-12 g-3">
                                <div class="form-outline hasvalue">
                                    <input type="text" id="input-field" ng-model="cardModel.number" name="number"
                                        class="form-control unknown jp-card-invalid" value="" required="">
                                    <label class="form-label" style="margin-left: 0px;"><span
                                            class="text-danger">*</span> Card Number</label>
                                </div>
                            </div>
                            <div class="col-md-6 g-3">
                                <div class="form-outline hasvalue">
                                    <input type="text" id="column-left" ng-model="cardModel.expiry" name="expiry"
                                        class="form-control jp-card-invalid" value="" required="">
                                    <label class="form-label" style="margin-left: 0px;"><span
                                            class="text-danger">*</span> Expiry Date</label>
                                </div>
                            </div>
                            <div class="col-md-6 g-3">
                                <div class="form-outline hasvalue">
                                    <input type="text" id="column-right" ng-model="cardModel.cvc" name="cvc"
                                        class="form-control jp-card-valid" value="" required="">
                                    <label class="form-label" style="margin-left: 0px;"><span
                                            class="text-danger">*</span> CVC</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <a href="javascript:void(0)" class="btn mt-2" ng-click="clearCard()">Cancel</a>
                                <a href="javascript:void(0)" class="btn mt-2 card-save" ng-click="saveCard()">Save
                                    Card</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 g-3">
                        <div class="card-wrapper"></div>
            </form>
        </div>


    </div>

</div>
</div>
</div>
@endsection
@section('js-controller')
<script src="{{ ('/app/credit-card-controller.js') }}"></script>
<script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/card.js"></script>
<script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/121761/jquery.card.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('form').card({
        container: '.card-wrapper',
        width: 280,

        formSelectors: {
            nameInput: 'input[name="first-name"], input[name="last-name"]'
        }
    });
});
</script>
@endsection