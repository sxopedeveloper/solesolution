<link href="<?php echo BACKEND; ?>assets/css/datepicker.css" rel="stylesheet" />

<div class="right-menu-sidebar">
	<div class="hideshow-column">
			<a href="javascript:void(0);">Columns</a>
		</div>
	<div class="menu-inner">
		<div class="title-block">
			<h2>Columns<span>Hide/Show Fields</h2>
		</div>
        <form action="javascript:void(0);" method="post" name="tabel_field" id="tabel_field">
            <div class="form-row">
                <div class="form-group col-md-12 ">
                    <div class="checkbox">
                        <input id="checkbox0" class="field_check" name="ASIN" type="checkbox" value="1" <?php echo $field_row->ASIN == 1 ? "checked" : ""; ?>>
                        <label for="checkbox0">ASIN NUMBER</label>
                    </div>
                </div>
                <div class="form-group col-md-12 ">
                    <div class="checkbox">
                        <input id="checkbox16" class="field_check" name="Store_name" type="checkbox" value="1" <?php echo $field_row->Store_name == 1 ? "checked" : ""; ?>>
                        <label for="checkbox16">STORE NAME</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox1" class="field_check" name="AmazonOrderId" type="checkbox" value="1" <?php echo $field_row->AmazonOrderId == 1 ? "checked" : ""; ?>>
                        <label for="checkbox1">ORDER ID</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox14" class="field_check" name="BuyerName" type="checkbox" value="1" <?php echo $field_row->BuyerName == 1 ? "checked" : ""; ?>>
                        <label for="checkbox14">Buyer Name</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox15" class="field_check" name="Note" type="checkbox" value="1" <?php echo $field_row->Note == 1 ? "checked" : ""; ?>>
                        <label for="checkbox15">Note</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox2" class="field_check" name="MerchantOrderID" type="checkbox" value="1" <?php echo $field_row->MerchantOrderID == 1 ? "checked" : ""; ?>>
                        <label for="checkbox2">SUPPLIER ORDER ID</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox3" class="field_check" name="Title" type="checkbox" value="1" <?php echo $field_row->Title == 1 ? "checked" : ""; ?>>
                        <label for="checkbox3">AMAZON TITLE</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox4" class="field_check" name="PurchaseDateNew" type="checkbox" value="1" <?php echo $field_row->PurchaseDateNew == 1 ? "checked" : ""; ?>>
                        <label for="checkbox4">PURCHASE DATE</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox5" class="field_check" name="Lastupdate" type="checkbox" value="1" <?php echo $field_row->Lastupdate == 1 ? "checked" : ""; ?>>
                        <label for="checkbox5">LAST UPDATED DATE</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox6" class="field_check" name="LastupdateBy" type="checkbox" value="1" <?php echo $field_row->LastupdateBy == 1 ? "checked" : ""; ?>>
                        <label for="checkbox6">LAST UPDATED BY</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox7" class="field_check" name="SellerSKU" type="checkbox" value="1" <?php echo $field_row->SellerSKU == 1 ? "checked" : ""; ?>>
                        <label for="checkbox7">SKU</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox8" class="field_check" name="ShipmentTrackingNumber" type="checkbox" value="1" <?php echo $field_row->ShipmentTrackingNumber == 1 ? "checked" : ""; ?>>
                        <label for="checkbox8">SHIPMENT TRACKING #</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox9" class="field_check" name="ShipmentTrackingStatus" type="checkbox" value="1" <?php echo $field_row->ShipmentTrackingStatus == 1 ? "checked" : ""; ?>>
                        <label for="checkbox9">SHIPMENT TRACKING STATUS</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox10" class="field_check" name="shipment_date" type="checkbox" value="1" <?php echo $field_row->shipment_date == 1 ? "checked" : ""; ?>>
                        <label for="checkbox10">SHIPMENT DATE</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox11" class="field_check" name="roi" type="checkbox" value="1" <?php echo $field_row->roi == 1 ? "checked" : ""; ?>>
                        <label for="checkbox11">NET ROI</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox12" class="field_check" name="OrderStatus" type="checkbox" value="1" <?php echo $field_row->OrderStatus == 1 ? "checked" : ""; ?>>
                        <label for="checkbox12">STATUS</label>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <div class="checkbox">
                        <input id="checkbox13" class="field_check" name="late_shipment" type="checkbox" value="1" <?php echo $field_row->late_shipment == 1 ? "checked" : ""; ?>>
                        <label for="checkbox13">LATE SHIPMENT</label>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>

