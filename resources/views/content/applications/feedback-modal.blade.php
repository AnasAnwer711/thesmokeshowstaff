<style>
.txt-center {
    text-align: center;
}

.hide {
    display: none;
}

.clear {
    float: none;
    clear: both;
}

.rating {
    width: 90px;
    unicode-bidi: bidi-override;
    direction: rtl;
    text-align: center;
    position: relative;
}

.rating>label {
    float: right;
    display: inline;
    padding: 0;
    margin: 0;
    position: relative;
    width: 1.1em;
    cursor: pointer;
    color: #000;
    font-size: 21px;
}

.rating>label:hover,
.rating>label:hover~label,
.rating>input.radio-btn:checked~label {
    color: transparent;
}

.rating>label:hover:before,
.rating>label:hover~label:before,
.rating>input.radio-btn:checked~label:before,
.rating>input.radio-btn:checked~label:before {
    content: "\2605";
    position: absolute;
    left: 0;
    color: #FFD700;
}
</style>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                <h4 class="modal-title" id="feedbackModalLabel">Feedback to [[target_user.name]]</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-outline">
                            <form>

                                <h5>Rating & Reviews</h5>
                                <div class="rating d-flex">
                                    <input id="star5" type="radio" ng-model="feedbackModel.rating"
                                        ng-checked="feedbackModel.rating == 5 ? true : false" value="5"
                                        class="radio-btn hide" />
                                    <label for="star5">☆</label>
                                    <input id="star4" type="radio" ng-model="feedbackModel.rating"
                                        ng-checked="feedbackModel.rating == 4 ? true : false" value="4"
                                        class="radio-btn hide" />
                                    <label for="star4">☆</label>
                                    <input id="star3" type="radio" ng-model="feedbackModel.rating"
                                        ng-checked="feedbackModel.rating == 3 ? true : false" value="3"
                                        class="radio-btn hide" />
                                    <label for="star3">☆</label>
                                    <input id="star2" type="radio" ng-model="feedbackModel.rating"
                                        ng-checked="feedbackModel.rating == 2 ? true : false" value="2"
                                        class="radio-btn hide" />
                                    <label for="star2">☆</label>
                                    <input id="star1" type="radio" ng-model="feedbackModel.rating"
                                        ng-checked="feedbackModel.rating == 1 ? true : false" value="1"
                                        class="radio-btn hide" />
                                    <label for="star1">☆</label>
                                    <div class="clear"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="p-0">Comments</label>
                        <div class="form-outline">

                            <textarea class="form-control" ng-model="feedbackModel.comments"
                                placeholder="How good is your booking?">

                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" ng-click="cancelFeedback()" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn" ng-click="saveFeedback(e)">Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- Feedback Modal -->