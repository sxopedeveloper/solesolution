<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php
                    $error = $this->session->flashdata('error');
                    if($error)
                    {
                ?>
                    <div class="alert alert-danger alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $error; ?>                    
                    </div>
                <?php } 

                    $success = $this->session->flashdata('success');
                    if($success)
                    {
                ?>
                    <div class="alert alert-success alert-dismissable">
                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                          <?php echo $success; ?>                    
                    </div>
                <?php } ?>
                <div class="d-flex align-items-center block-title">
                    <h4>Change Password</h4>
                </div>
                <form id="MyForm" name="MyForm" action="<?php echo ADMIN_LINK; ?>update-password" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="editid" value="<?php echo $edit['id'];?>">

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Current Password</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" value="" placeholder="Enter Current Password" maxlength="20">
                        </div>
                        <div class="form-group col-md-8">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" value="" placeholder="Enter New Password" maxlength="20"> 
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="" placeholder="Re-enter New Password" maxlength="20">
                        </div>
                    </div>

                    <div class="form-row align-items-center justify-content-end">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo BACKEND; ?>assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(".datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
    });

    $("#MyForm").validate({
        //ignore: [],
        rules: {              
            old_password:{required:true},
            new_password:{required:true},
            confirm_password:{required:true, equalTo:"#new_password"},
        },
        messages: {
            old_password:{required:"Please enter current password."},
            new_password:{required:"Please enter new password."},
            confirm_password:{required:"Please re-enter new password.", equalTo:"New and Confirm passwords do not match."},
        }, 
        errorPlacement: function(error, element) 
        {
            error.insertAfter(element); 
        }
     });
</script>