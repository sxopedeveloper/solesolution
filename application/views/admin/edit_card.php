<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center block-title">
                <?php $stores_data =  $this->crud->get_all_with_where('store','name','asc',array('status'=>'Y','isDelete'=>0,'id'=>$store_id)); 
                    if(!empty($stores_data)){ ?>
                        <h4>Edit Cards (<?php echo $stores_data[0]->name; ?>)</h4>
                    <?php }else{ ?>
                        <h4>Edit Cards</h4>
                    <?php } ?>
                </div>
                <form id="MyForm" name="MyForm" action="<?php echo ADMIN_LINK; ?>manage-card/update/<?= $store_id ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" id="card_count" value="<?php echo !empty($card_data) ?count($card_data) : 1; ?>">
                    <div id="card_res">
                        <?php if(!empty($card_data)){ ?>
                            <?php $i=1; foreach($card_data as $card){ ?>
                            <div class="form-row" id="card_<?php echo $i; ?>">
                                <hr>
                                <div class="form-row w-100">
                                    <div class="form-group col-md-5">
                                        <label class="font-weight-semibold">Card Name</label>
                                        <input type="text" name="card_name[]" class="form-control" placeholder="Card Name" value="<?php echo $card->card_name; ?>" require>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label class="font-weight-semibold">Card Number</label>
                                        <input type="text" name="card_number[]" class="form-control" placeholder="Card Number" value="<?php echo $card->card_number; ?>" require>
                                    </div>
                                </div>
                                <div class="form-row w-100">

                                    <div class="form-group col-md-2">
                                        <label class="font-weight-semibold">Expiry month</label>
                                        <select class="form-control" id="card_expiry_month" name="card_expiry_month[]">
                                            <?php for($mm = 1 ; $mm <=12 ; $mm++) {?>
                                            <option value="<?php echo sprintf("%02d", $mm) ?>" <?php echo $card->card_expiry_month == sprintf("%02d", $mm) ? "selected" : ""; ?>><?php echo sprintf("%02d", $mm) ?></option>
                                            <?php  }?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="font-weight-semibold">Expiry year</label>
                                        <select class="form-control" id="card_expiry_year" name="card_expiry_year[]">
                                            <?php for($yy = date("y") ; $yy <= date("y")+50 ; $yy++) {?>
                                            <option value="<?php echo $yy ?>" <?php echo $card->card_expiry_year == $yy ? "selected" : ""; ?>><?php echo 2000+$yy ?></option>
                                            <?php  }?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="font-weight-semibold">CVV</label>
                                        <input type="number" name="card_cvv[]" class="form-control" placeholder="CVV" value="<?php echo $card->card_cvv; ?>" require>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="font-weight-semibold">Card Limit</label>
                                        <input type="text" name="card_limit[]" class="form-control" placeholder="Card Limit" value="<?php echo $card->card_limit; ?>" require>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <?php if($i == 1){ ?>
                                            <button type="button" class="btn btn-primary mt-4" id="add_more_card"><i class="far fa-plus"></i></button>
                                        <?php }else{ ?>
                                            <button type="button" data-value="<?php echo $card->id; ?>" data-id="<?php echo $i; ?>" class="btn btn-danger mt-4" id="remove_card"><i class="far fa-minus"></i></button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        <?php $i++; } ?>
                        <?php }else{ ?>
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
                        <?php } ?>
                        
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
            'card_expiry_month[]':{allRequired:"Please enter expiry month."},
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
        var value = $(this).data('value');
        $.ajax(
          {
            url: '<?php echo ADMIN_LINK; ?>manage-card/delete/'+value,
            method:"GET",
            success: function (response)
            { 
                $("#card_"+id+"").remove();
            }
          });
            
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