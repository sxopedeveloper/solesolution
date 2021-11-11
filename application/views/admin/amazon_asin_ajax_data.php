<?php
$total_orders_count = isset($all_total_details) ? count($all_total_details) : 0;
?>
<div class="card mb-5">
    <div class="card-body custom-data-table cus-table-width">
        <table class="table" style="width: 100%;" id="datatable-scroller">
            <thead>
                <tr>
                    <th>ASIN NUMBER</th>
                    <th>AMAZON TITLE</th>
                    <th>Total Order</th>
                    <th>Unit Sold</th>
                    <th>Unit cancelled</th>
                    <th>BUYER PAID</th>
                    <th>PURCHASE COST</th>
                    <th>TOTAL PROFIT</th>
                    <th>NET ROI</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $total_purchase_cost = 0;
                    $total_profit = 0;  
                    $total_buyer_paid = 0;
                    if (!empty($posts)):
                        foreach ($posts as $post):
                            if ($post['OrderTotal__Amount'] != 0 && $post['PricePayed'] != 0) {
                                $amazon_fees = (0.15 * $post['OrderTotal__Amount']);
                                $price_diff = ($post['OrderTotal__Amount'] - $post['PricePayed']);
                                $cal_profit = round($price_diff - $amazon_fees, 2);
                                $dis_roi_cal = round($cal_profit / $post['PricePayed'] * 100, 2);
                            } else {
                                $amazon_fees = 0;
                                $cal_profit = "0.00";
                                $dis_roi_cal = "0.00";
                            }
                            $total_purchase_cost += $post['PricePayed'];
                            $total_profit += $cal_profit;
                            $total_buyer_paid += is_numeric($post['OrderTotal__Amount']) ? $post['OrderTotal__Amount'] : 0;
                            $Title = $this->crud->limit_character($post['product_title'], 20);
                            $Full_Title = $post['product_title'];
                            $ASIN = $post['ASIN_NO'];
                            
                            $wh = array(
                                "isDelete" => 0,
                                "ASIN_NO" => $ASIN,
                                "OrderStatus" => "Shipped"
                            );
                            if (isset($search['OrdersType']) && $search['OrdersType'] != "") {
                                $wh['FulfillmentChannel'] = $search['OrdersType'];
                            }
                            if (isset($search['StartDate']) && $search['StartDate'] != "") {
                                $wh['DATE_FORMAT(PurchaseDate, "%m/%d/%Y") >= '] = $search['StartDate'];
                            }
                            if (isset($search['EndDate']) && $search['EndDate'] != "") {
                                $wh['DATE_FORMAT(PurchaseDate, "%m/%d/%Y") <= '] = $search['EndDate'];
                            }

                            
                            $sold = $this->crud->get_num_rows_with_where("amazon_orders", $wh);
                            $wh['OrderStatus'] = "Canceled";
                            $cancled = $this->crud->get_num_rows_with_where("amazon_orders", $wh);
                        ?>
                                                                                                                                                                            <tr>
                                <td><a target="_blank" href="https://www.amazon.com/gp/product/<?=$ASIN?>"><?=$ASIN;?></a></td>
                                <td><div class="d-flex align-items-center"><i class="fas fa-envelope mr-2"></i> <p title="<?=$Full_Title;?>"><?=$Title;?></p></div></td>
                                <td><?=$post['Total_order'];?></td>
                                <td><?=$sold;?></td>
                                <td><?=$cancled;?></td>
                                <td><?=CURR_SYMBOL . " " . round($post['OrderTotal__Amount'], 2);?></td>
                                <td><?=CURR_SYMBOL . " " . round($post['PricePayed'], 2);?></td>
                                <td><?=CURR_SYMBOL . " " . $cal_profit;?></td>
                                <td><?=$dis_roi_cal . " %";?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php else: ?>
                            <tr>
                                    <td colspan="5">
                                            <div class="alert alert-warning"><i class="fa fa-info-circle"></i> There are currently no Sales By ASIN show.</div>
                                    </td>
                            </tr>
                        <?php endif?>
                                </tbody>
                    <?php if (!empty($posts)): ?>
                        <tfoot>
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><b><?=CURR_SYMBOL . " " . $total_buyer_paid;?></b></td>
                                <td><b><?=CURR_SYMBOL . " " . $total_purchase_cost;?></b></td>
                                <td><b><?=CURR_SYMBOL . " " . $total_profit;?></b></td>
                                <td></td>
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