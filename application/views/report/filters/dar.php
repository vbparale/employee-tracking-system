<p class="font-weight-bold text-center">Special Filter Option<p>
<?= form_label('Activity Status','dar_status') ?>
<div class="row">
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus" name="dar_status" class="custom-control-input" value="Confirmed">
            <label class="custom-control-label" for="darStatus">Confirmed</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus1" name="dar_status" class="custom-control-input" value="x">
            <label class="custom-control-label" for="darStatus1">For Confirmation</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus2" name="dar_status" class="custom-control-input" value="Denied">
            <label class="custom-control-label" for="darStatus2">Denied</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus3" name="dar_status" class="custom-control-input" value="Done">
            <label class="custom-control-label" for="darStatus3">Done</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus4" name="dar_status" class="custom-control-input" value="Cancelled">
            <label class="custom-control-label" for="darStatus4">Cancelled</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="darStatus5" name="dar_status" class="custom-control-input" value="">
            <label class="custom-control-label" for="darStatus5">All</label>
        </div>                        
    </div>            
</div>
<script type="text/javascript">

    $('#dateFields').fadeIn(1000);
    
</script>