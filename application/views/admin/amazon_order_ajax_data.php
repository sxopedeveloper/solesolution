<?php
/*function replace($match){
$key = trim($match[1]);
$val = trim($match[2]);

if($val[0] == '"')
$val = '"'.addslashes(substr($val, 1, -1)).'"';
else if($val[0] == "'")
$val = "'".addslashes(substr($val, 1, -1))."'";

return $key.": ".$val;
}*/

$field_row = $this->crud->get_data_row_by_id("fields_module", "user_id", $this->session->userdata('userId'));
if (empty($field_row)) {
    $field_row = (object) array(
        "ASIN" => 1,
        "AmazonOrderId" => 1,
        "MerchantOrderID" => 1,
        "Title" => 1,
        "PurchaseDateNew" => 1,
        "Lastupdate" => 1,
        "LastupdateBy" => 1,
        "SellerSKU" => 1,
        "ShipmentTrackingNumber" => 1,
        "ShipmentTrackingStatus" => 1,
        "shipment_date" => 1,
        "OrderTotal__Amount" => 1,
        "PricePayed" => 1,
        "total_profit" => 1,
        "roi" => 1,
        "OrderStatus" => 1,
        "late_shipment" => 1,
        "OrderTotal__Amount" => 1,
    );

}

$total_orders_count = isset($all_total_details) ? count($all_total_details) : 0;

$card_total_purchase_cost = 0;
$card_total_profit = 0;
$card_total_paid = 0;
$card_total_amazon_fees = 0;
$card_total_roi_cal = 0;
$card_margin_cal = 0;

if (!empty($all_total_details)): foreach ($all_total_details as $post):

        $order_item = $post['OrderItems'];
        if ($post['add_from'] == 0) {
            $order_item = addslashes($order_item);
            $order_item = str_replace('{\"', '{"', $order_item);
            $order_item = str_replace('\":', '":', $order_item);
            $order_item = str_replace('": \"', '": "', $order_item);
            $order_item = str_replace('\", \"', '", "', $order_item);
            $order_item = str_replace('\"}, \"', '"}, "', $order_item);
            $order_item = str_replace('\"}', '"}', $order_item);
            //echo $order_item;
            //$order_item = $this->crud->fixJSON( $order_item );
            //$order_item = $this->crud->fixJSON1( $order_item );

            $order_item_arr = json_decode($order_item, true);
            $orderitem_data = $order_item_arr[0]['OrderItem'];
        } else {
            $order_item_arr = json_decode($order_item, true);
            $orderitem_data = $order_item_arr['OrderItems'][0];

        }    

        if ($post['OrderTotal__Amount'] != 0 && $post['PricePayed'] != 0) {
            $amazon_fees = (0.15 * $post['OrderTotal__Amount']);
            $buyer_amazon_fees = (0.15 * $orderitem_data['ItemPrice']['Amount']);
            $price_diff = ($post['OrderTotal__Amount'] - $post['PricePayed']);
            $buyer_price_diff = ($orderitem_data['ItemPrice']['Amount'] - $post['PricePayed']);
            $cal_profit = round($price_diff - $amazon_fees, 2);
            $buyer_cal_profit = round($buyer_price_diff - $buyer_amazon_fees, 2);
        } else {
            $amazon_fees = 0;
            $buyer_amazon_fees = 0;
            $cal_profit = "0.00";
        }

        $card_total_purchase_cost += $post['PricePayed'];
        $card_total_profit += $cal_profit;
        $card_buyer_profit += $buyer_cal_profit;
        $card_total_paid += is_numeric($post['OrderTotal__Amount']) ? $post['OrderTotal__Amount'] : 0;
        $BuyerPaid = $orderitem_data['ItemPrice']['Amount'];
        $card_buyer_paid += is_numeric($BuyerPaid) ? $BuyerPaid : 0;

        $card_total_amazon_fees += $amazon_fees;
        $card_buyer_amazon_fees += $buyer_amazon_fees;
    endforeach;

    if ($card_total_profit != 0) {
        $card_total_roi_cal = round($card_total_profit / $card_total_purchase_cost * 100, 2);
        $card_margin_cal = round($card_total_profit / $card_total_paid * 100, 2);
    }

    if ($card_buyer_profit != 0) {
        $card_buyer_roi_cal = round($card_buyer_profit / $card_total_purchase_cost * 100, 2);
        $card_buyer_margin_cal = round($card_buyer_profit / $card_buyer_paid * 100, 2);
    }
endif;

