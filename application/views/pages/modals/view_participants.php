<!-- VIEW PARTICIPANTS Modal -->

  <div class="modal fade" id="view_participants" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Participants</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      
        <div class="modal-body">
          <?php if($participants || $visitors || $activity_details): ?>
          <div class="row">
             <div class="col-lg-12 col-md-12 mb-3">
              <?php 
              if($activity_details->HOST_NAME) {
                echo '<b>Host Employee: </b>' . $activity_details->HOST_NAME;
                 // if with MEETIND ID = CONFIRMED by HOST, If status DENIED = DENIED by HOST, Else FOR CONFIRMATION
                 
               if ($visitors) {
                 if($visitors[0]->MEETING_ID) {
                   echo "<b> - CONFIRMED</b>";
                 }elseif(!$visitors[0]->MEETING_ID AND $activity_details->STATUS == 'DENIED') {
                    echo "<b> - DENIED</b>";
                 } else {
                   echo "<b> - For Confirmation</b>";
                 }
               }

             }
              ?>
            </div>
            <?php if($participants): ?>
            <div class="col-lg-12 col-md-12 mb-3">
              <label for="" style="font-weight: 600">Participants</label>
              <ul class="list-group">
              <?php foreach ($participants as $participant) : ?>
                <li class="list-group-item">
                  <?= $participant->EMP_FNAME; ?> <?= $participant->EMP_LNAME; ?>
                  <span style="font-weight: 600;">- 
                    <?php if($participant->STATUS != ""){
                      echo $participant->STATUS;
                    } else {
                      echo "For Confirmation";
                    } ?></span>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
            <?php endif; ?>

            <?php if($visitors): ?>
            <div class="col-lg-12 col-md-12 mb-3">
              <label for="" style="font-weight: 600">Visitors</label>
               <ul class="list-group">
              <?php foreach ($visitors as $visitor) : ?>
                <li class="list-group-item">
                  <?= $visitor->VISIT_FNAME; ?> <?= $visitor->VISIT_LNAME; ?><br>
                  <b>Meeting ID: </b><?= $visitor->MEETING_ID ?>
                </li>
              <?php endforeach; ?>
              </ul>
            </div>
            <?php endif?>
              
          </div>
          <?php else:?>
            <div class="alert alert-danger" role="alert">
              No Participants/Visitors for this Activity.
            </div>
          <?php endif; ?>
          
        </div>

      </div>
    </div>
  </div>

  <!-- End of VIEW PARTICIPANTS Modal -->

