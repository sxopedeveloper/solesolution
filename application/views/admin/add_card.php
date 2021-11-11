<link href="<?php echo BACKEND; ?>assets/css/datepicker.css" rel="stylesheet" />
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center block-title">
                    <h4>Add Card</h4>
                </div>
                <form id="MyForm" name="MyForm" action="<?php echo ADMIN_LINK; ?>card-store" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="type" id="type" value="add">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Select store</label>
                            <select name="store" id="store" class="form-control">
                                <option value="">Select Store</option>
                            <?php
                            $user_data = $this->crud->get_row_by_id('tbl_users',' id = '.$vendorId.'  ');
                            $stores_data = "";
                            if($user_data['roleId'] == 1){
                                $stores_data =  $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete'=>0));
                                
                            }else{
                                $stores_data =  $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete'=>0,'userId'=>$vendorId));
                            }
                            if(!empty($stores_data))
                            { 
                                foreach($stores_data as $stores)
                                { ?>
                                    <option value="<?= $stores->id ?>"><?= $stores->name ?></option>
                                <?php 
                                } 
                            }
                            ?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="card_count" value="1">
                    <div id="card_res" style="display:none;">
                        <div class="form-row" id="card_1">
                            <hr>
                            <div class="form-row w-100">
                                <div class="form-group col-md-5">
                                    <label class="font-weight-semibold">Card Name</label>
                                    <input type="text" name="card_name[]" class="form-control" placeholder="Card Name" value="" require>
                                </div>
                                <div class="form-group col-md-5">
                                    <label class="font-weight-semibold">Card Number</label>
                                    <input type="text" name="card_number[]" class="form-control" placeholder="Card Number" value="" require>
                                </div>
                            </div>
                            <div class="form-row w-100">
                                <div class="form-group col-md-2">
                                    <label class="font-weight-semibold">Expiry month</label>
                                    <select class="form-control" id="card_expiry_month" name="card_expiry_month[]">
                                        <?php for($mm = 1 ; $mm <=12 ; $mm++) {?>
                                        <option value="<?php echo sprintf("%02d", $mm) ?>" ><?php echo sprintf("%02d", $mm) ?></option>
                                        <?php  }?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="font-weight-semibold">Expiry year</label>
                                    <select class="form-control" id="card_expiry_year" name="card_expiry_year[]">
                                        <?php for($yy = date("y") ; $yy <= date("y")+50 ; $yy++) {?>
                                        <option value="<?php echo $yy ?>" ><?php echo 2000+$yy ?></option>
                                        <?php  }?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="font-weight-semibold">CVV</label>
                                    <input type="number" name="card_cvv[]" class="form-control" placeholder="CVV" value="" require>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="font-weight-semibold">Card Limit</label>
                                    <input type="text" name="card_limit[]" class="form-control" placeholder="Card Limit" value="" require>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="button" class="btn btn-primary mt-4" id="add_more_card"><i class="far fa-plus"></i></button>
                                </div>
                            </div>
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

jQuery.validator.addMethod("allRequired", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    return  $('input[name="'+name+'"]').map(function(i,obj){return $(obj).val();}).get().every(function(v){ return v; });
});

jQuery.validator.addMethod("allcard", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    var retrn = true;
    $('input[name="'+name+'"]').each(function( index ) {
        var value = $( this ).val();
        if(/^\d+$/.test(value) && value.length <= 16){
            retrn = true;
        }else{
            retrn = false;
        }  
    });
    return retrn;
});

jQuery.validator.addMethod("allcvv", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    var retrn = true;
    $('input[name="'+name+'"]').each(function( index ) {
        var value = $( this ).val();
        if(/^\d+$/.test(value) && value.length >= 3){
            retrn = true;
        }else{
            retrn = false;
        }  
    });
    return retrn;
});

