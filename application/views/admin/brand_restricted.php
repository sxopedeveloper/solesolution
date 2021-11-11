<div class="row">
    <div class="col-lg-12">
        <div class="card brand_restricted">
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
                    <h4>Manage Restricted Brand</h4>
                    <div class="add-admin">
                      <button class="btn btn-primary mr-4" data-toggle="modal" data-target="#addpopUpmodal"> Add Brand</a>

                      <div class="dropdown mr-4">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item exportPdf" href="javascript:void(0);"><i class="fal fa-file-pdf red-icon mr-1"></i> Export PDF</a>
                                <a class="dropdown-item exportExcel" href="javascript:void(0);"><i class="far fa-file-excel green-icon mr-1"></i> Export Excel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-t-25">
                    <table id="datatable-scroller" class="table">
                        <thead>
                            <tr>
                                <th style="width: 70%;">Name</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 15%;">Action</th>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Brand</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form role="form" id="form-addNewRecord" name="form-addNewRecord" method="post"  role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Active</label>

                            <div class="form-group d-flex align-items-center mb-0">
                                <div class="switch m-r-10">
                                    <input type="checkbox" id="isActive" name="isActive">
                                    <label for="isActive"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="type" name="type" value="add">
                    <input type="hidden" id="editid" name="editid">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form action="" id="extrasearchForm" method="post">
</form>

<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-scroller').DataTable({
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>ProductController/ajax_datatable_brand_restricted",
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
                "added_by" : 1,
                "userId" : '<?php echo $this->session->userdata('userId');?>',
            },
            success: function (response)
            { 
              $("#type").val('edit');
              $("#editid").val(response.id);
              $("#name").val(response.name);
              var status = response.status == 'Y' ? true :  false;
              $("#isApproved").html(status);
              $("#isActive").prop('checked',status);
            }
          });
      });


      $('#form-addNewRecord').validate({ 
         rules:{
            name :{ required : true }
          },
          messages:{
            name :{ required : "Name is required" }
          },
          submitHandler: function (form) 
          {
            var formData = new FormData($(form)[0]);
            formData.append('td', '<?php echo base64_encode('brand_restricted') ?>');
            formData.append('i', '<?php echo base64_encode('id') ?>');
            formData.append('added_by', '1');
            formData.append('userId', '<?php echo $this->session->userdata('userId');?>');
            $.ajax({
                url: '<?php echo APP_URL; ?>CommonController/insertRecord',
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


    $(document).on("click",".exportPdf",function(e){
        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK; ?>manage-brand/export/pdf");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });

    $(document).on("click",".exportExcel",function(e){
        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK; ?>manage-brand/export/excel");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });
</script>