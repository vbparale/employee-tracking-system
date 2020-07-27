<p class="font-weight-bold text-center">Special Filter Option<p>
<?= form_label('Filter Sick People','sick_filter') ?>
<div class="row">
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="SickFilter" name="sick_filter" class="custom-control-input" value="Y">
            <label class="custom-control-label" for="SickFilter">Sick</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="SickFilter1" name="sick_filter" class="custom-control-input" value="N">
            <label class="custom-control-label" for="SickFilter1">Not Sick</label>
        </div>                        
    </div>
    <div class="col-4 col-sm-4 col-md-4 col-lg-4">
        <div class="custom-control custom-radio">
            <input type="radio" id="SickFilter2" name="sick_filter" class="custom-control-input" value="">
            <label class="custom-control-label" for="SickFilter2">Default</label>
        </div>                        
    </div>    
</div>
<script type="text/javascript">

    $('#dateFields').fadeIn(1000);
    
</script>