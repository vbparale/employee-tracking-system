<p class="font-weight-bold text-center">Special Filter Option<p>
<?= form_label('Visitor Status','visitor_status') ?>
<div class="row">
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="VisitorStatus" name="visitor_status" class="custom-control-input" value="On-going">
            <label class="custom-control-label" for="VisitorStatus">On Going</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="VisitorStatus1" name="visitor_status" class="custom-control-input" value="Done">
            <label class="custom-control-label" for="VisitorStatus1">Done</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="VisitorStatus2" name="visitor_status" class="custom-control-input" value="">
            <label class="custom-control-label" for="VisitorStatus2">All</label>
        </div>                        
    </div>    
</div>
<script type="text/javascript">

    $('#dateFields').fadeIn(1000);
    
</script>