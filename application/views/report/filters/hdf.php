<p class="font-weight-bold text-center">Special Filter Option<p>
<?= form_label('Cut off Dates','cut_off') ?>
<select class="form-control" id="cut_off" name="cut_off">
    <option value="">Select Cut Off Dates</option>
    <?php
        if ($cutOff_list) {
            
            foreach($cutOff_list as $dates){

                ?>
                    <option value="<?= $dates['SUBMISSION_DATE'] ?>"><?= date("F d, Y",strtotime($dates['SUBMISSION_DATE'])) ?></option>
                <?php
            }

        } else {

            ?>
                <option value="">No Cut-Off date stored</option>
            <?php
        }
    ?>
</select>
<script type="text/javascript">

    $('#dateFields').fadeOut(1000);

</script>