<?php 
$all_total_details = isset($all_total_details) ? count($all_total_details) : 0;
?>
<div class="card mb-5">
    <div class="card-body custom-data-table cus-table-width" style="width:100%">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>sku</th>
                    <th>Product ID</th>
                    <th>product id type</th>
                    <th>price</th>
                    <th>minimum seller allowed price</th>
                    <th>maximum seller allowed price</th>
                    <th>item condition</th>
                    <th>quantity</th>
                    <th>will ship internationally</th>
                    <th>expedited shipping</th>
                    <th>standard plus</th>
                    <th>item note</th>
                    <th>fulfillment center id</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $tablename = base64_encode('product');
                $tableId = base64_encode('id');

                if(!empty($posts)): foreach($posts as $post): 
                //echo "<pre>";print_r($post);   
                $brand                          = $post['brand']; 
                $sku                            = $post['sku']; 
                $product_id                     = $post['product-id']; 
                $product_id_type                = $post['product-id-type']; 
                $price                          = $post['price']; 
                $minimum_seller_allowed_price   = $post['minimum-seller-allowed-price']; 
                $maximum_seller_allowed_price   = $post['maximum-seller-allowed-price']; 
                $item_condition                 = $post['item-condition']; 
                $quantity                       = $post['quantity']; 
                $will_ship_internationally      = $post['will-ship-internationally']; 
                $expedited_shipping             = $post['expedited-shipping']; 
                $standard_plus                  = $post['standard-plus']; 
                $item_note                      = $post['item-note']; 
                $fulfillment_center_id          = $post['fulfillment-center-id']; 
                ?>
                <tr>
                    <td><?=$brand;?></td>
                    <td><?=$sku;?></td>
                    <td><?=$product_id;?></td>
                    <td><?=$product_id_type;?></td>
                    <td><?=$price;?></td>
                    <td><?=$minimum_seller_allowed_price;?></td>
                    <td><?=$maximum_seller_allowed_price;?></td>
                    <td><?=$item_condition;?></td>
                    <td><?=$quantity;?></td>
                    <td><?=$will_ship_internationally;?></td>
                    <td><?=$expedited_shipping;?></td>
                    <td><?=$standard_plus;?></td>
                    <td><?=$item_note;?></td>
                    <td><?=$fulfillment_center_id;?></td>
                    <td>
                        <button type="button" data-td="<?=$tablename?>" data-i="<?=$tableId?>" data-id="<?=$post['id']?>" class="btn btn-primary rowEdit">View Details</button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="16">
                        <div class="alert alert-warning"><i class="fa fa-info-circle"></i> There are currently no products to show.</div>
                    </td>
                </tr>
                <?php endif ?>
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php echo $this->ajax_pagination->create_links(); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".top_all_total_details").text('(<?=$all_total_details;?>)');
</script>

