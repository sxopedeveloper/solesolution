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
                    <h4>Manage Duplicate ASIN</h4>
                </div>
                <!-- <button class="btn btn-primary removeLog">Remove all</button> -->
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th>ASIN NO</th>
                                <th>Amazone Seller</th>                                
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
                "url": "<?php echo ADMIN_LINK ?>ManageDuplicateASIN/ajax_datatable",
                "type": "POST"
            },            
            "scroller": {
                "loadingIndicator": true
            },
            "order": [
                [0, "desc" ],
            ],
            "columnDefs": [{"targets": 1, "orderable": false },]
        });
    });

    $(document).on("click",".removeLog",function(){ 
        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this data!",
            type: "info",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel Please!",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function (isConfirm) {
            
            if (isConfirm) {
                
                $.ajax({
                      url: "<?php echo ADMIN_LINK ?>ManageLog/deleteLog",
                      dataType: "JSON",
                      method:"POST",
                      success: function ()
                      {
                          $('#datatable-scroller').DataTable().ajax.reload();
                          swal("Deleted!", "Your data has been deleted.", "success");
                      }
                });

            }
        });           
    }); 
</script>