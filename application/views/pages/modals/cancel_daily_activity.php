<!-- CANCEL DAILY ACTIVITY Modal -->
<?php if($activity): ?>
  <div class="modal fade" id="cancel_daily_activity" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirmation</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

         <div id="da_form_error"></div>

         <?php echo form_open_multipart('daily_activity/cancel_daily_activity', array( 'id' => 'cancel_da_form', 'class' => 'needs-validation', 'novalidate' => true));?>
          <div class="modal-body">
            <input type="hidden" class="form-control" id="cancel_activity_id" name="cancel_activity_id" value="<?= $activity->ACTIVITY_ID; ?>">
            <center>You are about to cancel this activity. Do you wish to proceed?</center>
           </div>
        
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Yes</button>
            <button type="button" data-dismiss="modal"  class="btn btn-outline-secondary">No</button>
          </div>
        <?php echo form_close();?>
      </div>
    </div>
  </div>
<?php endif; ?>
  <!-- End of CANCEL DAILY ACTIVITY Modal -->

