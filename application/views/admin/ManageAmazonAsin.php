<link href="<?php echo BACKEND; ?>assets/css/datepicker.css" rel="stylesheet" />
<div class="page-header">
    <h2 class="header-title">Sales By Asin <span class="top_total_orders_count">(0)</span></h2>
</div>
<div class="card">
    <div class="card-body">
        <?php
$success = $this->session->flashdata('success');
if ($success) {?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php }?>
        <?php $error = $this->session->flashdata('error');
if ($error) {?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php }?>
        <form action="javascript:void(0);" method="post" name="extrasearchForm" id="extrasearchForm">
            <div class="form-row">
                <div class="form-group col-xl-2 col-lg-4 col-md-4">
                    <label class="font-weight-semibold">Fulfilled By</label>
                    <select class="form-control" id="OrdersType" name="OrdersType">
                        <option value="MFN" <?php echo isset($search['OrdersType']) && $search['OrdersType'] == "MFN" ? "Selected" : ""; ?>>Merchant</option>
                        <option value="FBAOrders" <?php echo isset($search['OrdersType']) && $search['OrdersType'] == "FBAOrders" ? "Selected" : ""; ?>>Amazon</option>
                    </select>
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-4">
                    <label class="font-weight-semibold">Asin</label>
                    <input type="text" class="form-control" name="SearchTerm" id="SearchTerm" placeholder="ASIN NO." value="<?php echo isset($search['SearchTerm']) ? $search['SearchTerm'] : ""; ?>"/>
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-4">
                    <label class="font-weight-semibold">Start 'Purchase Date'</label>
                    <input type="text" id="StartDate" name="StartDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem"/>
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-4">
                    <label class="font-weight-semibold">End 'Purchase Date'</label>
                    <input type="text" id="EndDate" name="EndDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-1 col-lg-2 col-md-2">
                    <label class="font-weight-semibold">Show</label>
                    <select class="form-control" id="perpage" name="perpage">
                        <option value="10" <?php echo isset($search['perpage']) && $search['perpage'] == 10 ? "Selected" : ""; ?>>10</option>
                        <option value="20" <?php echo isset($search['perpage']) && $search['perpage'] == 20 ? "Selected" : ""; ?>>20</option>
                        <option value="30" <?php echo isset($search['perpage']) && $search['perpage'] == 30 ? "Selected" : ""; ?>>30</option>
                        <option value="40" <?php echo isset($search['perpage']) && $search['perpage'] == 40 ? "Selected" : ""; ?>>40</option>
                        <option value="50" <?php echo isset($search['perpage']) && $search['perpage'] == 50 ? "Selected" : ""; ?>>50</option>
                        <option value="100" <?php echo isset($search['perpage']) && $search['perpage'] == 500 ? "Selected" : ""; ?>>100</option>
                    </select>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6" style="margin-top: 28px;">
                    <div class="form-row align-items-center">
                        <button class="btn btn-primary mr-2" onclick="searchFilter()">Search</button>
                        <a href="javascript:void(0);" class="mr-2" id="filter_refresh" data-url="<?=ADMIN_LINK;?>manage-amazon-order"><i class="far fa-sync-alt mr-2"></i> Refresh</a>
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item exportPdf" href="javascript:void(0);"><i class="fal fa-file-pdf red-icon mr-1"></i> Export PDF</a>
                            <a class="dropdown-item exportExcel" href="javascript:void(0);"><i class="far fa-file-excel green-icon mr-1"></i> Export Excel</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="inner_loader text-center" style="display: none;">
    <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
    <span class="sr-only">Loading...</span>
</div>

<div id="resultList">

</div>

<script src="<?php echo BACKEND; ?>assets/js/bootstrap-datepicker.js"></script>
<script>
    $(".datepicker").datepicker({
        autoclose: true,
        todayHighlight: true
    }).datepicker('update', new Date());

    <?php if (isset($search['StartDate'])) {?>
        $("#StartDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['StartDate']; ?>");
    <?php }?>

    <?php if (isset($search['EndDate'])) {?>
        $("#EndDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['EndDate']; ?>");
    <?php }?>

    $('#filter_refresh').click(function() {
        //document.getElementById("").reset();
        resetForm($("#extrasearchForm"));
        searchFilter();
    });
    
    $(document).on("click",".exportPdf",function(e){
        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK;?>manage-amazon-asin/export/pdf");
        $('#extrasearchForm').attr('target', "_blank");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });

    $(document).on("click",".exportExcel",function(e){

        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK;?>manage-amazon-asin/export/excel");
        $('#extrasearchForm').attr('target', "_blank");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });

    var counter = 0;
    searchFilter();
    function searchFilter(page_num)
    {
        $('#extrasearchForm').attr('target', "");
        page_num = page_num?page_num:0;
        $(".inner_loader").show();
        $.ajax({
            type : 'POST',
            url : '<?php echo ADMIN_LINK ?>AmazonOrderController/ajaxPaginationasin/'+page_num,
            data:  $('#extrasearchForm').serialize() + '&page='+page_num,
            beforeSend: function () {
                if(counter!=0)
                {
                    //$(".inner_loader").show();
                }
            },
            complete: function () {
                if(counter!=0)
                {
                    //$(".inner_loader").hide();
                }
                counter++;
            },
            success:function(html)
            {
                $('#resultList').html(html);
                $(".inner_loader").hide();
                $('#datatable-scroller').DataTable({
                                                searching: false,
                                                paging: false,
                                                info: false
                                            });

            }
        });
    }

    function resetForm($form) {
        $form.find('input:text, input:password, input:file, select, textarea').val('');
        $form.find('input:radio, input:checkbox').removeAttr('checked').removeAttr('selected');
        $form.find('select').prop('selectedIndex',0);
        $("#StartDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', new Date());
        $("#EndDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', new Date());
    }
</script>