<div class="page-header">
    <h2 class="header-title">Amazon Orders <span class="top_total_orders_count">(0)</span></h2>
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
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Fulfilled By</label>
                    <select class="form-control" id="OrdersType" name="OrdersType">
                        <option value="MFN" <?php echo isset($search['OrdersType']) && $search['OrdersType'] == "MFN" ? "Selected" : ""; ?>>Merchant</option>
                        <option value="FBAOrders" <?php echo isset($search['OrdersType']) && $search['OrdersType'] == "FBAOrders" ? "Selected" : ""; ?>>Amazon</option>
                    </select>
                </div>
                <!-- <div class="form-group col-md-1">
                    <label class="font-weight-semibold">Market Place</label>
                    <select class="form-control" id="MerketPlace" name="MerketPlace">
                        <option value="">Any</option>
                        <option value="UK">UK</option>
                        <option value="USA">USA</option>
                    </select>
                </div> -->
                <!-- <div class="form-group col-md-4">
                    <label class="font-weight-semibold">Merchant</label>
                    <select class="form-control" id="MerchantId" name="MerchantId">
                        <option value="">Any</option>
                        <option value="680">Walgreens</option>
                    </select>
                </div> -->
                 <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold"><i class="fas fa-exclamation-circle mr-2"></i> Search Term</label>
                    <input type="text" class="form-control" name="SearchTerm" id="SearchTerm" placeholder="Keyword..." value="<?php echo isset($search['SearchTerm']) ? $search['SearchTerm'] : ""; ?>"/>
                </div>
                <!-- <div class="form-group col-md-2">
                    <label class="font-weight-semibold">Note</label>
                    <input type="text" class="form-control" id="SearchNote" name="SearchNote" placeholder="Note (match exactly)" />
                </div> -->
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Start 'Purchase Date'</label>
                    <input type="text" id="StartDate" name="StartDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem"/>
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">End 'Purchase Date'</label>
                    <input type="text" id="EndDate" name="EndDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Order Status</label>
                    <select class="form-control" id="Status" name="Status">
                        <option value="">Any</option>
                        <option value="Pending" <?php echo isset($search['Status']) && $search['Status'] == "Pending" ? "Selected" : ""; ?>>Pending</option>
                        <option value="Ordered" <?php echo isset($search['Status']) && $search['Status'] == "Ordered" ? "Selected" : ""; ?>>Ordered</option>
                        <option value="OOS" <?php echo isset($search['Status']) && $search['Status'] == "OOS" ? "Selected" : ""; ?>>OOS</option>
                        <option value="Canceled" <?php echo isset($search['Status']) && $search['Status'] == "Canceled" ? "Selected" : ""; ?>>Cancelled</option>
                        <option value="Shipped" <?php echo isset($search['Status']) && $search['Status'] == "Shipped" ? "Selected" : ""; ?>>Shipped</option>
                        <!--<option value="Unshipped" <?php echo isset($search['Status']) && $search['Status'] == "Unshipped" ? "Selected" : ""; ?>>Unshipped</option>-->
                        <option value="State Restriction" <?php echo isset($search['Status']) && $search['Status'] == "State Restriction" ? "Selected" : ""; ?>>State Restriction</option>
                        <option value="Refund Requested" <?php echo isset($search['Status']) && $search['Status'] == "Refund Requested" ? "Selected" : ""; ?>>Return Requested</option>
                        <option value="Refund Completed" <?php echo isset($search['Status']) && $search['Status'] == "Refund Completed" ? "Selected" : ""; ?>>Refund Completed</option>
                    </select>
                </div>
                <!-- <div class="form-group col-md-4">
                    <label class="font-weight-semibold">Sub-Order</label>
                    <select class="form-control" id="OrderChildStatus" name="OrderChildStatus">
                        <option value=""> Any</option>
                    </select>
                </div> -->
                <!-- <div class="form-group col-md-4">
                    <label class="font-weight-semibold">Sourced By</label>
                    <select class="form-control" id="ListedBy" name="ListedBy">
                        <option value="">Choose One</option>
                        <option value="David Moffitt">David Moffitt</option>
                    </select>
                </div> -->
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Ordered By</label>
                    <select class="form-control" name="OrderedBy" id="OrderedBy">
                        <option value="">Choose One</option>
                        <?php foreach ($user_lists as $user_list) {
    ?>
                        <option value="<?php echo $user_list->id; ?>" <?php echo isset($search['OrderedBy']) && $search['OrderedBy'] == $user_list->id ? "Selected" : ""; ?>><?php echo $user_list->fname; ?></option>
                        <?php }?>
                    </select>
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Order Date</label>
                    <input type="text" id="OrderDate" name="OrderDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Start 'Shipped Date'</label>
                    <input type="text" id="ShippedDate" name="ShippedDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">End 'Shipped Date'</label>
                    <input type="text" id="end_ShippedDate" name="end_ShippedDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Start 'Delivery Date'</label>
                    <input type="text" id="DeliveryDate" name="DeliveryDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">End 'Delivery Date'</label>
                    <input type="text" id="end_DeliveryDate" name="end_DeliveryDate" class="form-control datepicker" placeholder="" style="padding: .55rem 1rem" />
                </div>
                <div class="form-group col-lg-1 col-lg-2 col-md-6">
                    <label class="font-weight-semibold"><i class="fas fa-exclamation-circle mr-2"></i> Show</label>
                    <select class="form-control" id="perpage" name="perpage">
                        <option value="10" <?php echo isset($search['perpage']) && $search['perpage'] == 10 ? "Selected" : ""; ?>>10</option>
                        <option value="20" <?php echo isset($search['perpage']) && $search['perpage'] == 20 ? "Selected" : ""; ?>>20</option>
                        <option value="30" <?php echo isset($search['perpage']) && $search['perpage'] == 30 ? "Selected" : ""; ?>>30</option>
                        <option value="40" <?php echo isset($search['perpage']) && $search['perpage'] == 40 ? "Selected" : ""; ?>>40</option>
                        <option value="50" <?php echo isset($search['perpage']) && $search['perpage'] == 50 ? "Selected" : ""; ?>>50</option>
                        <option value="100" <?php echo isset($search['perpage']) && $search['perpage'] == 500 ? "Selected" : ""; ?>>100</option>
                    </select>
                </div>
                
                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">Sort Column</label>
                    <select class="form-control" name="sortColumn" id="sortColumn">
                        <option value="">Choose One</option>
                        <option value="1" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 1 ? "Selected" : ""; ?>>ASIN NUMBER</option>
                        <option value="2" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 2 ? "Selected" : ""; ?>>Store Name</option>
                        <option value="3" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 3 ? "Selected" : ""; ?>>ORDER ID</option>
                        <option value="4" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 4 ? "Selected" : ""; ?>>Buyer Name</option>
                        <option value="5" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 5 ? "Selected" : ""; ?>>Note</option>
                        <option value="6" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 6 ? "Selected" : ""; ?>>SUPPLIER ORDER ID</option>
                        <!--<option value="7" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 7 ? "Selected" : ""; ?>>AMAZON TITLE</option>-->
                        <option value="8" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 8 ? "Selected" : ""; ?>>PURCHASE DATE</option>
                        <option value="9" <?php echo isset($search['sortColumn']) && $search['sortColumn'] == 9 ? "Selected" : ""; ?>>LAST UPDATED DATE</option>
                    </select>
                </div>

                <div class="form-group col-xl-2 col-lg-4 col-md-6">
                    <label class="font-weight-semibold">SortBy</label>
                    <select class="form-control" name="sortBy" id="sortBy">
                        <option value="">Choose One</option>
                        <option value="asc" <?php echo isset($search['sortBy']) && $search['sortBy'] == 'asc' ? "Selected" : ""; ?>>ASC</option>
                        <option value="desc" <?php echo isset($search['sortBy']) && $search['sortBy'] == 'desc' ? "Selected" : ""; ?>>DESC</option>
                    </select>
                </div>


                <div class="col-xl-4 col-lg-4 col-md-6 mobile-top-space" style="margin-top: 28px;">
                    <div class="form-row align-items-center">
                        <button class="btn btn-primary mr-2" onclick="searchFilter()">Search</button>

                        <div class="dropdown mr-4">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Export</button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item exportPdf" href="javascript:void(0);"><i class="fal fa-file-pdf red-icon mr-1"></i> Export PDF</a>
                                <a class="dropdown-item exportExcel" href="javascript:void(0);"><i class="far fa-file-excel green-icon mr-1"></i> Export Excel</a>
                            </div>
                        </div>

                        <a href="javascript:void(0);" id="filter_refresh" data-url="<?=ADMIN_LINK;?>manage-amazon-order"><i class="far fa-sync-alt mr-2"></i> Refresh</a>
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
<!-- <div class="card">
    <div class="card-body custom-data-table">

    </div>
