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
    <div class="app">
        <div class="container-fluid">
            <div class="d-flex full-height p-v-20 flex-column justify-content-between">
                <div class="d-none d-md-flex p-h-40">
                    <a href="<?=ADMIN_LINK;?>"><img src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" class="logo-inner"></a>
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-none d-md-block">
                            <img class="img-fluid" src="<?php echo BACKEND; ?>assets/images/sign-up.png" alt="">
                        </div>
                        <div class="m-l-auto col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="m-t-20">Sign Up</h2>
                                    <p class="m-b-30">Create your account to get access</p>

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

                                    <form method="post" action="<?php echo base_url(); ?>admin/signup-process" id="MyForm">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="fname">First Name:</label>
                                            <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="lname">Last Name:</label>
                                            <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="email">Email:</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="mobile">Phone:</label>
                                            <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Phone">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Password:</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="confirm_password">Confirm Password:</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                                        </div>
                                        <div class="form-group change-error-block">
                                            <div class="d-flex align-items-center justify-content-between p-t-15">
                                                <div class="checkbox">
                                                    <input id="checkbox" type="checkbox" name="agree_term" id="agree_term">
                                                    <label for="checkbox" class="terms_checkbox"><span>I have read the <a href="#">agreement</a></span></label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Sign Up</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none d-md-flex  p-h-40 justify-content-end">
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
                fname:{required : true},
                lname:{required : true},
                email:{required : true,email:true},
                mobile:{required : true, number : true},
                password:{required : true},
                confirm_password:{required : true,equalTo: "#password"},
                agree_term:{required : true},
             },
             messages: {
                fname:{required:"Please enter your first name."},
                lname:{required:"Please enter your last name."},
                email:{required:"Please enter your email.",email:"Please enter valid email address."},
                mobile:{required:"Please enter your mobile number.", number : "Please enter valid mobile number."},
                password:{required:"Please enter your password."},
                confirm_password:{
                    required:"Please enter your retype password.",
                    equalTo:"Confirm password is not match."
                },
                agree_term:{required:"You must agree to the terms and conditions before submitting the details."},
             }, 
             errorPlacement: function(error, element) {
                if (element.attr('name') == 'agree_term')
                {
                   error.insertAfter(".terms_checkbox");
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