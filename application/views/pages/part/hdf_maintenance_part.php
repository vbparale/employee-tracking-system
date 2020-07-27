<div class="col-lg-12 col-md-12">
  <div class="col-lg-12 col-md-8" style="padding-top: 50px;">
    <div id="hdf_maintenance_table">
        <table class="table table-bordered display" id="cutoff_table" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Cutoff ID</th>
                    <th scope="col">Required Users</th>
                    <th scope="col">Submission Date</th>
                    <th scope="col">Cutoff Time</th>
                </tr>
            </thead>
        </table>

        <div class="mb-3 float-right" style="padding: 20px;">
            <button class="btn btn-primary my-2 mr-2" type="button" id="add_hdf_btn" data-toggle="modal" data-target="#add_hdf_cutoff"><span class="fa fa-plus"></span> Add Cutoff</button>
            <button class="btn btn-outline-success my-2 mr-2" id="edit_hdf_btn" type="button"><span class="fa fa-edit"></span> Edit Cutoff</button>
        </div>
    </div>
</div>

<?= $this->load->view('pages/modals/add_hdf_cutoff', '', TRUE) ?>
<?= $this->load->view('pages/modals/edit_hdf_cutoff', '', TRUE) ?>