jQuery.validator.addMethod("alllimit", function(value, elem){
    // Use the name to get all the inputs and verify them
    var name = elem.name;
    var retrn = true;
    $('input[name="'+name+'"]').each(function( index ) {
        var value = $( this ).val();
        if(/^\d+$/.test(value)){
            retrn = true;
        }else{
            retrn = false;
        }  
    });
    return retrn;
});



    $('#MyForm').validate({
        //ignore: [],
        rules: {              
            'store':{required : true},
            'card_name[]':{allRequired : true},
            'card_number[]':{allRequired : true,allcard : true},
            'card_expiry_month[]' : {allRequired : true},
            'card_expiry_year[]' : {allRequired : true},
            'card_cvv[]' : {allRequired : true,allcvv : true},
            'card_limit[]':{allRequired : true,alllimit : true},
        },
        messages: {
            'store':{required:"Please select store."},
            'card_name[]':{allRequired:"Please enter card name."},
            'card_number[]':{allRequired:"Please enter card number.",allcard : "Please enter valid card number."},
            'card_expiry_month[]':{allRequired:"Please select expiry month."},
            'card_expiry_year[]':{allRequired:"Please enter expiry year."},
            'card_cvv[]':{allRequired:"Please enter CVV no.",allcvv : "Please enter valid cvv number."},
            'card_limit[]':{allRequired:"Please enter card limit.",alllimit : "Please enter valid limit number."},
        }, 
        errorPlacement: function(error, element) 
        {
            error.insertAfter(element); 
        }
     });

    $(document).on("click","#add_more_card",function() {
         var count = $("#card_count").val();
         count++;
        $("#card_res").append(`<div class="form-row" id="card_`+count+`">
                                    <hr>
                                    <div class="form-row w-100">
                                        <div class="form-group col-md-5">
                                            <label class="font-weight-semibold">Card Name</label>
                                            <input type="text" id="card_name`+count+`" name="card_name[]" class="form-control" placeholder="Card Name" value="" require>
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label class="font-weight-semibold">Card Number</label>
                                            <input type="text" id="card_number`+count+`" name="card_number[]" class="form-control" placeholder="Card Number" value="" require>
                                        </div>
                                    </div>
                                    <div class="form-row w-100">

                                        <div class="form-group col-md-2">
                                            <label class="font-weight-semibold">Expiry month</label>
                                            <select class="form-control" id="card_expiry_month`+count+`" name="card_expiry_month[]">
                                                <?php for($mm = 1 ; $mm <=12 ; $mm++) {?>
                                                <option value="<?php echo sprintf("%02d", $mm) ?>" ><?php echo sprintf("%02d", $mm) ?></option>
                                                <?php  }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="font-weight-semibold">Expiry year</label>
                                            <select class="form-control" id="card_expiry_year`+count+`" name="card_expiry_year[]">
                                                <?php for($yy = date("y") ; $yy <= date("y")+50 ; $yy++) {?>
                                                <option value="<?php echo $yy ?>" ><?php echo 2000+$yy ?></option>
                                                <?php  }?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="font-weight-semibold">CVV</label>
                                            <input type="number" id="card_cvv`+count+`" name="card_cvv[]" class="form-control" placeholder="CVV" value="" require>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="font-weight-semibold">Card Limit</label>
                                            <input type="text" id="card_limit`+count+`" name="card_limit[]" class="form-control" placeholder="Card Limit" value="" require>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <button type="button" data-id="`+count+`" class="btn btn-danger mt-4" id="remove_card"><i class="far fa-minus"></i></button>
                                        </div>
                                    </div>
                                </div>`);
            $("#card_count").val(count);
    });

    $(document).on("click","#remove_card",function() {
        var id = $(this).data('id');
        $("#card_"+id+"").remove();
    });

    $(document).on("change","#store",function() {
        var val = $(this).val();
        if(val != ""){
            $("#card_res").show();
        }else{
            $("#card_res").hide();
        }
    });
</script>