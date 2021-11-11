function isConfirm(){
    var c = confirm("Are you sure to delete?");
    if(!c) { return false; }
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

$(document).ready(function () {
    $("#msg").hide();

    $(document).on('change','.changeStatusMe',function(){

        var mode = $(this).prop('checked');
        console.log(mode);
        //var status = $(this).attr("data-status");             
        var status = mode == true ? 'Y' : 'N';
        var id = $(this).attr("data-id");             
        var field = $(this).attr("data-i");             
        var table = $(this).attr("data-td");         
        $.ajax({
            url: baseURL + 'CommonController/changeStatus',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "status": status,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
                swal("Status successfully changed");

                $("#preloader-ajax , #status").hide();
            }
        });

    });

    $(document).on('change','.changeStatus',function(){

        var mode = $(this).prop('checked');
        console.log(mode);
        //var status = $(this).attr("data-status");             
        var status = mode == true ? 'Y' : 'N';
        var id = $(this).attr("data-id");             
        var field = $(this).attr("data-i");             
        var table = $(this).attr("data-td");         
        $.ajax({
            url: '../CommonController/changeStatus',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "status": status,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
                swal("Status successfully changed");
                /*$("#msg").show();
                $("#msg").html('You have successfully status changed.');
                $("#msg").addClass('alert alert-success');*/

                $("#preloader-ajax , #status").hide();
                //$('#posts').DataTable().ajax.reload();
            }
        });

    });



    $(document).on("click",".rowDelete",function(){
    
            var id = $(this).attr("data-id");             
            var field = $(this).attr("data-i");             
            var table = $(this).attr("data-td");  
            
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: true
            }, function (isConfirm) {
                
                if (isConfirm) {
                    
                    $.ajax({
                          url: baseURL+'CommonController/deleteData',
                          dataType: "JSON",
                          method:"POST",
                          data: {
                              "id": id,
                              "td": table,
                              "i": field,
                          },
                          success: function ()
                          {
                              $('#datatable-scroller').DataTable().ajax.reload();
                              swal("Deleted!", "Your data has been deleted.", "success");
                          }
                    });

                }
            });
                   
    }); 

    $('#state').on("change",function () {
        var id = $(this).find('option:selected').val();
        $.ajax({
            url: baseURL+'CommonController/getCityByState',
            type: "POST",
            data: "id="+id,
            success: function (data) {
                data = JSON.parse(data);
                var list = '<option value="">No city found</option>';
                if( data != 'blank' )
                {
                    list = '<option value="">Select City</option>';
                    $.each( data, function(index, item) {
                        list += '<option value="'+item.id+'">'+item.name+'</option>';
                    });
                }
                $("#city").html(list);
            },
        });
    }); 

    $( document ).ajaxStart(function() {
        $("#preloader , #status").show();
    });
    $( document ).ajaxComplete(function() {
        $("#preloader , #status").hide();
    });
     
    $(".close_model").click(function() {
        $("form").validate().resetForm();
    });
  
});
