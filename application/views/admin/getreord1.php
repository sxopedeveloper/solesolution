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
            <div class="d-flex full-height p-v-15 flex-column justify-content-between">
                <div class="d-none d-md-flex p-h-40">
                    <img src="<?php echo base_url('public/front/images/logo/'.$site_logo );?>" class="logo-inner">
                </div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="m-t-20">Get Record</h2>
                                    <form method="post" id="MyForm" action="<?php echo base_url(); ?>cron/getrecordsubmit">
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="start_date">Start Date:</label>
                                            <div class="input-affix start_date-error">
                                                <input type="text" class="form-control datepicker" name="start_date" id="start_date" placeholder="Start Date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">End Date:</label>
                                            <div class="input-affix m-b-10 end_date-error">
                                                <input type="text" class="form-control datepicker" name="end_date" id="end_date" placeholder="End Date">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Amazon SellerId:</label>
                                            <div class="input-affix m-b-10 SellerId-error">
                                                <input type="text" class="form-control" name="SellerId" id="SellerId" placeholder="Amazon SellerId">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Client Id:</label>
                                            <div class="input-affix m-b-10 client_id-error">
                                                <input type="text" class="form-control" name="client_id" id="client_id" placeholder="Client Id">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Client Secret:</label>
                                            <div class="input-affix m-b-10 client_secret-error">
                                                <input type="text" class="form-control" name="client_secret" id="client_secret" placeholder="Client Secret">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-semibold" for="password">Refresh Token:</label>
                                            <div class="input-affix m-b-10 refresh_token-error">
                                                <input type="text" class="form-control" name="refresh_token" id="refresh_token" placeholder="Refresh Token">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="offset-md-1 col-md-6 d-none d-md-block">
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
    <script src="<?php echo BACKEND; ?>assets/js/bootstrap-datepicker.js"></script>

    <script>
        $(".datepicker").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('update', new Date());


        $(document).ready(function(){
          $("#MyForm").validate({
             ignore: [],
             rules: {              
                start_date:{required : true},
                end_date:{required : true},
                client_id:{required : true},
                client_secret:{required : true},
                refresh_token:{required : true},
                SellerId:{required : true}
             },
             messages: {
                start_date:{required : "Please enter start date"},
                end_date:{required : "Please enter end date"},
                client_id:{required : "please enter client id"},
                client_secret:{required : "please enter client secret"},
                refresh_token:{required : "Please enter refresh token"},
                SellerId:{required : "Please enter Amazon SellerId"}
             }, 
             errorPlacement: function(error, element) {
                if (element.attr('name') == 'start_date')
                {
                   error.insertAfter(".start_date-error");
                }
                else if (element.attr('name') == 'end_date')
                {
                   error.insertAfter(".end_date-error");
                }
                else if (element.attr('name') == 'client_id')
                {
                   error.insertAfter(".client_id-error");
                }
                else if (element.attr('name') == 'client_secret')
                {
                   error.insertAfter(".client_secret-error");
                }
                else if (element.attr('name') == 'refresh_token')
                {
                   error.insertAfter(".refresh_token-error");
                }
                else if (element.attr('name') == 'SellerId')
                {
                   error.insertAfter(".SellerId-error");
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