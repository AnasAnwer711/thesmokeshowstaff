  <!-- Feedback Modal -->
  <div class="modal fade" id="disputeModal" tabindex="-1" role="dialog" aria-labelledby="disputeModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                  <h4 class="modal-title" id="disputeModalLabel">Disputed to [[target_user.name]]</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-12 mt-2">
                          <label>Dispute Title</label>
                          <div class="form-outline">
                              <select class="form-control" ng-model="disputeModel.dispute_title_id">
                                  <option value="" selected>Select one of dispute title</option>
                                  <option value="[[dt.id]]" ng-repeat="dt in dispute_titles">[[dt.title]]</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-sm-12 mt-2">
                          <label>Concern</label>
                          <div class="form-outline">
                              <textarea class="form-control" ng-model="disputeModel.concern"
                                  placeholder="What's wrong with your booking?">

                            </textarea>
                          </div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                  <button type="button" class="btn" ng-click="saveDispute()">Confirm</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Feedback Modal -->