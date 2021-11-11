<div class="page-header">
    <h2 class="header-title">Products <span class="top_all_total_details">(0)</span></h2>
    <div class="page-link-header">
        <a href="#" class="items-block">
            <i class="far fa-upload"></i>
            <span class="m-l-5">Upload report from Amazon</span>
        </a>
        <a href="javascript:void(0);" onclick="$('.add-product-modal').modal('show');" class="btn btn-primary btn-tone">
            <i class="fas fa-plus-circle"></i>
            <span class="m-l-5">New Product</span>
        </a>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <?php 
        $success = $this->session->flashdata('success');
        if($success){?>
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php } ?>
        <?php $error = $this->session->flashdata('error');
        if($error){?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php } ?>

        <form action="javascript:void(0);" method="post" name="extrasearchForm" id="extrasearchForm">
            <div class="form-row"> 
                <div class="form-group col-lg-3 col-md-6">
                    <label class="font-weight-semibold"><i class="fas fa-exclamation-circle mr-2"></i>Search Term</label>
                    <input type="text" class="form-control" name="SearchTerm" id="SearchTerm" placeholder="Keyword..." />
                </div>
                <div class="form-group col-lg-3 col-md-6">
                    <label class="font-weight-semibold">Merchant</label>
                    <select class="form-control" name="merchant" id="merchant">
                        <option value="">Please select option</option>
                        <?php foreach ($merchant_lists as $merchant_list) {
                        ?>
                        <option value="<?php echo $merchant_list['brand']; ?>"><?php echo $merchant_list['brand']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-4">
                    <label class="font-weight-semibold">Listed by</label>
                    <select class="form-control" name="ListedBy" id="ListedBy">
                        <option value="">Choose One</option>
                        <?php foreach ($user_lists as $user_list) {
                        ?>
                        <option value="<?php echo $user_list->id; ?>"><?php echo $user_list->fname; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-4">
                    <label class="font-weight-semibold">Listing Status</label>
                    <select class="form-control" id="Status" name="Status">
                        <option>All Listings</option>
                        <option>Active Listings</option>
                        <option>Inactive Listings</option>
                    </select>
                </div>
                <div class="form-group col-lg-2 col-md-4">
                    <label class="font-weight-semibold"><i class="fas fa-exclamation-circle mr-2"></i>Show</label>
                    <select class="form-control" id="perpage" name="perpage">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="col-md-12">
                    <div class="d-flex align-items-center">
                        <div class="btn-control-form">
                            <!-- <button class="btn btn-secondary mr-2">Export AppEagle CSV</button>
                            <button class="btn btn-secondary mr-2">Advanced search</button> -->
                            <button class="btn btn-primary mr-2" onclick="searchFilter()">Search</button>
                            <a href="<?=ADMIN_LINK; ?>manage-product"><i class="far fa-sync-alt mr-2"></i> Refresh</a>
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

<div class="modal fade" id="productDetailsModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form id="form-updateOrder" name="form-updateOrder" method="post" role="form" enctype="multipart/form-data" action="<?php echo ADMIN_LINK ?>ProductController/store">
                <div class="modal-body">
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">Brand</label>
                            <input type="text" name="brand" id="brand" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">sku</label>
                            <input type="text" class="form-control" name="sku" id="sku" placeholder=""/>
                        </div>
                         <div class="form-group col-md-4">
                            <label class="font-weight-semibold">product-id</label>
                            <input type="text" class="form-control" name="product-id" id="product-id" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">product-id-type</label>
                            <input type="text" name="product-id-type" id="product-id-type" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">price</label>
                            <input type="text" class="form-control" name="price" id="price" placeholder=""/>
                        </div>
                         <div class="form-group col-md-4">
                            <label class="font-weight-semibold">minimum-seller-allowed-price</label>
                            <input type="text" class="form-control" name="minimum-seller-allowed-price" id="minimum-seller-allowed-price" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">maximum-seller-allowed-price</label>
                            <input type="text" name="maximum-seller-allowed-price" id="maximum-seller-allowed-price" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item-condition</label>
                            <input type="text" class="form-control" name="item-condition" id="item-condition" placeholder=""/>
                        </div>
                         <div class="form-group col-md-4">
                            <label class="font-weight-semibold">quantity</label>
                            <input type="text" class="form-control" name="quantity" id="quantity" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">add-delete</label>
                            <input type="text" name="add-delete" id="add-delete" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">will-ship-internationally</label>
                            <input type="text" class="form-control" name="will-ship-internationally" id="will-ship-internationally" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">expedited-shipping</label>
                            <input type="text" class="form-control" name="expedited-shipping" id="expedited-shipping" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">standard-plus</label>
                            <input type="text" name="standard-plus" id="standard-plus" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item-note</label>
                            <input type="text" class="form-control" name="item-note" id="item-note" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">fulfillment-center-id</label>
                            <input type="text" class="form-control" name="fulfillment-center-id" id="fulfillment-center-id" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">product-tax-code</label>
                            <input type="text" name="product-tax-code" id="product-tax-code" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">handling-time</label>
                            <input type="text" class="form-control" name="handling-time" id="handling-time" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">merchant_shipping_group_name</label>
                            <input type="text" class="form-control" name="merchant_shipping_group_name" id="merchant_shipping_group_name" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">batteries_required</label>
                            <input type="text" name="batteries_required" id="batteries_required" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">are_batteries_included</label>
                            <input type="text" class="form-control" name="are_batteries_included" id="are_batteries_included" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">battery_cell_composition</label>
                            <input type="text" class="form-control" name="battery_cell_composition" id="battery_cell_composition" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">battery_type</label>
                            <input type="text" name="battery_type" id="battery_type" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">number_of_batteries</label>
                            <input type="text" class="form-control" name="number_of_batteries" id="number_of_batteries" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">battery_weight</label>
                            <input type="text" class="form-control" name="battery_weight" id="battery_weight" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">number_of_lithium_ion_cells</label>
                            <input type="text" name="number_of_lithium_ion_cells" id="number_of_lithium_ion_cells" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">number_of_lithium_metal_cells</label>
                            <input type="text" class="form-control" name="number_of_lithium_metal_cells" id="number_of_lithium_metal_cells" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">lithium_battery_packaging</label>
                            <input type="text" class="form-control" name="lithium_battery_packaging" id="lithium_battery_packaging" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">lithium_battery_energy_content</label>
                            <input type="text" name="lithium_battery_energy_content" id="lithium_battery_energy_content" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">lithium_battery_weight</label>
                            <input type="text" class="form-control" name="lithium_battery_weight" id="lithium_battery_weight" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">hazmat_united_nations_regulatory_id</label>
                            <input type="text" class="form-control" name="hazmat_united_nations_regulatory_id" id="hazmat_united_nations_regulatory_id" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">safety_data_sheet_url</label>
                            <input type="text" name="safety_data_sheet_url" id="safety_data_sheet_url" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item_weight</label>
                            <input type="text" class="form-control" name="item_weight" id="item_weight" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item_volume</label>
                            <input type="text" class="form-control" name="item_volume" id="item_volume" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">flash_point</label>
                            <input type="text" name="flash_point" id="flash_point" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">ghs_classification_class1</label>
                            <input type="text" class="form-control" name="ghs_classification_class1" id="ghs_classification_class1" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">ghs_classification_class2</label>
                            <input type="text" class="form-control" name="ghs_classification_class2" id="ghs_classification_class2" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">ghs_classification_class3</label>
                            <input type="text" name="ghs_classification_class3" id="ghs_classification_class3" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item_weight_unit_of_measure</label>
                            <input type="text" class="form-control" name="item_weight_unit_of_measure" id="item_weight_unit_of_measure" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">item_volume_unit_of_measure</label>
                            <input type="text" class="form-control" name="item_volume_unit_of_measure" id="item_volume_unit_of_measure" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">lithium_battery_energy_content_unit_of_measure</label>
                            <input type="text" name="lithium_battery_energy_content_unit_of_measure" id="lithium_battery_energy_content_unit_of_measure" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">lithium_battery_weight_unit_of_measure</label>
                            <input type="text" class="form-control" name="lithium_battery_weight_unit_of_measure" id="lithium_battery_weight_unit_of_measure" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">supplier_declared_dg_hz_regulation1</label>
                            <input type="text" class="form-control" name="supplier_declared_dg_hz_regulation1" id="supplier_declared_dg_hz_regulation1" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">supplier_declared_dg_hz_regulation2</label>
                            <input type="text" name="supplier_declared_dg_hz_regulation2" id="supplier_declared_dg_hz_regulation2" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">supplier_declared_dg_hz_regulation3</label>
                            <input type="text" class="form-control" name="supplier_declared_dg_hz_regulation3" id="supplier_declared_dg_hz_regulation3" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">supplier_declared_dg_hz_regulation4</label>
                            <input type="text" class="form-control" name="supplier_declared_dg_hz_regulation4" id="supplier_declared_dg_hz_regulation4" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">supplier_declared_dg_hz_regulation5</label>
                            <input type="text" name="supplier_declared_dg_hz_regulation5" id="supplier_declared_dg_hz_regulation5" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">battery_weight_unit_of_measure</label>
                            <input type="text" class="form-control" name="battery_weight_unit_of_measure" id="battery_weight_unit_of_measure" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_compliance_type</label>
                            <input type="text" class="form-control" name="california_proposition_65_compliance_type" id="california_proposition_65_compliance_type" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_chemical_names1</label>
                            <input type="text" name="california_proposition_65_chemical_names1" id="california_proposition_65_chemical_names1" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_chemical_names2</label>
                            <input type="text" class="form-control" name="california_proposition_65_chemical_names2" id="california_proposition_65_chemical_names2" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_chemical_names3</label>
                            <input type="text" class="form-control" name="california_proposition_65_chemical_names3" id="california_proposition_65_chemical_names3" placeholder=""/>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_chemical_names4</label>
                            <input type="text" name="california_proposition_65_chemical_names4" id="california_proposition_65_chemical_names4" class="form-control" placeholder=""/>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-semibold">california_proposition_65_chemical_names5</label>
                            <input type="text" class="form-control" name="california_proposition_65_chemical_names5" id="california_proposition_65_chemical_names5" placeholder=""/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="type" name="type" value="add">
                    <input type="hidden" id="editid" name="editid">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    var counter = 0;
    searchFilter();
    function searchFilter(page_num) 
    {
        page_num = page_num?page_num:0;
        
        $.ajax({
            type : 'POST',
            url : '<?php echo ADMIN_LINK ?>ProductController/ajaxPaginationData/'+page_num,
            data:  $('#extrasearchForm').serialize() + '&page='+page_num,
            beforeSend: function () {
                if(counter!=0)
                {
                    $(".inner_loader").show();
                }
            },
            complete: function () {
                if(counter!=0)
                {
                    $(".inner_loader").hide();
                }
                counter++;
            },
            success:function(html) 
            {
                $('#resultList').html(html);
            }
        });
    }

    $(document).on("click",".rowEdit",function(){
          
        $('#productDetailsModal').modal('show'); 

        var id = $(this).attr("data-id");      
        var field = $(this).attr("data-i");             
        var table = $(this).attr("data-td"); 
         
        $.ajax(
        {
            url: '<?php echo APP_URL ?>CommonController/getEditRecord',
            dataType: "JSON",
            method:"POST",
            data: {
                "id": id,
                "td": table,
                "i": field,
            },
            success: function (response)
            { 
                $("#type").val('edit');
                $("#editid").val(response.id);
                $("#brand").val(response.brand);
                $("#sku").val(response.sku);
                $("#product-id").val(response['product-id']);
                $("#product-id-type").val(response['product-id-type']);
                $("#price").val(response['price']);
                $("#minimum-seller-allowed-price").val(response['minimum-seller-allowed-price']);
                $("#maximum-seller-allowed-price").val(response['maximum-seller-allowed-price']);
                $("#item-condition").val(response['item-condition']);
                $("#quantity").val(response['quantity']);
                $("#price").val(response['price']);
                $("#add-delete").val(response['add-delete']);
                $("#will-ship-internationally").val(response['will-ship-internationally']);
                $("#expedited-shipping").val(response['expedited-shipping']);
                $("#standard-plus").val(response['standard-plus']);
                $("#item-note").val(response['item-note']);
                $("#fulfillment-center-id").val(response['fulfillment-center-id']);
                $("#product-tax-code").val(response['product-tax-code']);
                $("#handling-time").val(response['handling-time']);
                $("#merchant_shipping_group_name").val(response['merchant_shipping_group_name']);
                $("#batteries_required").val(response['batteries_required']);
                $("#are_batteries_included").val(response['are_batteries_included']);
                $("#battery_cell_composition").val(response['battery_cell_composition']);
                $("#battery_type").val(response['battery_type']);
                $("#number_of_batteries").val(response['number_of_batteries']);
                $("#battery_weight").val(response['battery_weight']);
                $("#number_of_lithium_ion_cells").val(response['number_of_lithium_ion_cells']);
                $("#number_of_lithium_metal_cells").val(response['number_of_lithium_metal_cells']);
                $("#lithium_battery_packaging").val(response['lithium_battery_packaging']);
                $("#lithium_battery_energy_content").val(response['lithium_battery_energy_content']);
                $("#lithium_battery_weight").val(response['lithium_battery_weight']);
                $("#hazmat_united_nations_regulatory_id").val(response['hazmat_united_nations_regulatory_id']);
                $("#safety_data_sheet_url").val(response['safety_data_sheet_url']);
                $("#item_weight").val(response['item_weight']);
                $("#item_volume").val(response['item_volume']);
                $("#flash_point").val(response['flash_point']);
                $("#ghs_classification_class1").val(response['ghs_classification_class1']);
                $("#ghs_classification_class2").val(response['ghs_classification_class2']);
                $("#ghs_classification_class3").val(response['ghs_classification_class3']);
                $("#item_weight_unit_of_measure").val(response['item_weight_unit_of_measure']);
                $("#item_volume_unit_of_measure").val(response['item_volume_unit_of_measure']);
                $("#lithium_battery_energy_content_unit_of_measure").val(response['lithium_battery_energy_content_unit_of_measure']);
                $("#lithium_battery_weight_unit_of_measure").val(response['lithium_battery_weight_unit_of_measure']);
                $("#supplier_declared_dg_hz_regulation1").val(response['supplier_declared_dg_hz_regulation1']);
                $("#supplier_declared_dg_hz_regulation2").val(response['supplier_declared_dg_hz_regulation2']);
                $("#supplier_declared_dg_hz_regulation3").val(response['supplier_declared_dg_hz_regulation3']);
                $("#supplier_declared_dg_hz_regulation4").val(response['supplier_declared_dg_hz_regulation4']);
                $("#supplier_declared_dg_hz_regulation5").val(response['supplier_declared_dg_hz_regulation5']);
                $("#battery_weight_unit_of_measure").val(response['battery_weight_unit_of_measure']);
                $("#california_proposition_65_compliance_type").val(response['california_proposition_65_compliance_type']);
                $("#california_proposition_65_chemical_names1").val(response['california_proposition_65_chemical_names1']);
                $("#california_proposition_65_chemical_names2").val(response['california_proposition_65_chemical_names2']);
                $("#california_proposition_65_chemical_names3").val(response['california_proposition_65_chemical_names3']);
                $("#california_proposition_65_chemical_names4").val(response['california_proposition_65_chemical_names4']);
                $("#california_proposition_65_chemical_names5").val(response['california_proposition_65_chemical_names5']);
            }
        });
    });
</script>