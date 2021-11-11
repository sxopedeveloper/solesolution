<div class="card">
    <div class="card-body">
        <div class="">
            <!--<form action="<?php echo ADMIN_LINK; ?>import-anydesk-excel" enctype="multipart/form-data" id="import_form" method="post">-->
            <!--    <p>-->
            <!--        <label>-->
            <!--            Select Excel File-->
            <!--        </label>-->
            <!--        <input accept=".xls, .xlsx" id="file" name="file" required="" type="file"/>-->
            <!--    </p>-->
            <!--    <br/>-->
            <!--    <input class="btn btn-info" name="import" type="submit" value="Import"/>-->
            <!--</form>-->
            <br/>
            <div class="inner_loader text-center" style="display: none;">
                <i class="fa fa-spinner fa-spin fa-5x fa-fw"></i>
                <span class="sr-only">Loading...</span>
            </div>

            <div id="resultList">

            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function(){
        $(".inner_loader").show();
        $.ajax({
            type : 'POST',
            url : '<?php echo ADMIN_LINK ?>AmazonOrderController/ajaxAnyDeskPaginationData/',
            data:  $('#extrasearchForm').serialize(),
            success:function(html)
            {
                $('#resultList').html(html);
                $(".inner_loader").hide();
                $('#anyDeskData').DataTable({
                    responsive: true,
                    searching: true,
                    paging: true,
                    info: true,
                });
            }
        });
    });

</script>
