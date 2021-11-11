<style type="text/css">
    div.scrollSelect {
      height: 200px;
      overflow-y: scroll;
    }
    .error p {
        color: red;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center block-title">
                    <h4>Add Admin</h4>
                    <div class="add-admin">
                        <a href="<?=base_url("admin/manage-admin")?>" class="btn btn-primary">Back</a>
                    </div>
                </div>
                <form id="MyForm" name="MyForm" action="<?php echo ADMIN_LINK; ?>admin-store" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="type" id="type" value="<?php echo $type;?>">
                    <?php if(isset($edit)): ?>
                    <input type="hidden" name="editid" value="<?php echo $editid;?>">
                    <?php endif ?>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">First Name</label>
                            <input type="text" id="fname" name="fname" class="form-control" placeholder="First name" value="<?= isset($edit['fname'])?$edit['fname']:set_value('fname') ?>">
                            <div class="error">
                                <?php echo form_error('fname'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Last Name</label>
                            <input type="text" id="lname" name="lname" class="form-control" placeholder="Last Name" value="<?= isset($edit['lname'])?$edit['lname']:set_value('lname') ?>">
                            <div class="error">
                                <?php echo form_error('lname'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Email</label>
                            <input type="text" id="email" name="email" class="form-control" placeholder="Email" value="<?= isset($edit['email'])?$edit['email']:set_value('email') ?>">
                            <div class="error">
                                <?php echo form_error('email'); ?>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Phone</label>
                            <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Phone" value="<?= isset($edit['mobile'])?$edit['mobile']:set_value('mobile') ?>"  onkeypress="return checkOnlyDigits(event)">
                            <div class="error">
                                <?php echo form_error('mobile'); ?>
                            </div>
                        </div>
                        <?php 
                        if(isset($edit))
                        {
                            if($edit['roleId']!=1)
                            {
                                $role_dis = 1;  
                            }
                            else
                            {
                                $role_dis = 0;  
                            }
                        }
                        else
                        {
                            $role_dis = 1;
                        }

                        if($role_dis == 1)
                        {
                        ?>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Role</label>
                            <select class="form-control" name="roleId" id="roleId">
                                <option value="">Choose Role</option>
                                <?php 
                                foreach ($role_lists as $role_list) 
                                {
                                    $sel = ($role_list->id==$edit['roleId']) ? 'selected' : '';
                                ?>
                                <option <?php echo $sel ?> value="<?php echo $role_list->id; ?>"><?php echo $role_list->role; ?></option>
                                <?php } ?>
                            </select>
                            <div class="error"> 
                                <?php echo form_error('roleId'); ?>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>

                        <?php if($type == "add") :?>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                        </div>
                        <?php endif ?>
                        <?php 
                        if(count($stores) > 0 && $role_dis == 1 && ($user_role_id == 1 || $user_role_id == 2)) :?>
                        <div class="form-group col-md-4 scrollSelect">
                            <label class="font-weight-semibold">Stores</label>
                            <div class="checkbox">
                                <input id="selectall" name="" type="checkbox" value="8">
                                <label for="selectall">Select All</label>
                            </div>
                            <?php
                            $selected_store = array();
                            if( isset($edit) ) 
                                $selected_store = explode(",",$edit['store_id']);
                            
                                $i=0; 
                                foreach ($stores as $store) { ?>
                                <div class="checkbox">
                                    <input id="checkbox<?= $i; ?>" name="store_id[]" type="checkbox" value="<?php echo $store->id; ?>" <?php echo in_array($store->id, $selected_store) ? "checked" : ""; ?>>
                                    <label for="checkbox<?= $i; ?>"><?php echo $store->name; ?></label>
                                </div>
                            <?php $i++; 
                                } 
                            ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <!-- <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="font-weight-semibold">Permission</label>
                            <label class="font-weight-semibold d-block">Product Module</label>
                            <div class="d-flex mt-2">
                                <div class="checkbox mr-5">
                                    <input type="checkbox" id="gridCheck1">
                                    <label for="gridCheck1">
                                        Add Product
                                    </label>
                                </div>
                                <div class="checkbox mr-5">
                                    <input type="checkbox" id="gridCheck2">
                                    <label for="gridCheck2">
                                        Edit Products                                                    
                                    </label>
                                </div>
                                <div class="checkbox mr-5">
                                    <input type="checkbox" id="gridCheck3">
                                    <label for="gridCheck3">
                                        Delete Product
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="form-row align-items-center justify-content-end">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#selectall').click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
     
    $("#MyForm").on('submit', function() {
        $('.error p').html(''); 
    });
    $("#MyForm").validate({
        //ignore: [],
        rules: {              
           fname:{required : true},
           lname:{required : true},
           email:{required : true,email:true},
           mobile:{required : true,digits: true,maxlength: 12},
           roleId:{required : true},
           password:{required : true},
        },
        messages: {
           fname:{required:"Please enter your first name."},
           lname:{required:"Please enter your last name."},
           email:{required:"Please enter your email.",email:"Please enter valid email address."},
           mobile:{required:"Please enter your phone number.",digits:"Please enter valid phone number.",maxlength:"Please enter valid phone number."},
           roleId:{required:"Please select role."},
           password:{required:"Please enter your password."},
        }, 
        errorPlacement: function(error, element) 
        {
            error.insertAfter(element); 
        }
     });
</script>