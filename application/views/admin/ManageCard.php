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
                    <h4>Manage Card</h4>
                    <div class="add-admin">
                      <button class="btn btn-primary" data-toggle="modal" data-target="#addpopUpmodal"> Add card</a>
                    </div>
                </div>
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th>Card Name</th>
                                <th>Card Limit</th>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Card</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form role="form" id="form-addNewRecord" name="form-addNewRecord" method="post"  role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Card Name</label>
                            <input type="text" name="card_name" id="card_name" class="form-control" placeholder="Card Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Card Limit</label>
                            <input type="text" name="card_limit" id="card_limit" class="form-control" placeholder="Card Limit" required>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="userId" name="userId" value="<?=$this->session->userdata('userId');?>">
                    <input type="hidden" id="store_id" name="store_id" value="<?php echo $store_id; ?>">
                    <input type="hidden" id="type" name="type" value="add">
                    <input type="hidden" id="editid" name="editid">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
                "url": "<?php echo ADMIN_LINK ?>ManageStore/ajax_get_card_datatable/<?php echo $store_id; ?>",
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

        $(document).on("click",".connectStore",function(){
            $('#connectStoreModal').modal('show');
        });

      $(document).on("click",".rowEdit",function(){
            
          $('#addpopUpmodal').modal('show');  
          var id = $(this).attr("data-id");      
          var field = $(this).attr("data-i");             
          var table = $(this).attr("data-td"); 

          $.ajax(
          {
            url: '<?php echo APP_URL ?>CommonController/getEditRecord',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
              $("#type").val('edit');
              $("#editid").val(response.id);
              $("#userId").val(response.userId);
              $("#card_name").val(response.card_name);
              $("#card_limit").val(response.card_limit);
            }
          });
      });


      $('#form-addNewRecord').validate({ 
         rules:{
            card_name :{ required : true },
            card_limit :{ required : true },
          },
          messages:{
            card_name :{ required : "Card Name is required" },
            card_limit :{ required : "Card Limit is required" },
          },
          submitHandler: function (form) 
          {
            var formData = new FormData($(form)[0]);
            formData.append('td', '<?php echo base64_encode('store') ?>');
            formData.append('i', '<?php echo base64_encode('id') ?>');

            $.ajax({
                url: '<?php echo ADMIN_LINK ?>ManageStore/storecard',
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