</div> -->




<div class="modal fade" id="updateOrderModal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Update Amazon Order</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <form id="form-updateOrder" name="form-updateOrder" method="post" role="form" enctype="multipart/form-data" action="<?php echo ADMIN_LINK ?>AmazonOrderController/store">
                <div class="modal-body">
                    <div class="page-link-header pt-0 p-b-15">
                        <p class="items-block">
                            <span>Order</span>
                        </p>
                        <div id="asin_short" style="display:none;">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input type="number" name="from_amount" id="from_amount" class="form-control" placeholder="Min amount" maxlength="10">
                                    <label id="from_amount-error" class="error" style="display:none;">Please Min Amount</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="number" name="to_amount" id="to_amount" class="form-control" placeholder="Max amount" maxlength="10">
                                    <label id="to_amount-error" class="error" style="display:none;">Please Max Amount</label>
                                </div>
                                <div class="form-group col-md-4">
                                    <input type="hidden" name="notify_asin" id="notify_asin">
                                   <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#addpopUpmodal" type="button" id="notify_email"> Notify</button> -->

                                   <button class="btn btn-primary" type="button" id="notify_email"> Notify</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <fieldset>
                        <legend><h5 class="modal-title h6">Suppliers</h5></legend>
                        <div class="dis_details_from_asin"></div>
                    </fieldset>

                    <fieldset>
                        <legend><h5 class="modal-title h6">Order Update</h5></legend>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Purchase Cost</label>
                                <input type="text" name="PricePayed" id="PricePayed" class="form-control" placeholder=""/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Supplier Order ID</label>
                                <input type="text" class="form-control" name="MerchantOrderID" id="MerchantOrderID" placeholder=""/>
                            </div>
                             <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Last 4 digits of CC used</label>
                                <input type="text" class="form-control" name="LastFourDigitsofCCInUsed" id="LastFourDigitsofCCInUsed" placeholder=""/>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><h5 class="modal-title h6">SHIPMENT TRACKING</h5></legend>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Shipment Tracking # <i class="fas fa-exclamation-circle mr-2"></i></label>
                                <input type="text" class="form-control" name="ShipmentTrackingNumber" id="ShipmentTrackingNumber" placeholder="Separate numbers with semicolon"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Shipment Carrier</label>
                                <select class="form-control" name="ShipmentCarrierFormat" id="ShipmentCarrierFormat">
                                    <option value="">Select Carrier</option>
                                    <option value="Amazon">Amazon</option>
                                    <option value="UPS">UPS</option>
                                    <option value="USPS">USPS</option>
                                    <option value="Fedex">Fedex</option>
                                    <option value="OnTrac">OnTrac</option>
                                    <option value="Lasership">Lasership</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Return Tracking # <i class="fas fa-exclamation-circle mr-2"></i></label>
                                <input type="text" id="TrackingNumber" name="TrackingNumber" class="form-control" placeholder="Separate numbers with semicolon"/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Return Carrier</label>
                                <select class="form-control" id="CarrierFormat" name="CarrierFormat">
                                    <option value="">Select Carrier</option>
                                    <option value="Amazon">Amazon</option>
                                    <option value="UPS">UPS</option>
                                    <option value="USPS">USPS</option>
                                    <option value="Fedex">Fedex</option>
                                    <option value="OnTrac">OnTrac</option>
                                    <option value="Lasership">Lasership</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="shipped_by_div">
                                <label class="font-weight-semibold">Shipped By</label>
                                <input type="text" class="form-control" id="shipped_by" readonly/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Shipment Date</label>
                                <input type="text" class="form-control datepicker" name="shipment_date" id="shipment_date" style="padding: .55rem 1rem;" />
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><h5 class="modal-title h6">REFUND UPDATE</h5></legend>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">RMA #</label>
                                <input type="text" id="RMANumber" name="RMANumber" class="form-control" placeholder=""/>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Buyer Refund</label>
                                <input type="text" id="BuyerRefund" name="BuyerRefund" class="form-control" placeholder=""/>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Supplier Refunded</label>
                                <input type="text" id="SupplierRefunded" name="SupplierRefunded" class="form-control" placeholder=""/>
                            </div>

                            <div class="form-group col-md-4">
                                <label class="font-weight-semibold">Amazon Fee Kept</label>
                                <input type="text" id="AmazonFeeKept" name="AmazonFeeKept" class="form-control" placeholder=""/>
                            </div>

                            <div class="form-group col-md-4" id="reason_refund_div" style="display:none;">
                                <label class="font-weight-semibold">Refund Reason</label>
                                <select class="form-control" id="RefundReason" name="RefundReason">
                                    <option value="A2Z Claims">A2Z Claims</option>
                                    <option value="Charge Back">Charge Back</option>
                                    <option value="Returns">Returns</option>
                                    <option value="Address undeliverable">Address undeliverable</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend><h5 class="modal-title h6">STATUS UPDATE</h5></legend>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold"><!--Sourced By--> Fulfilled By <i class="fas fa-exclamation-circle mr-2"></i></label>
                                <select class="form-control" id="ListedBy" name="ListedBy">
                                    <option value="">Please choose option</option>
                                    <?php foreach ($user_lists1 as $data) {
    ?>
                                    <option value="<?php echo $data->id; ?>"><?php echo $data->fname . ' ' . $data->lname; ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold">Status</label>
                                <select class="form-control" id="OrderStatus" name="OrderStatus">
                                    <option value="">Any</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Ordered">Ordered</option>
                                    <!-- <option value="OOS">OOS</option> -->
                                    <option value="Canceled">Cancelled</option>
                                    <option value="Shipped">Shipped</option>
                                    <option value="Unshipped">Waiting</option>
                                    <option value="State Restriction">State Restriction</option>
                                    <option value="Refund Requested">Return Requested</option>
                                    <option value="Refund Completed">Refund Completed</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" id="reason_cancel_div" style="display:none;">
                                <label class="font-weight-semibold">Reason</label>
                                <select class="form-control" id="reason_cancel" name="reason_cancel">
                                    <option value="">Select Reason</option>
                                    <option value="Buyer Cancelled">Buyer Cancelled</option>
                                    <option value="Seller Cancelled">Seller Cancelled</option>
                                    <option value="State Restriction">State Restriction</option>
                                    <option value="Can't Confirm Address">Can't Confirm Address</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold">Sub-Order</label>
                                <select class="form-control" id="ModalOrderChildStatus" name="ModalOrderChildStatus">
                                    <option value="">Any</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="font-weight-semibold">Buyer Name</label>
                                <input type="text" class="form-control" id="BuyerName" name="BuyerName">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="font-weight-semibold">Note</label>
                                <textarea class="form-control" id="Note" name="Note" rows="5"></textarea>
                            </div>
                        </div>
                    </fieldset>


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

<div class="modal fade" id="addpopUpmodal" style="display: none; overflow: hidden auto;">
    <div class="modal-dialog">
        <div class="modal-content">
        <form action="javascript:void();" id="form-addNewRecord" name="form-addNewRecord" method="post" role="form" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Notify Email</h5>
                <button type="button" data-dismiss="modal" class="close">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <input type="hidden" id="n_email_count" value="1">
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-10 mb-0">
                        <label class="font-weight-semibold">Email</label>
                        <input type="text" name="notify_email[]" class="form-control notify_email" placeholder="Notify Email" required value="<?=$site_email;?>">
                        <label id="email-error" class="error" style="display:none">please enter your email</label>
                    </div>
                    <div class="form-group col-md-2 mb-0">
                        <label class="font-weight-semibold" style="visibility: hidden;">Action</label>
                        <button type="button" class="btn btn-primary" id="add_notify_email">
                            <i class="far fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div id="notify_email_div">

                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="max_amount" id="max_amount">
                <input type="hidden" name="min_amount" id="min_amount">
                <input type="hidden" name="notify_asin" id="notify_asin">
                <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('userId'); ?>">
                <input type="hidden" name="added_date" value="<?php echo date("Y-m-d h:i:s"); ?>">
                <input type="hidden" name="seller_id" id="seller_id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btnnotify">Submit</button>
            </div>
        </form>
        </div>
    </div>
</div>

<script src="<?php echo BACKEND; ?>assets/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    /*$(document).ready(function () {
        $('#datatable-scroller').DataTable({
            "serverSide": true,
            "ordering": true,
            "ajax": {
                "url": "<?php echo ADMIN_LINK ?>AmazonOrderController/ajax_datatable_amazon_order",
                "type": "POST"
            },
            "scroller": {
                "loadingIndicator": true
            },
            "columnDefs": [{"targets": 2, "orderable": false },]

        });
    });*/

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

    <?php if (isset($search['OrderDate'])) {?>
        $("#OrderDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['OrderDate']; ?>");
    <?php }?>
    <?php if (isset($search['ShippedDate'])) {?>
        $("#ShippedDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['ShippedDate']; ?>");
    <?php }?>
    <?php if (isset($search['end_ShippedDate'])) {?>
        $("#end_ShippedDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['end_ShippedDate']; ?>");
    <?php }?>
    <?php if (isset($search['DeliveryDate'])) {?>
        $("#DeliveryDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['DeliveryDate']; ?>");
    <?php }?>
    <?php if (isset($search['end_DeliveryDate'])) {?>
        $("#end_DeliveryDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "<?php echo $search['end_DeliveryDate']; ?>");
    <?php }?>


    $('#OrderDate').val('');
    $('#ShippedDate').val('');
    $('#end_ShippedDate').val('');
    $('#DeliveryDate').val('');
    $('#end_DeliveryDate').val('');

    var counter = 0;
    searchFilter();
    function searchFilter(page_num)
    {
        page_num = page_num?page_num:0;
        $(".inner_loader").show();
        $.ajax({
            type : 'POST',
            url : '<?php echo ADMIN_LINK ?>AmazonOrderController/ajaxPaginationData/'+page_num,
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

    $(document).on("click",".exportPdf",function(e){
        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK;?>manage-amazon-order/export/pdf");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });

    $(document).on("click",".exportExcel",function(e){

        $('#extrasearchForm').attr('action', "<?=ADMIN_LINK;?>manage-amazon-order/export/excel");
        $("#extrasearchForm").submit();
        $('#extrasearchForm').attr('action', "javascript:void(0);");
        e.preventDefault();
    });

    var seller_id;
    $(document).on("click",".rowEdit",function(){
        $("#asin_short").hide();
        $('#updateOrderModal').modal('show');
        $(".dis_details_from_asin").html("");
        var id = $(this).attr("data-id");
        var field = $(this).attr("data-i");
        var table = $(this).attr("data-td");
        var asin = $(this).attr("data-asin");

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
                $("#editid").val(response.order_id);
                $("#PricePayed").val(response.PricePayed);
                $("#MerchantOrderID").val(response.MerchantOrderID);
                $("#LastFourDigitsofCCInUsed").val(response.LastFourDigitsofCCInUsed);
                $("#ShipmentTrackingNumber").val(response.ShipmentTrackingNumber);
                $('#ShipmentCarrierFormat option[value="'+response.ShipmentCarrierFormat+'"]').attr('selected','selected');
                $("#TrackingNumber").val(response.TrackingNumber);
                $('#CarrierFormat option[value="'+response.CarrierFormat+'"]').attr('selected','selected');
                $("#RMANumber").val(response.RMANumber);
                $("#BuyerRefund").val(response.BuyerRefund);
                $("#SupplierRefunded").val(response.SupplierRefunded);
                $("#AmazonFeeKept").val(response.AmazonFeeKept);
                $('#ListedBy option[value="'+response.ListedBy+'"]').attr('selected','selected');
                $('#OrderStatus option[value="'+response.OrderStatus+'"]').attr('selected','selected');

                if(response.shipment_date === null){
                    $("#shipment_date").val("");
                }else{
                    arsdate = response.shipment_date.split('-');
                    response.shipment_date = arsdate[1]+'/'+arsdate[2]+'/'+arsdate[0];
                    $("#shipment_date").val(response.shipment_date);
                }

                if(response.OrderStatus == "Canceled"){
                    $("#reason_cancel_div").show();
                    $('#reason_cancel_div option[value="'+response.reason_cancel+'"]').attr('selected','selected');
                }else{
                    $("#reason_cancel_div").hide();
                }

                if( response.RMANumber.trim() != '' || response.BuyerRefund > 0 || response.SupplierRefunded > 0 || response.AmazonFeeKept > 0 ) {
                    $("#reason_refund_div").show();
                    $('#RefundReason option[value="'+response.RefundReason+'"]').attr('selected','selected');
                }
                else {
                    $("#reason_refund_div").hide();
                }

                if(response.shippedby_name === null){
                    $("#shipped_by_div").hide();
                }else{
                    $("#shipped_by_div").show();
                    $('#shipped_by').val(response.shippedby_name);

                }
                $('#ModalOrderChildStatus option[value="'+response.ModalOrderChildStatus+'"]').attr('selected','selected');
                $("#Note").val(response.Note);
                $("#BuyerName").val(response.BuyerName);

                getDetailsFromASIN(asin);
                $("#seller_id").val(response.AmazonSellerId);
            }
        });
    });

    function getDetailsFromASIN(asin)
    {
        $.ajax(
        {
            url: '<?php echo ADMIN_LINK ?>AmazonOrderController/getASINRecord',
            method:"POST",
            data: {
                "asin": asin,
            },
            success: function (response)
            {
                $("#notify_asin").val(asin);
                $("#asin_short").show();
                $(".dis_details_from_asin").html(response);
            }
        });
    }

    $('#form-updateOrder').validate({
        rules:{
            PricePayed :{ required : true,number:true,min:0,max:999999 },
            MerchantOrderID :{ required : false,maxlength:100 },
            LastFourDigitsofCCInUsed :{ required : false,maxlength:4 },
            ShipmentTrackingNumber :{ required : false,maxlength:450 },
            TrackingNumber :{ required : false,maxlength:450 },
            RMANumber :{ required : false,maxlength:450 },
            BuyerRefund :{ required : false,number:true,min:0,max:999999 },
            SupplierRefunded :{ required : false,number:true,min:0,max:999999 },
            AmazonFeeKept :{ required : false,number:true,min:0,max:999999 },
        },
        messages:{
            PricePayed :{ required : "Purchase Cost is required",number:"The field Purchase Cost must be a number.",min:"Allowed range is 0-999999",max:"Allowed range is 0-999999" },
            MerchantOrderID :{ required : "Supplier Order ID is required",maxlength:"Maximum length is 100" },
            LastFourDigitsofCCInUsed :{ required : "Last 4 digits of CC used is required",maxlength:"Maximum length is 4" },
            ShipmentTrackingNumber :{ required : "Shipment Tracking is required",maxlength:"Maximum length is 450" },
            TrackingNumber :{ required : "Return Tracking is required",maxlength:"Maximum length is 450" },
            RMANumber :{ required : "RMA is required",maxlength:"Maximum length is 450" },
            BuyerRefund :{ required : "Buyer Refund is required",number:"The field Buyer Refund must be a number.",min:"Allowed range is 0-999999",max:"Allowed range is 0-999999" },
            SupplierRefunded :{ required : "Supplier Refunded is required",number:"The field Supplier Refunded must be a number.",min:"Allowed range is 0-999999",max:"Allowed range is 0-999999" },
            AmazonFeeKept :{ required : "Amazon Fee Kept is required",number:"The field Amazon Fee Kept must be a number.",min:"Allowed range is 0-999999",max:"Allowed range is 0-999999" },
        }
    });

    $(document).on("change","#OrderStatus",function(){
            if($(this).val() == "Canceled"){
                $("#reason_cancel_div").show();
            }else{
                $("#reason_cancel_div").hide();
            }
    });

    $(document).on("change", "#RMANumber, #BuyerRefund, #SupplierRefunded, #AmazonFeeKept", function(){
            if( $('#RMANumber').val().trim() != '' || $('#BuyerRefund').val() > 0 || $('#SupplierRefunded').val() > 0 || $('#AmazonFeeKept').val() > 0 ) {
                $("#reason_refund_div").show();
            }else{
                $("#reason_refund_div").hide();
            }
    });

    function last_update(order_id)
    {
        $.ajax({
            url: '<?php echo ADMIN_LINK; ?>AmazonOrderController/last_update',
            method:"POST",
            data: {
                "order_id": order_id
            },
            success: function (response)
            {
            }
        });
    }

    $(document).on("click", "#notify_email", function(){
        if($("#from_amount").val() == "" || $("#to_amount").val() == ""){
            if($("#from_amount").val() == ""){
                $("#from_amount-error").show();
            }else{
                $("#from_amount-error").hide();
            }
            if($("#to_amount").val() == ""){
                $("#to_amount-error").show();
            }else{
                $("#to_amount-error").show();
            }
        }else{
            $("#addpopUpmodal #min_amount").val($("#from_amount").val());
            $("#addpopUpmodal #max_amount").val($("#to_amount").val());
            $("#addpopUpmodal #notify_asin").val($("#notify_asin").val());

            $('#updateOrderModal').modal('hide');
            $('#addpopUpmodal').modal('show');
        }
    });

    $(document).on("keyup", "#from_amount, #to_amount", function(){
            if($("#from_amount").val() == ""){
                $("#from_amount-error").show();
            }else{
                $("#from_amount-error").hide();
            }
            if($("#to_amount").val() == ""){
                $("#to_amount-error").show();
            }else{
                $("#to_amount-error").hide();
            }
    });




    $('#filter_refresh').click(function() {
        //document.getElementById("").reset();
        resetForm($("#extrasearchForm"));
        searchFilter();
    });

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
        $("#OrderDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "")
        $("#ShippedDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "");
        $("#end_ShippedDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "");
        $("#DeliveryDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "");
        $("#end_DeliveryDate").datepicker({
            autoclose: true,
            todayHighlight: true
        }).datepicker('setDate', "");
    }

    $(document).on("click", ".field_check", function(){
        var formData = $('#tabel_field').serialize();
        //console.log(formData);
        $.ajax({
            url: '<?php echo ADMIN_LINK ?>AmazonOrderController/fields_show',
            type: 'POST',
            data: formData,
            success: function(data)
            {
                searchFilter();
            }
        });
    });

	$(".right-menu-sidebar .hideshow-column").on("click", function() {
		$(".right-menu-sidebar").toggleClass('active');
	});



    $(document).on("click", "#add_notify_email", function(){
        var count = parseInt($("#n_email_count").val());
        $("#notify_email_div").append(`<div class="form-row" id="remove_n_div_`+count+`">
                                            <div class="form-group col-md-10 mb-0">
                                                <label class="font-weight-semibold"></label>
                                                <input name="notify_email[]" class="form-control notify_email" placeholder="Notify Email" value="" type="email" id="email`+count+`">
                                                <label id="email-error" class="error" style="display:none">please enter your email</label>
                                            </div>
                                            <div class="form-group col-md-2 mb-0">
                                                <button type="button" data-id="`+count+`" class="btn btn-danger mt-4" id="remove_notify_email">
                                                    <i class="far fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>`);
        $("#n_email_count").val(count+1);
    });



    $(document).on("click", "#remove_notify_email", function(){
        var id = $(this).data('id');
        $("#remove_n_div_"+id+"").remove();
    });



    $(document).on("click", "#btnnotify", function(){
        $flag = true;
        $(".notify_email").each(function(){
            if($(this).val() == ""){
                $flag = false;
                $(this).parent().find("#email-error").html("");
                $(this).parent().find("#email-error").html("Please enter email.");
                $(this).parent().find("#email-error").show();
            }else if(!isEmail($(this).val())){
                $flag = false;
                $(this).parent().find("#email-error").html("");
                $(this).parent().find("#email-error").html("Please enter valid email.");
                $(this).parent().find("#email-error").show();
            }else{
                $flag = true;
                $(this).parent().find("#email-error").html("");
                $(this).parent().find("#email-error").hide();
            }
        });

        if($flag){
            var formData = $("form#form-addNewRecord").serialize();

            //console.log(formData);
            $.ajax({
                url: '<?php echo ADMIN_LINK ?>AmazonOrderController/notifiy',
                type: 'POST',
                data: formData,
                success: function(response)
                {
                    $('#addpopUpmodal').modal("hide");
                    swal("Notification request added successfully.");
                    $("#notify_email_div").html("");
                }
            });
        }
    });

    $(document).on("keyup", ".notify_email", function(){
        if($(this).val() == ""){
            $flag = false;
            $(this).parent().find("#email-error").html("");
            $(this).parent().find("#email-error").html("Please enter email.");
            $(this).parent().find("#email-error").show();
        }else if(!isEmail($(this).val())){
            $flag = false;
            $(this).parent().find("#email-error").html("");
            $(this).parent().find("#email-error").html("Please enter valid email.");
            $(this).parent().find("#email-error").show();
        }else{
            $flag = true;
            $(this).parent().find("#email-error").html("");
            $(this).parent().find("#email-error").hide();
        }
    });


    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

</script>