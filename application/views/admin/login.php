<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $site_name; ?> -  Admin Panel</title>

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
    <div class="app login-details">
        <div class="container-fluid">
            <div class="d-flex full-height p-v-15 flex-column justify-content-between">
                <div class="d-none d-md-flex p-h-40">
                    <a href="<?=ADMIN_LINK;?>"><img src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" class="logo-inner"></a>
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-5 col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="m-t-20">Sign In</h2>
                                    <p class="m-b-30">Enter your credential to get access</p>

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

                                    <form method="post" id="MyForm" action="<?php echo base_url(); ?>loginMe">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="email">Email:</label>
                                            <div class="input-affix email-error">
                                                <i class="prefix-icon anticon anticon-user"></i>
                                                <input type="text" class="form-control" name="email" id="email" placeholder="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Password:</label>
                                            <a class="float-right font-size-13 text-muted" href="<?php echo base_url("admin/forgot-password");?>">Forgot Password?</a>
                                            <div class="input-affix m-b-10 password-error">
                                                <i class="prefix-icon anticon anticon-lock"></i>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between signup-link">
                                                <span class="font-size-13 text-muted">
                                                    Don't have an account? 
                                                    <a class="small" href="<?php echo base_url("admin/signup");?>"> Signup</a>
                                                </span>
                                                <button class="btn btn-primary signup-btn">Sign In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="offset-lg-1 col-lg-6 col-md-5 d-none d-md-block">
                            <img class="img-fluid" src="<?php echo BACKEND; ?>assets/images/login.png" alt="">
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
             ignore: [],
             rules: {              
                email:{required : true,email:true},
                password:{required : true},
             },
             messages: {
                email:{required:"Please enter your email.",email:"Please enter valid email address."},
                password:{required:"Please enter your password."},
             }, 
             errorPlacement: function(error, element) {
                if (element.attr('name') == 'email')
                {
                   error.insertAfter(".email-error");
                }
                else if (element.attr('name') == 'password')
                {
                   error.insertAfter(".password-error");
                }
                else 
                {
                   error.insertAfter(element);
                } 
             }
          });
       });
    </script>
</body>

</html>