?>
<div class="row">
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Orders</p>
                        <h2 class="m-b-0">
                            <span><?=$total_orders_count;?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Gross Sales</p>
                        <h2 class="m-b-0">
                            <span class="card_gross_sales"><?=CURR_SYMBOL . " " . number_format(round($card_buyer_paid));?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Cogs</p>
                        <h2 class="m-b-0">
                            <span class="card_cogs_total"><?=CURR_SYMBOL . " " . number_format(round($card_total_purchase_cost));?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Amazon fees</p>
                        <h2 class="m-b-0">
                            <span class="card_amazon_fees_total"><?=CURR_SYMBOL . " " . number_format(round($card_buyer_amazon_fees));?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Total profit</p>
                        <h2 class="m-b-0">
                            <span class="card_total_profit"><?=CURR_SYMBOL . " " . number_format(round($card_buyer_profit));?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">ROI</p>
                        <h2 class="m-b-0">
                            <span class="card_total_roi"><?=$card_buyer_roi_cal . " %";?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card top-list">
            <div class="card-body">
                <div class="d-flex justify-content-center align-items-center text-center">
                    <div>
                        <p class="m-b-0">Margin</p>
                        <h2 class="m-b-0">
                            <span class="card_total_margin"><?=$card_buyer_margin_cal . " %";?></span>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-5">
    <div class="card-body custom-data-table cus-table-width">
        <table class="table table-responsive" style="width: 100%;" id="datatable-scroller">
            <thead>
                <tr>
                    <th data-orderable="false">ACTIONS</th>
                    <?php if ($field_row->ASIN == 1) {?>
                        <th>ASIN NUMBER</th>
                    <?php }?>
                    <?php if ($field_row->Store_name == 1) {?>
                        <th>Store Name</th>
                    <?php } ?>
                    <?php if ($field_row->AmazonOrderId == 1) {?>
                        <th>ORDER ID</th>
                    <?php }?>
                    <?php if ($field_row->BuyerName == 1) {?>
                        <th>Buyer Name</th>
                    <?php }?>
                    <?php if ($field_row->Note == 1) {?>
                        <th>Note</th>
                    <?php }?>
                    <?php if ($field_row->MerchantOrderID == 1) {?>
                        <th>SUPPLIER ORDER ID</th>
                    <?php }?>
                    <?php if ($field_row->Title == 1) {?>
                        <th>AMAZON TITLE</th>
                    <?php }?>
                    <?php if ($field_row->PurchaseDateNew == 1) {?>
                        <th>PURCHASE DATE</th>
                    <?php }?>
                    <?php if ($field_row->Lastupdate == 1) {?>
                        <th>LAST UPDATED DATE</th>
                    <?php }?>
                    <?php if ($field_row->LastupdateBy == 1) {?>
                        <th data-orderable="false">LAST UPDATED BY</th>
                    <?php }?>
                    <?php if ($field_row->SellerSKU == 1) {?>
                        <th>SKU</th>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingNumber == 1) {?>
                        <th data-orderable="false">SHIPMENT TRACKING #</th>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingStatus == 1) {?>
                        <th data-orderable="false">SHIPMENT TRACKING STATUS</th>
                    <?php }?>
                    <?php if ($field_row->shipment_date == 1) {?>
                        <th data-orderable="false">SHIPMENT DATE</th>
                    <?php }?>
                    <th data-orderable="false">BUYER PAID</th>
                    <?php if ($field_row->OrderTotal__Amount == 1) {?>
                        <th data-orderable="false">ORDER TOTAL</th>
                    <?php }?>
                    <?php if ($field_row->PricePayed == 1) {?>
                        <th data-orderable="false">PURCHASE COST</th>
                    <?php }?>
                    <?php if ($field_row->total_profit == 1) {?>
                        <th data-orderable="false">TOTAL PROFIT</th>
                    <?php }?>
                    <?php if ($field_row->roi == 1) {?>
                        <th data-orderable="false">NET ROI</th>
                    <?php }?>
                    <?php if ($field_row->OrderStatus == 1) {?>
                        <th>STATUS</th>
                    <?php }?>
                    <?php if ($field_row->late_shipment == 1) {?>
                        <th data-orderable="false">LATE SHIPMENT</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
                <?php
$tablename = base64_encode('amazon_orders');
$tableId = base64_encode('order_id');

$total_purchase_cost = 0;
$total_profit = 0;
$total_paid = 0;
$total_buyer_paid = 0;
if (!empty($posts)): foreach ($posts as $post):
        //echo "<pre>";print_r($post);
        $order_item = $post['OrderItems'];
        if ($post['add_from'] == 0) {
            $order_item = addslashes($order_item);
            $order_item = str_replace('{\"', '{"', $order_item);
            $order_item = str_replace('\":', '":', $order_item);
            $order_item = str_replace('": \"', '": "', $order_item);
            $order_item = str_replace('\", \"', '", "', $order_item);
            $order_item = str_replace('\"}, \"', '"}, "', $order_item);
            $order_item = str_replace('\"}', '"}', $order_item);
            //echo $order_item;
            //$order_item = $this->crud->fixJSON( $order_item );
            //$order_item = $this->crud->fixJSON1( $order_item );

            $order_item_arr = json_decode($order_item, true);
            $orderitem_data = $order_item_arr[0]['OrderItem'];
        } else {
            $order_item_arr = json_decode($order_item, true);
            $orderitem_data = $order_item_arr['OrderItems'][0];

        }

        if ($post['OrderTotal__Amount'] != 0 && $post['PricePayed'] != 0) {
            $amazon_fees = (0.15 * $post['OrderTotal__Amount']);
            $buyer_amazon_fees = (0.15 * $orderitem_data['ItemPrice']['Amount']);
            $price_diff = ($post['OrderTotal__Amount'] - $post['PricePayed']);
            $buyer_price_diff = ($orderitem_data['ItemPrice']['Amount'] - $post['PricePayed']);
            $cal_profit = round($price_diff - $amazon_fees, 2);
            $buyer_cal_profit = round($buyer_price_diff - $buyer_amazon_fees, 2);

            $dis_roi_cal = round($cal_profit / $post['PricePayed'] * 100, 2);
            $buyer_dis_roi_cal = round($buyer_cal_profit / $post['PricePayed'] * 100, 2);
        } else {
            $amazon_fees = 0;
            $cal_profit = "0.00";
            $buyer_cal_profit = "0.00";
            $dis_roi_cal = "0.00";
            $buyer_dis_roi_cal = "0.00";
        }

        $total_purchase_cost += $post['PricePayed'];
        $total_profit += $cal_profit;
        $buyer_profit += $buyer_cal_profit;
        $total_paid += is_numeric($post['OrderTotal__Amount']) ? $post['OrderTotal__Amount'] : 0;

        $Title = $this->crud->limit_character($orderitem_data['Title'], 20);
        $Full_Title = $orderitem_data['Title'];
        $BuyerPaid = $orderitem_data['ItemPrice']['Amount'];
        $total_buyer_paid += is_numeric($BuyerPaid) ? $BuyerPaid : 0;

        $Note = $this->crud->limit_character($post['Note'], 20);
        $Full_Note = $post['Note'];
        $ASIN = $orderitem_data['ASIN'];
        $SellerSKU = $orderitem_data['SellerSKU'];
        ?>
                    <tr>
                        <td>
                            <?php if ($post['OrderStatus'] == 'Shipped') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-warning rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'Refund Completed') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-success rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'Canceled' || $post['OrderStatus'] == 'State Restriction') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-dark rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'Refund Requested') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-danger rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'Pending') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-secondary rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'Ordered') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-warning rowEdit">Update Order</button>
                            <?php } elseif ($post['OrderStatus'] == 'OOS') {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-light rowEdit">Update Order</button>
                            <?php } else {?>
                                <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['order_id']?>" data-asin="<?=$ASIN?>" class="btn btn-primary rowEdit">Update Order</button>
                            <?php }?>
                        </td>
                    <?php if ($field_row->ASIN == 1) {?>
                        <td><a target="_blank" href="https://www.amazon.com/gp/product/<?=$ASIN?>" onclick="last_update('<?=$post['order_id'];?>');"><?=$ASIN;?></a></td>
                    <?php }?>
                    <?php if ($field_row->Store_name == 1) {?>
                        <td>
                            <?php if($post['AmazonSellerId'] != ""){ 
                                echo $this->crud->get_column_value_by_id("store","name","AmazonSellerId = '".$post['AmazonSellerId']."'");
                             } ?>
                        </td>
                    <?php } ?>
                    <?php if ($field_row->AmazonOrderId == 1) {?>
                        <td><a href="https://sellercentral.amazon.com/orders-v3/order/<?=$post['AmazonOrderId'];?>" target="_blank"><?=$post['AmazonOrderId'];?></a></td>
                    <?php }?>
                    <?php if ($field_row->BuyerName == 1) {?>
                        <td><?=$post['BuyerName'];?></td>
                    <?php }?>
                    <?php if ($field_row->Note == 1) {?>
                        <td><div class="d-flex align-items-center"><p title="<?=$Full_Note;?>"><?=$Note;?></p></div></td>
                    <?php }?>
                    <?php if ($field_row->MerchantOrderID == 1) {?>
                        <td><?=$post['MerchantOrderID'];?></td>
                    <?php }?>
                    <?php if ($field_row->Title == 1) {?>
                        <td><div class="d-flex align-items-center"><i class="fas fa-envelope mr-2"></i> <p title="<?=$Full_Title;?>"><?=$Title;?></p></div></td>
                    <?php }?>
                    <?php if ($field_row->PurchaseDateNew == 1) {?>
                        <td><?=$post['PurchaseDateNew'];?></td>
                    <?php }?>
                    <?php if ($field_row->Lastupdate == 1) {?>
                        <td><?=date('m/d/Y', strtotime($post['Lastupdate']));?></td>
                    <?php }?>
                    <?php if ($field_row->LastupdateBy == 1) {?>
                        <td><?=$this->crud->get_column_value('tbl_users', 'CONCAT(fname, " ", lname)', 'id=' . $post['LastupdateBy']);?></td>
                    <?php }?>
                    <?php if ($field_row->SellerSKU == 1) {?>
                        <td><?=$SellerSKU;?></td>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingNumber == 1) {?>
                        <td><?=$post['ShipmentTrackingNumber'];?></td>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingStatus == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->shipment_date == 1) {?>
                        <td><?=($post['OrderStatus'] == 'Shipped') ? date('m/d/Y', strtotime($post['shipment_date'])) : '';?></td>
                    <?php }?>
                    <td><?=CURR_SYMBOL . " " . $BuyerPaid;?></td>
                    <?php if ($field_row->OrderTotal__Amount == 1) {?>
                        <td><?=CURR_SYMBOL . " " . $post['OrderTotal__Amount'];?></td>
                    <?php }?>
                    <?php if ($field_row->PricePayed == 1) {?>
                        <td><?=CURR_SYMBOL . " " . $post['PricePayed'];?></td>
                    <?php }?>
                    <?php if ($field_row->total_profit == 1) {?>
                        <td><?=CURR_SYMBOL . " " . $buyer_cal_profit;?></td>
                    <?php }?>
                    <?php if ($field_row->roi == 1) {?>
                        <td><?=$buyer_dis_roi_cal . " %";?></td>
                    <?php }?>
                    <?php if ($field_row->OrderStatus == 1) {?>
                        <td><?=$post['OrderStatus']?></td>
                    <?php }?>
                    <?php if ($field_row->late_shipment == 1) {?>
                        <td></td>
                    <?php }?>
                </tr>
                <?php endforeach;?>

                <?php else: ?>
                <tr>
                    <td colspan="18">
                        <div class="alert alert-warning"><i class="fa fa-info-circle"></i> There are currently no amazon orders to show.</div>
                    </td>
                </tr>
                <?php endif?>
            </tbody>
            <?php if (!empty($posts)): ?>
            <tfoot>
                <tr>
                    <td><b>Total</b></td>
                    <?php if ($field_row->ASIN == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->Store_name == 1) {?>
                        <td></td>
                    <?php } ?>
                    <?php if ($field_row->AmazonOrderId == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->AmazonOrderId == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->BuyerName == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->Note == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->Title == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->PurchaseDateNew == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->Lastupdate == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->LastupdateBy == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->SellerSKU == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingNumber == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->ShipmentTrackingStatus == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->shipment_date == 1) {?>
                        <td></td>
                    <?php }?>
                    <td><b><?=CURR_SYMBOL . " " . $total_buyer_paid;?></b></td>
                    <?php if ($field_row->OrderTotal__Amount == 1) {?>
                        <td><b><?=CURR_SYMBOL . " " . $total_paid;?></b></td>
                    <?php }?>
                    <?php if ($field_row->PricePayed == 1) {?>
                        <td><b><?=CURR_SYMBOL . " " . $total_purchase_cost;?></b></td>
                    <?php }?>
                    <?php if ($field_row->total_profit == 1) {?>
                        <td><b><?=CURR_SYMBOL . " " . $buyer_profit;?></b></td>
                    <?php }?>
                    <?php if ($field_row->roi == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->OrderStatus == 1) {?>
                        <td></td>
                    <?php }?>
                    <?php if ($field_row->late_shipment == 1) {?>
                        <td></td>
                    <?php }?>
                </tr>
            </tfoot>
            <?php endif?>
        </table>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php echo $this->ajax_pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".top_total_orders_count").text('(<?=$total_orders_count;?>)');
</script>

