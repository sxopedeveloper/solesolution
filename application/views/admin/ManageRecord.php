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
                    <h4>Manage record</h4>
                    <div class="add-admin">
                    <?php 
                        if($user_role < 3)
                        {
                    ?>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#addpopUpmodal"> Add record</button>
                    <?php
                        }
                    ?>
                      <!-- <a class="btn btn-primary ml-2" href="<?php echo ADMIN_LINK; ?>manage-card/add/"> Add Card</a> -->
                    </div>
                </div>
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Store Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addpopUpmodal" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Upload Record File</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form role="form" id="form-addNewRecord" name="form-addNewRecord" method="post" role="form" enctype="multipart/form-data" action="javascript:void(0);">
                <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold">Record File</label>
                        <input type="file" class="form-control" name="recordfile" id="recordfile">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="font-weight-semibold">Store</label>
                        <select name="store_id" id="store_id" class="form-control">
                            <option value="">Select the store</option>
                            <?php if(count($stores) > 0){
                                foreach ($stores as $store) { ?>
                                    <option value="<?php echo $store->id; ?>"><?php echo $store->name; ?></option>
                                <?php }
                            } ?>
                        </select>
                    </div>
                </div>
                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-scroller').DataTable({
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>ManageRecord/ajax_datatable",
                "type": "POST"
            },            
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [{"targets": 2, "orderable": false },]
        });
    });

    $('.modal').on('hidden.bs.modal', function(){
          $(this).find('form')[0].reset();
          $("#type").val('add');
          $("#editid").val();
      });


      $('#form-addNewRecord').validate({ 
         rules:{
            recordfile :{ required : true },
            store_id :{ required : true },
          },
          messages:{
            recordfile :{ required : "please upload recorded file" },
            store_id :{ required : "please select the store" },
          },
          submitHandler: function (form) 
          {
            var formData = new FormData($(form)[0]);
            formData.append('td', '<?php echo base64_encode('manage_files') ?>');
            formData.append('i', '<?php echo base64_encode('id') ?>');

            $.ajax({
                url: '<?php echo ADMIN_LINK ?>ManageRecord/store',
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                dataType:'json',
                success: function (response) 
                {
                  //return false;
                  swal(response.msg);
                  $('#datatable-scroller').DataTable().ajax.reload();
                  $('#addpopUpmodal').modal('hide');
                  $('#form-addNewRecord')[0].reset();
                }
            });
            return false;
          }
      });
</script>