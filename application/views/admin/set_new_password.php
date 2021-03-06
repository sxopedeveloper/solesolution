<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?> -  Set New Password</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('public/front/images/logo/'.$site_favicon );?>">
    <!-- page css -->

    <!-- style css -->
    <link href="<?php echo BACKEND; ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <!-- custom css -->
    <link href="<?php echo BACKEND; ?>assets/css/custom.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo COMMON;?>developer.css">
</head>

<body>
    <div class="app">
        <div class="container-fluid">
            <div class="d-flex full-height p-v-15 flex-column justify-content-between">
                <div class="d-none d-md-flex p-h-40">
                    <a href="<?=ADMIN_LINK;?>"><img src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" class="logo-inner"></a>
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-none d-md-block">
                            <img class="img-fluid" src="<?php echo BACKEND; ?>assets/images/forgot-password.png" alt="">
                        </div>
                        <div class="m-l-auto col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="m-t-20">Set New Password</h2>
                                    <p class="m-b-30">Let's help you</p>
                                    <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                                    <?php
                                      $error = $this->session->flashdata('error');
                                      if($error)
                                      {?>
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
                                      <form method="post" action="<?php echo base_url("admin/reset/".$token)?>" name="MyForm" id="MyForm">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">New Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password1">Confirm New Password:</label>
                                            <input type="password" class="form-control" id="password1" name="confirm_password" placeholder="Confirm Password">
                                        </div>
                                        <input type="hidden" name="user_id" id="user_id" value="<?= $user_id; ?>">
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between p-t-15">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex  p-h-40 justify-content-end">
                    <!-- <span class="">© 2019</span> -->
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="#">Privacy Policy</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-dark text-link" href="#">Terms and Conditions</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Core Vendors JS -->
    <script src="<?php echo BACKEND; ?>assets/js/vendors.min.js"></script>
    <!-- page js -->

    <!-- Core JS -->
    <script src="<?php echo BACKEND; ?>assets/js/app.min.js"></script>
    <script src="<?php echo COMMON;?>jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo COMMON;?>bootstrap-notify.js" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function(){
          $("#MyForm").validate({
            rules:{                           
               password : { required : true},
               confirm_password:{required : true,equalTo: "#password"},
             },
             messages:{
               password :{ required : "Enter new password is required" },
               confirm_password:{
                   required:"Please enter your retype password.",
                   equalTo:"Confirm password is not match."
               },
             }
         });
       });
    </script>
</body>

</html>