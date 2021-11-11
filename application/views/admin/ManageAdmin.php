<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php $success = $this->session->flashdata('success');
                if($success){?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php } ?>
                <?php $error = $this->session->flashdata('error');
                if($error){?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>

                <div class="d-flex align-items-center block-title">
                    <h4>Manage Admin</h4>
                    <div class="add-admin">
                    <?php if($user_role == 1) { ?>
                        <a href="<?php echo ADMIN_LINK.'manage-admin/add'; ?>" class="btn btn-primary"> Add User</a>
                    <?php } ?>
                    </div>
                </div>
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th style="width: 30%;">Email</th>
                                <th style="width: 30%;">Name</th>
                                <th style="width: 25%;">Phone</th>
                                <th style="width: 25%;">Role</th>
                                <th style="width: 25%;">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-scroller').DataTable({
            "serverSide": false,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>ManageAdmin/ajax_datatable",
                "type": "POST"
            },            
            "paging":true,
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [{"targets": 4, "orderable": false },]

        });
    });
</script>