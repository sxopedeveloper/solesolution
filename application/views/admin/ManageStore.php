<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css">
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
                    <h4>Manage Store</h4>
                    <div class="add-admin">
                    <?php 
                        if($user_role < 3)
                        {
                    ?>
                      <button class="btn btn-primary" data-toggle="modal" data-target="#addpopUpmodal"> Add Store</button>
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
                                <th>Store Name</th>
                                <?php 
                                if($user_role == 1 || $user_role == 2)
                                {
                                ?>
                                <th>User Name</th>
                                <?php 
                                }
                                ?>
                                <th>Status</th>
                                <?php 
                                //if($user_role <= 3)
                                {
                                ?>
                                <th>Action</th>
                            <?php } ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Store</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form role="form" id="form-addNewRecord" name="form-addNewRecord" method="post"  role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Store Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" required <?php echo ($user_role > 3)?'readonly':''; ?>>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Amazon SellerId</label>
                            <input type="text" name="AmazonSellerId" id="AmazonSellerId" class="form-control" placeholder="Amazon SellerId" required <?php echo ($user_role > 3)?'readonly':''; ?>>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Refresh Token</label>
                            <input type="text" name="refresh_token" id="refresh_token" class="form-control" placeholder="Refresh Token" required <?php echo ($user_role > 3)?'readonly':''; ?>>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Client Id</label>
                            <input type="text" name="client_id" id="client_id" class="form-control" placeholder="Client Id" required <?php echo ($user_role > 3)?'readonly':''; ?>>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Client Secret</label>
                            <input type="text" name="client_secret" id="client_secret" class="form-control" placeholder="Client Secret" required <?php echo ($user_role > 3)?'readonly':''; ?>>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="userId" name="userId" value="<?=$this->session->userdata('userId');?>">
                    <input type="hidden" id="type" name="type" value="add">
                    <input type="hidden" id="editid" name="editid">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php 
                        if($user_role <= 3) {
                    ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <?php
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addpopUpmodal1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Manager</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form role="form" id="form-addNewRecord1" name="form-addNewRecord1" method="post"  role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Select Manager</label>
                            <select name="manager[]" id="manager" class="form-control" multiple>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="editid1" name="editid">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <?php 
                        if($user_role <= 3) {
                    ?>
                    <button type="button" id="manager_submit" class="btn btn-primary">Submit</button>
                    <?php
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="connectStoreModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="m-auto">
                <img style="width: 40px;height: auto;" src="<?=FRONT_IMG?>store-connect-amazon.webp">
                <h5 class="modal-title h4 ml-2">Allow <?=$site_name;?> to access your Amazon Seller Central Account?</h5>
            </div>
                <button type="button" class="close p-0" data-dismiss="modal" style="position: absolute;right: 30px;top: 30px;">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form id="form-updateOrder" name="form-updateOrder" method="post" role="form" enctype="multipart/form-data" action="#">
                <div class="modal-body">
                    <div class="form-row row justify-content-center"> 
                        <div class="col-md-6">
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Seller ID (required)</label>
                            <p>To get these credentials, open <a href="https://sellercentral.amazon.com/gp/account-manager/home.html" target="_blank" rel="noopener noreferrer nofollow">this page</a> and select Visit Manage Your Apps, then select Authorize new developer. Enter Zapier for Developer's Name and 6222-9004-0945 for Developer ID.</p>
                            <input type="text" name="seller_id" id="seller_id" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="font-weight-semibold">MWS Auth Token (required)</label>
                            <small>(see instructions above).</small>
                            <input type="text" class="form-control" name="mws_auth_token" id="mws_auth_token" placeholder=""/>
                        </div>
                         <div class="form-group col-md-12">
                            <label class="font-weight-semibold">Region (optional)</label>
                            <p>The Amazon region that hosts your Marketplace. If left blank, then the North America region will be used.
                            <br><br>
                            If you are outside of the North America region, Amazon Seller Central will not allow you to connect. Please <a href="https://sellercentral.amazon.com/gp/mws/contactus.html" target="_blank" rel="noopener noreferrer nofollow">fill out this form</a> to let Amazon's Marketplace Services team know that you would like to use Zapier with regions outside of North America!</p>
                            <select class="form-control" name="region" id="region">
                                <option value=""></option>
                                <option value="North America">North America</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes, Continue</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatable-scroller').DataTable({
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>ManageStore/ajax_datatable",
                "type": "POST"
            },            
            "scroller": {
                "loadingIndicator": true
            },
            "order": [
                [0, "ASC" ],
            ],
            "columnDefs": [{"targets": 2, "orderable": false },]
        });
    });
    
    function initDateRange(datepicker) {
        $(datepicker).daterangepicker({
            dateLimit: { days: 2 },
            maxDate: new Date(),
            locale: {
                format: 'YYYY/MM/DD'
            },
            autoApply: true,
        });
    }

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
              $("#name").val(response.name);
              $("#userId").val(response.userId);
              $("#AmazonSellerId").val(response.AmazonSellerId);
              $("#refresh_token").val(response.refresh_token);
              $("#client_id").val(response.client_id);
              $("#client_secret").val(response.client_secret);
              <?php 
                echo ($user_role <= 3)?"$('#exampleModalLabel').text('Edit Store');":"$('#exampleModalLabel').text('View Store');";
              ?>
            }
          });
      });
      
    // $(document).on("click",".rowFetchOrder",function(){
    //     var id = $(this).attr("data-id");
    //     var $this = $(this);
    //     $.ajax(
    //     {
    //         url: '<?php echo ADMIN_LINK ?>AmazonOrderController/getOrderlist',
    //         dataType: "JSON",
    //         method:"POST",
    //         data: {
    //             "id": id,
    //         },
    //         beforeSend: function() {
    //             $this.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw" style="color: white;"></i>');
    //             $this.prop('disabled', true); // disable button
    //         },
    //         success: function (response)
    //         {
    //             console.log(response.message);
    //             $this.html('Fetch order');
    //             $this.prop('disabled', false); // enable button
    //             if (response.success == true) {
    //                 swal(response.message);
    //             } else {
    //                 swal("Something is wrong please try again!", "error");
    //             }

    //         }
    //     });
    // });
    
    $(document).on("click",".rowFetchOrderByDate",function(){
        var id = $(this).attr("data-id");
        var selectedDate = $('.dateRange'+id).val();
        selectedDate = (selectedDate) ? selectedDate.split('-') : '';
        if (selectedDate.length == 0) {
            swal("Please select date!", "error");
            return false;
        }

        var dates = []; 
        $(selectedDate).each(function(index, value) {
          dates.push(moment(value).format('YYYY-MM-DD'));
        });
        
        var $this = $(this);
        $.ajax(
        {
            url: '<?php echo ADMIN_LINK ?>AmazonOrderController/getOrderlist',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "selectedDate": dates,
            },
            beforeSend: function() {
                $this.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw" style="color: white;"></i>');
                $this.prop('disabled', true); // disable button
            },
            success: function (response)
            {
                $this.html('Wait...<span id="countdowntimer">5</span>');
                $this.css({"color": "rgb(255, 255, 255)"});
                var timeleft = 5;
                var downloadTimer = setInterval(function(){
                timeleft--;
                
                document.getElementById("countdowntimer").textContent = timeleft;
                if(timeleft <= 0)
                    clearInterval(downloadTimer);
                },1000);
                
                setTimeout(function(){

                    $this.html('Fetch order By Date');
                    $this.prop('disabled', false); // enable button
                    if (response.success == true) {
                        swal(response.message);
                        initDateRange($('.dateRange'+id));
                    } else {
                        swal("Something is wrong please try again!", "error");
                    }

                },5000);

            }
        });
    });

    $(document).on("click",".addmanager",function(){
        var id = $(this).data('id');
        $('#addpopUpmodal1').modal('show');  
        $.ajax(
        {
            url: '<?php echo ADMIN_LINK ?>ManageStore/getManager',
            method:"POST",
            data: {"id": id},
            success: function (response)
            { 
                $("#editid1").val(id);
                $("#manager").html(response);
            }
        });
    });

    $(document).on("click","#manager_submit",function(){
        var formData = $("#form-addNewRecord1").serialize();
        $.ajax({
            url: '<?php echo ADMIN_LINK ?>ManageStore/setManager',
            type: 'POST',
            data: formData,
            dataType:'json',
            success: function (response) 
            {
                // //return false;
                swal(response.msg);
                // $('#datatable-scroller').DataTable().ajax.reload();
                $('#addpopUpmodal1').modal('hide');
                $('#form-addNewRecord1')[0].reset();
            }
        });
    }); 


      $('#form-addNewRecord').validate({ 
         rules:{
            name :{ required : true },
            AmazonSellerId :{ required : true },
            refresh_token :{ required : true },
            client_id :{ required : true },
            client_secret :{ required : true },
          },
          messages:{
            name :{ required : "Name is required" },
            AmazonSellerId :{ required : "Amazon SellerId is required" },
            refresh_token :{ required : "Refresh token is required" },
            client_id :{ required : "client id is required" },
            client_secret :{ required : "client secret is required" },
          },
          submitHandler: function (form) 
          {
            var formData = new FormData($(form)[0]);
            formData.append('td', '<?php echo base64_encode('store') ?>');
            formData.append('i', '<?php echo base64_encode('id') ?>');

            $.ajax({
                url: '<?php echo ADMIN_LINK ?>ManageStore/store',
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