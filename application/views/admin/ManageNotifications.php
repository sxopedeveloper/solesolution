<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php $success = $this->session->flashdata('success');
                if ($success) {?>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
                <?php }?>
                <?php $error = $this->session->flashdata('error');
                if ($error) {?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
                <?php }?>

                <div class="d-flex align-items-center block-title">
                    <h4>Manage Notifications</h4>
                </div>
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Notification</th>
                                <th>Type</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Action</th>
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
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>NotificationController/ajax_datatable",
                "type": "POST"
            },
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [{"targets": 2, "orderable": false },]
        });
    });
</script>