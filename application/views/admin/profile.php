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
                    <h4>Edit Profile</h4>
                   <!--  <div class="add-admin">
                        <a href="<?//=base_url("admin/manage-profile")?>" class="btn btn-primary">Back</a>
                    </div> -->
                </div>
                <form id="MyForm" name="MyForm" action="<?php echo ADMIN_LINK; ?>update-profile" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="type" id="type" value="edit">
                    <input type="hidden" name="editid" value="<?php echo $edit['id'];?>">
                    <?php
                        $ardt = explode('-', $edit['dob']);
                        $edit['dob'] = $ardt[1].'/'.$ardt[2].'/'.$ardt[0];
                    ?>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">First Name</label>
                            <input type="text" id="fname" name="fname" class="form-control" placeholder="First name" value="<?= isset($edit['fname'])?$edit['fname']:set_value('fname') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Last Name</label>
                            <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" value="<?= isset($edit['lname'])?$edit['lname']:set_value('lname') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= isset($edit['email'])?$edit['email']:set_value('email') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Phone</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Phone" value="<?= isset($edit['mobile'])?$edit['mobile']:set_value('mobile') ?>"  onkeypress="return checkOnlyDigits(event)">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Date of Birth</label>
                            <input type="text" id="dob" name="dob" class="form-control datepicker" placeholder="Date of Birth" value="<?= isset($edit['dob'])?$edit['dob']:set_value('dob') ?>">
                        </div>
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Address 1</label>
                            <input type="text" id="address1" name="address1" class="form-control" placeholder="Address 1" value="<?= isset($edit['address1'])?$edit['address1']:set_value('address1') ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Address 2</label>
                            <input type="text" id="address2" name="address2" class="form-control" placeholder="Address 2" value="<?= isset($edit['address2'])?$edit['address2']:set_value('address2') ?>">
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
           fname:{required : true},
           lname:{required : true},
           email:{required : true,email:true},
           mobile:{required : true,digits: true,maxlength: 12},
        },
        messages: {
           fname:{required:"Please enter your first name."},
           lname:{required:"Please enter your last name."},
           email:{required:"Please enter your email.",email:"Please enter valid email address."},
           mobile:{required:"Please enter your phone number.",digits:"Please enter valid phone number.",maxlength:"Please enter valid phone number."},
        }, 
        errorPlacement: function(error, element) 
        {
            error.insertAfter(element); 
        }
     });
</script>