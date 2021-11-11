<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo $pageTitle; ?></title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo base_url('public/front/images/logo/'.$site_favicon );?>">

    <!-- page css -->
    <!-- style css -->
    <!-- <link href="<?php echo BACKEND; ?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    <link href="<?php echo BACKEND; ?>assets/css/style.css" rel="stylesheet">
    <link href="<?php echo BACKEND; ?>assets/css/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="<?php echo COMMON;?>developer.css">
    <script src="<?php echo BACKEND; ?>assets/js/vendors.min.js"></script>
    <!-- Sweet-Alert  -->
    <link href="<?php echo COMMON; ?>bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">
    <script src="<?php echo COMMON; ?>bootstrap-sweetalert/sweet-alert.min.js"></script>

    <script src="<?php echo COMMON;?>jquery.validate.js" type="text/javascript"></script>
    <script src="<?php echo COMMON;?>bootstrap-notify.js" type="text/javascript"></script>
    <script src="<?php echo COMMON;?>custom.js" type="text/javascript"></script>
    <script type="text/javascript">
        var baseURL = '<?php echo base_url();?>';
    </script>
</head>
<body>
    <div class="app">
        <div class="layout">
            <!-- Header START -->
            <?php echo $topbar; ?>
            <!-- Header END -->

            <div class="page-container">
                    <!-- Content Wrapper START -->
                    <div class="main-content">
                        <?php echo $content_body ?>
                    </div>
                    <?php echo  $footer; ?>
            </div>
        </div>
    </div>
    <!-- Search Start-->
    <div class="modal modal-left fade search" id="search-drawer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between align-items-center">
                    <h5 class="modal-title">Search</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body scrollable">
                    <div class="input-affix">
                        <i class="prefix-icon anticon anticon-search"></i>
                        <input type="text" class="form-control" placeholder="Search">
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <!-- Search End-->
    
    <!--  add product modal start -->
    <div class="modal fade add-product-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Upload Product CSV</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form role="form" id="form-addNewProduct" name="form-addNewProduct" method="post" role="form" enctype="multipart/form-data" action="javascript:void(0);">
                    <div class="modal-body">
                         <input type="file" name="productfile" id="productfile">

                        <div class="dis_product_csv_details" style="display: none;">
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">brand</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="brand" id="brand" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">sku</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="sku" id="sku" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">product-id</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="product-id" id="product-id" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">product-id-type</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="product-id-type" id="product-id-type" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">price</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="price" id="price" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">minimum-seller-allowed-price</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="minimum-seller-allowed-price" id="minimum-seller-allowed-price" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">maximum-seller-allowed-price</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="maximum-seller-allowed-price" id="maximum-seller-allowed-price" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item-condition</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item-condition" id="item-condition" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">quantity</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="quantity" id="quantity" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">add-delete</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="add-delete" id="add-delete" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">will-ship-internationally"</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="will-ship-internationally" id="will-ship-internationally" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">expedited-shipping</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="expedited-shipping" id="expedited-shipping" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">standard-plus</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="standard-plus" id="standard-plus" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item-note</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item-note" id="item-note" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">fulfillment-center-id</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="fulfillment-center-id" id="fulfillment-center-id" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">product-tax-code</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="product-tax-code" id="product-tax-code" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">handling-time</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="handling-time" id="handling-time" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">merchant_shipping_group_name</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="merchant_shipping_group_name" id="merchant_shipping_group_name" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">batteries_required</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="batteries_required" id="batteries_required" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">are_batteries_included</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="are_batteries_included" id="are_batteries_included" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">battery_cell_composition</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="battery_cell_composition" id="battery_cell_composition" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">battery_type</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="battery_type" id="battery_type" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">number_of_batteries</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="number_of_batteries" id="number_of_batteries" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">battery_weight</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="battery_weight" id="battery_weight" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">battery_weight_unit_of_measure</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="battery_weight_unit_of_measure" id="battery_weight_unit_of_measure" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">number_of_lithium_ion_cells</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="number_of_lithium_ion_cells" id="number_of_lithium_ion_cells" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">number_of_lithium_metal_cells</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="number_of_lithium_metal_cells" id="number_of_lithium_metal_cells" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">lithium_battery_packaging</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="lithium_battery_packaging" id="lithium_battery_packaging" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">lithium_battery_energy_content</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="lithium_battery_energy_content" id="lithium_battery_energy_content" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">lithium_battery_energy_content_unit_of_measure</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="lithium_battery_energy_content_unit_of_measure" id="lithium_battery_energy_content_unit_of_measure" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">lithium_battery_weight</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="lithium_battery_weight" id="lithium_battery_weight" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">lithium_battery_weight_unit_of_measure</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="lithium_battery_weight_unit_of_measure" id="lithium_battery_weight_unit_of_measure" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">supplier_declared_dg_hz_regulation1</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="supplier_declared_dg_hz_regulation1" id="supplier_declared_dg_hz_regulation1" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">supplier_declared_dg_hz_regulation2</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="supplier_declared_dg_hz_regulation2" id="supplier_declared_dg_hz_regulation2" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">supplier_declared_dg_hz_regulation3</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="supplier_declared_dg_hz_regulation3" id="supplier_declared_dg_hz_regulation3" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">supplier_declared_dg_hz_regulation4</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="supplier_declared_dg_hz_regulation4" id="supplier_declared_dg_hz_regulation4" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">supplier_declared_dg_hz_regulation5</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="supplier_declared_dg_hz_regulation5" id="supplier_declared_dg_hz_regulation5" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">hazmat_united_nations_regulatory_id</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="hazmat_united_nations_regulatory_id" id="hazmat_united_nations_regulatory_id" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">safety_data_sheet_url</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="safety_data_sheet_url" id="safety_data_sheet_url" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item_weight</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item_weight" id="item_weight" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item_weight_unit_of_measure</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item_weight_unit_of_measure" id="item_weight_unit_of_measure" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item_volume</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item_volume" id="item_volume" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">item_volume_unit_of_measure</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="item_volume_unit_of_measure" id="item_volume_unit_of_measure" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">flash_point</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="flash_point" id="flash_point" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">ghs_classification_class1</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="ghs_classification_class1" id="ghs_classification_class1" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">ghs_classification_class2</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="ghs_classification_class2" id="ghs_classification_class2" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">ghs_classification_class3</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="ghs_classification_class3" id="ghs_classification_class3" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_compliance_type</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_compliance_type" id="california_proposition_65_compliance_type" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_chemical_names1</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_chemical_names1" id="california_proposition_65_chemical_names1" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_chemical_names2</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_chemical_names2" id="california_proposition_65_chemical_names2" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_chemical_names3</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_chemical_names3" id="california_proposition_65_chemical_names3" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_chemical_names4</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_chemical_names4" id="california_proposition_65_chemical_names4" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row"> 
                                <div class="form-group col-md-6">
                                    <label class="font-weight-semibold">california_proposition_65_chemical_names5</label>
                                </div>
                                <div class="form-group col-md-6">
                                    <select name="california_proposition_65_chemical_names5" id="california_proposition_65_chemical_names5" class="form-control cus_dropdown_val">
                                        <option value="">Please select option</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="csv_process_step" id="csv_process_step" value="1">
                        <input type="hidden" name="uploaded_pro_csv_file" id="uploaded_pro_csv_file">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    <div class="modal fade add-product-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Upload Product CSV</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form method="post" action="<?php echo ADMIN_LINK; ?>ProductController/importcsv" enctype="multipart/form-data">
                    <div class="modal-body">
                         <input type="file" name="productfile" id="productfile">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    <div class="modal fade add-brand-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">Upload Brand CSV</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <form method="post" action="<?php echo ADMIN_LINK; ?>ProductController/importbrandcsv" enctype="multipart/form-data">
                    <div class="modal-body">
                         <input type="file" name="productfile" id="productfile">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 

    <div class="modal fade add-product-modal-response">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h4">New csv generated successfully</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="anticon anticon-close"></i>
                    </button>
                </div>
                <div class="modal-body dis_add_pro_modal_res">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> 
    <!--  add product modal end --> 
     <!-- Core Vendors JS -->
    <!-- <script src="<?php echo BACKEND; ?>assets/js/jquery.dataTables.min.js"></script> -->
    <!-- <script src="<?php echo BACKEND; ?>assets/js/dataTables.bootstrap.min.js"></script> -->
    <!-- <script src="<?php echo BACKEND; ?>assets/js/datatables.js"></script> -->
    <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BACKEND; ?>assets/js/Chart.min.js"></script>
    <!-- <script src="<?php echo BACKEND; ?>assets/js/dashboard-default.js"></script> -->
    <script src="<?php echo BACKEND; ?>assets/js/app.min.js"></script>
    <!-- <script src="assets/js/dashboard-e-commerce.js"></script> -->
    <script type="text/javascript">
        if (<?php echo $user_role ?> == 4 || <?php echo $user_role ?> == 5) {
            $(document).ready(function(){
                console.log('fireee');
                // setInterval(getOrders, 1000 * 60 * 3);
            });
        }

        function getOrders() {
            console.log('order cron fireee');
            $.ajax({
                url: '<?php echo ADMIN_LINK ?>AmazonOrderController/getOrderlist',
                dataType: "JSON",
                method:"POST",
                async: false,
                success: function (response)
                {
                    console.log(response.message);
                }
            });
        }
        
        $(document).on('click', '.read-notification', function() {
            var badge = $(this).find('.fa-circle');
            if (badge.length > 0) {
                $.ajax({
                    url: '<?php echo ADMIN_LINK ?>NotificationController/notificationRead',
                    dataType: "JSON",
                    method:"POST",
                    async: false,
                    success: function (response)
                    {
                        badge.hide();
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
        $('#form-addNewProduct').validate({ 
            rules:{
                "productfile" :{ required : true },
                "brand" :{ required : true }, 
                "sku" :{ required : true }, 
                "product-id" :{ required : true }, 
                "product-id-type" :{ required : true }, 
                "price" :{ required : true }, 
                "minimum-seller-allowed-price" :{ required : true }, 
                "maximum-seller-allowed-price" :{ required : true }, 
                "item-condition" :{ required : true }, 
                "quantity" :{ required : true }, 
                "add-delete" :{ required : true }, 
                "will-ship-internationally" :{ required : true }, 
                "expedited-shipping" :{ required : true }, 
                "standard-plus" :{ required : true }, 
                "item-note" :{ required : true }, 
                "fulfillment-center-id" :{ required : true }, 
                "product-tax-code" :{ required : true }, 
                "handling-time" :{ required : true }, 
                "merchant_shipping_group_name" :{ required : true }, 
                "batteries_required" :{ required : true }, 
                "are_batteries_included" :{ required : true }, 
                "battery_cell_composition" :{ required : true }, 
                "battery_type" :{ required : true }, 
                "number_of_batteries" :{ required : true }, 
                "battery_weight" :{ required : true }, 
                "battery_weight_unit_of_measure" :{ required : true }, 
                "number_of_lithium_ion_cells" :{ required : true }, 
                "number_of_lithium_metal_cells" :{ required : true }, 
                "lithium_battery_packaging" :{ required : true }, 
                "lithium_battery_energy_content" :{ required : true }, 
                "lithium_battery_energy_content_unit_of_measure" :{ required : true }, 
                "lithium_battery_weight" :{ required : true }, 
                "lithium_battery_weight_unit_of_measure" :{ required : true }, 
                "supplier_declared_dg_hz_regulation1" :{ required : true }, 
                "supplier_declared_dg_hz_regulation2" :{ required : true }, 
                "supplier_declared_dg_hz_regulation3" :{ required : true }, 
                "supplier_declared_dg_hz_regulation4" :{ required : true }, 
                "supplier_declared_dg_hz_regulation5" :{ required : true }, 
                "hazmat_united_nations_regulatory_id" :{ required : true }, 
                "safety_data_sheet_url" :{ required : true }, 
                "item_weight" :{ required : true }, 
                "item_weight_unit_of_measure" :{ required : true }, 
                "item_volume" :{ required : true }, 
                "item_volume_unit_of_measure" :{ required : true }, 
                "flash_point" :{ required : true }, 
                "ghs_classification_class1" :{ required : true }, 
                "ghs_classification_class2" :{ required : true }, 
                "ghs_classification_class3" :{ required : true }, 
                "california_proposition_65_compliance_type" :{ required : true }, 
                "california_proposition_65_chemical_names1" :{ required : true }, 
                "california_proposition_65_chemical_names2" :{ required : true }, 
                "california_proposition_65_chemical_names3" :{ required : true }, 
                "california_proposition_65_chemical_names4" :{ required : true }, 
                "california_proposition_65_chemical_names5" :{ required : true },
            },
            messages:{
                "productfile" :{ required : "File is required" },
                "brand" : {required : "Please select brand"},
                "sku" : {required : "Please select sku"},
                "product-id" : {required : "Please select product-id"},
                "product-id-type" : {required : "Please select product-id-type"},
                "price" : {required : "Please select price"},
                "minimum-seller-allowed-price" : {required : "Please select minimum-seller-allowed-price"},
                "maximum-seller-allowed-price" : {required : "Please select maximum-seller-allowed-price"},
                "item-condition" : {required : "Please select item-condition"}, 
                "quantity"  : {required : "Please select quantity"},
                "add-delete" : {required : "Please select add-delete"}, 
                "will-ship-internationally" : { required : "Please select will-ship-internationally"}, 
                "expedited-shipping"  : {required : "Please select expedited-shipping"},
                "standard-plus"  : {required : "Please select standard-plus"},
                "item-note"  : {required : "Please select item-note"},
                "fulfillment-center-id" : {required : "Please select fulfillment-center-id"} ,
                "product-tax-code" : {required : "Please select product-tax-code"},
                "handling-time"  : {required : "Please select handling-time"},
                "merchant_shipping_group_name" : { required : "Please select merchant_shipping_group_name"}, 
                "batteries_required" : { required : "Please select batteries_required"}, 
                "are_batteries_included" : { required : "Please select are_batteries_included"}, 
                "battery_cell_composition" : { required : "Please select battery_cell_composition"}, 
                "battery_type" : { required : "Please select battery_type"}, 
                "number_of_batteries" : { required : "Please select number_of_batteries"}, 
                "battery_weight" : { required : "Please select battery_weight"}, 
                "battery_weight_unit_of_measure" : { required : "Please select battery_weight_unit_of_measure"}, 
                "number_of_lithium_ion_cells" : { required : "Please select number_of_lithium_ion_cells"}, 
                "number_of_lithium_metal_cells" : { required : "Please select number_of_lithium_metal_cells"}, 
                "lithium_battery_packaging" : { required : "Please select lithium_battery_packaging"}, 
                "lithium_battery_energy_content" : { required : "Please select lithium_battery_energy_content"}, 
                "lithium_battery_energy_content_unit_of_measure" : { required : "Please select lithium_battery_energy_content_unit_of_measure"}, 
                "lithium_battery_weight" : { required : "Please select lithium_battery_weight"}, 
                "lithium_battery_weight_unit_of_measure" : { required : "Please select lithium_battery_weight_unit_of_measure"}, 
                "supplier_declared_dg_hz_regulation1" : { required : "Please select supplier_declared_dg_hz_regulation1"}, 
                "supplier_declared_dg_hz_regulation2" : { required : "Please select supplier_declared_dg_hz_regulation2"}, 
                "supplier_declared_dg_hz_regulation3" : { required : "Please select supplier_declared_dg_hz_regulation3"}, 
                "supplier_declared_dg_hz_regulation4" : { required : "Please select supplier_declared_dg_hz_regulation4"}, 
                "supplier_declared_dg_hz_regulation5" : { required : "Please select supplier_declared_dg_hz_regulation5"}, 
                "hazmat_united_nations_regulatory_id" : { required : "Please select hazmat_united_nations_regulatory_id"}, 
                "safety_data_sheet_url" : { required : "Please select safety_data_sheet_url"}, 
                "item_weight" : { required : "Please select item_weight"}, 
                "item_weight_unit_of_measure" : { required : "Please select item_weight_unit_of_measure"}, 
                "item_volume" : { required : "Please select item_volume"}, 
                "item_volume_unit_of_measure" : { required : "Please select item_volume_unit_of_measure"}, 
                "flash_point" : { required : "Please select flash_point"}, 
                "ghs_classification_class1" : { required : "Please select ghs_classification_class1"}, 
                "ghs_classification_class2" : { required : "Please select ghs_classification_class2"}, 
                "ghs_classification_class3" : { required : "Please select ghs_classification_class3"}, 
                "california_proposition_65_compliance_type" : { required : "Please select california_proposition_65_compliance_type"}, 
                "california_proposition_65_chemical_names1" : { required : "Please select california_proposition_65_chemical_names1"}, 
                "california_proposition_65_chemical_names2" : { required : "Please select california_proposition_65_chemical_names2"}, 
                "california_proposition_65_chemical_names3" : { required : "Please select california_proposition_65_chemical_names3"}, 
                "california_proposition_65_chemical_names4" : { required : "Please select california_proposition_65_chemical_names4"}, 
                "california_proposition_65_chemical_names5" : { required : "Please select california_proposition_65_chemical_names5"}, 
            },
            submitHandler: function (form) 
            {
                var formData = new FormData(document.getElementById("form-addNewProduct"));
                
                $.ajax({
                    url: '<?php echo APP_URL; ?>admin/ProductController/readcsv',
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType:'json',
                    success: function (response) 
                    {
                        if(response.res == 0)
                        {
                            if(response.step_res == 2)
                            {
                                $(".add-product-modal").modal("hide");
                                //swal(response.res_msg);
                                $("#productfile").show();
                                $(".dis_product_csv_details").hide();
                                $("#csv_process_step").val("1");
                                $("#uploaded_pro_csv_file").val("");

                                $(".dis_add_pro_modal_res").html(response.res_msg);
                                $(".add-product-modal-response").modal("show");

                                $('#form-addNewProduct')[0].reset();
                            }
                            else
                            {
                                $("#productfile").hide();
                                $(".dis_product_csv_details").show();
                                $("#csv_process_step").val("2");
                                $("#uploaded_pro_csv_file").val(response.uploaded_pro_csv_file);

                                list = '<option value="">Select Option</option>';
                                $.each( response.header, function(index, item) {
                                    list += '<option value="'+item+'">'+item+'</option>';
                                });
                                $(".cus_dropdown_val").html(list);

                                var elements = document.getElementsByClassName("cus_dropdown_val");
                                for(var i=0; i<elements.length; i++) 
                                {
                                    var ele_id      = elements[i].id;
                                    var ele_name    = elements[i].name;
                                    $('#'+ele_id+' option[value='+ele_name+']').attr('selected','selected');
                                }
                            }
                        }
                        else
                        {
                            swal(response.res_msg);
                        }
                    }
                });
            }
        });

    </script>

    <script>
        $(".change_store").on("click",function() {
            var url = $(this).data('id');
            $.ajax({
                    url: url,
                    type: 'GET',
                    success: function (response) 
                    {
                        location.reload(); 
                    }
            });
        });
    </script>
</html>