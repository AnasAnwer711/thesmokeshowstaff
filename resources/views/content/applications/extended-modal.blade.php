  <!-- Feedback Modal -->
  <div class="modal fade" id="extendedModal" tabindex="-1" role="dialog" aria-labelledby="extendedModalLabel">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> --}}
                  <h4 class="modal-title" id="extendedModalLabel">Extended Hours in [[job_applicant.job.title]]</h4>
              </div>
              <div class="modal-body">
                  <div class="row">
                      <div class="col-sm-12 mt-2">
                          <label>Extended Hours</label>
                          <div class="form-outline">
                              <select class="form-control" ng-model="extendedModal.job_extended_hours"
                                  ng-change="calculateRate()">
                                  <option value="">Select hours to extended duration</option>
                                  <option value="1">1 Hours</option>
                                  <option value="2">2 Hours</option>
                                  <option value="3">3 Hours</option>
                                  <option value="4">4 Hours</option>
                                  <option value="5">5 Hours</option>
                                  <option value="6">6 Hours</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-sm-12 mt-2" ng-if="extendedModal.job_extended_hours">
                          {{-- <label>Actual Hours:</label> --}}
                          <table class="table table-hover table-striped">
                              <tbody>
                                  <tr>
                                      <th colspan="2">INITIAL JOB DETAILS</th>
                                  </tr>
                                  <tr>
                                      <td>Initial Hours</td>
                                      <td>[[job_applicant.job_actual_hours]]</td>
                                  </tr>
                                  <tr>
                                      <td>Job Rate Per Hour</td>
                                      <td>$[[job_applicant.job_pay_rate]]</td>
                                  </tr>

                                  <tr>
                                      <td>Show Staff Charges ([[transaction_type == 'percent' ? staff_fee +'%' :
                                          'flat']])</td>
                                      <td>$[[portal_fee]]</td>
                                  </tr>
                                  <tr>
                                      <td>Initial Receiving</td>
                                      <td>$[[job_applicant.job_pay]]</td>
                                  </tr>

                                  <tr>
                                      <th colspan="2">EXTENDED JOB DETAILS</th>
                                  </tr>
                                  <tr>
                                      <td>Extended Hours</td>
                                      <td>[[extendedModal.job_extended_hours]]</td>
                                  </tr>

                                  <tr>
                                      <td>Job Rate Per Hour</td>
                                      <td>$[[job_applicant.job_pay_rate]]</td>
                                  </tr>

                                  <tr>
                                      <td>Show Staff Charges ([[transaction_type == 'percent' ? staff_fee +'%':
                                          'flat']])</td>
                                      <td>$[[extended_portal_fee]]</td>

                                  </tr>
                                  <tr>
                                      <td>Extended Receiving</td>
                                      <td>$[[extended_pay]]</td>
                                  </tr>
                                  <tr>
                                      <th colspan="2">FINAL DETAILS</th>
                                  </tr>


                                  <tr>
                                      <td>Total Receiving</td>
                                      <td>$[[extendedModal.job_pay]]</td>
                                  </tr>
                                  <tr>
                                      <td>Total Show Staff Fee</td>
                                      <td>$[[portal_fee + extended_portal_fee]]</td>
                                  </tr>
                              </tbody>
                          </table>

                      </div>

                  </div>
              </div>
              <div class="modal-footer">
                  {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> --}}
                  <button type="button" class="btn" ng-click="saveExtendedBooking()">Confirm</button>
              </div>
          </div>
      </div>
  </div>
  <!-- Feedback Modal -->
