<div id="backtotop">
    <a href="#"></a>
</div>

<script src="<?php echo FRONT_ASSETS;?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo FRONT_ASSETS;?>js/bootstrap.min.js"></script>
<script src="<?php echo FRONT_ASSETS;?>js/jquery.mmenu.js"></script>
<script src="<?php echo FRONT_ASSETS;?>js/custom.js"></script>

<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/jquery.themepunch.revolution.min.js"></script>

<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="<?php echo FRONT_ASSETS;?>revolution/js/extensions/revolution.extension.video.min.js"></script>

<script src="<?php echo COMMON;?>jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo COMMON;?>bootstrap-notify.js" type="text/javascript"></script>
<script>
    var baseURL = '<?php echo base_url(); ?>';

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function checkOnlyDigits(e) 
    {
        e = e ? e : window.event;
        var charCode = e.which ? e.which : e.keyCode;
        if (charCode < 48 || charCode > 57) {
            //alert('OOPs! Only digits allowed.');
            return false;
        }
    }

    $(document).ready(function(){
        setTimeout(function(){
            <?php 
            $success = $this->session->flashdata('success');
            if(isset($success))
            {
            ?>
                // alert('hello')
                $.notify({message: '<?php echo $success; ?>'},{ type: 'success'});
            <?php 
            } 

            $error = $this->session->flashdata('error');
            if(isset($error))
            {
            ?>
                $.notify({message: '<?php echo $error; ?>'},{ type: 'danger'});
            <?php 
            } 
            ?>
        },1000);
    });

    $(document).ready(function(){
        $("#myContactForm").validate({
            ignore: [],
            errorClass: 'text-danger',
            rules: {
                name:{required : true},
                email:{required : true,email:true},
                phone:{required : true,number:true},
                subject:{required : true},
                message:{required : true},
            },
            messages: {
                name:{required:"Please enter name."},
                email:{required:"Please enter email.",email:"Please enter valid email address."},
                phone:{required:"Please enter phone number.",number:"Please enter valid phone number."},
                subject:{required:"Please enter subject."},
                message:{required:"Please enter message."},
            }, 
        });

        $("#contactus-btn").click(function(e){
            if($("#myContactForm").valid())
            {
                e.preventDefault();
                
                var form = $("#myContactForm")[0];
                var url = $("#myContactForm").attr('action');
                var formData = new FormData(form);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // serializes the form's elements.
                    beforeSend: function()
                    {
                        $(".loading").show();
                    },
                    success: function(data)
                    {
                        if(data=='1')
                        {
                            window.location = '<?php echo APP_URL; ?>';
                        }
                        else
                        {
                            $.notify({message: data},{ type: 'danger'});
                            $(".loading").hide();
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
    });
</script>