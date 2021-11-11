<?php
$servername = "localhost";
$username 	= "solesons_sole_so";
$password 	= "tG6]mauAQc9D";
$dbname 	= "solesons_sole_solutions";
// $username = "root";
// $password = "";
// $dbname = "sole_solutions_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// 61909



// print_r($result);


$sql = "SELECT AmazonOrderId, COUNT(AmazonOrderId) as c FROM amazon_orders where AmazonOrderId != '' GROUP BY AmazonOrderId HAVING COUNT(AmazonOrderId) > 1 LIMIT 50;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["AmazonOrderId"]. " - count: " . $row["c"]. "<br>";

    $sql2 = "SELECT `order_id`, MIN(Lastupdate) FROM `amazon_orders` WHERE `AmazonOrderId` LIKE '".$row["AmazonOrderId"]."' ";
    // echo $sql2; die;
    $result2 = $conn->query($sql2);
    while($row2 = $result2->fetch_assoc()) {
      echo "<br/>";
      $sql3 = "INSERT INTO deleted_amazon_orders (`order_id`, `AmazonSellerId`, `AmazonOrderId`, `ASIN_NO`, `BuyerEmail`, `DefaultShipFromLocationAddress__AddressLine1`, `DefaultShipFromLocationAddress__AddressLine3`, `DefaultShipFromLocationAddress__City`, `DefaultShipFromLocationAddress__CountryCode`, `DefaultShipFromLocationAddress__Name`, `DefaultShipFromLocationAddress__Phone`, `DefaultShipFromLocationAddress__PostalCode`, `DefaultShipFromLocationAddress__StateOrRegion`, `DefaultShipFromLocationAddress__isAddressSharingConfidential`, `EarliestDeliveryDate`, `EarliestShipDate`, `FulfillmentChannel`, `IsBusinessOrder`, `IsGlobalExpressEnabled`, `IsISPU`, `IsPremiumOrder`, `IsPrime`, `IsReplacementOrder`, `IsSoldByAB`, `LastUpdateDate`, `LatestDeliveryDate`, `LatestShipDate`, `MarketplaceId`, `NumberOfItemsShipped`, `NumberOfItemsUnshipped`, `OrderItems`, `OrderStatus`, `reason_cancel`, `OrderTotal__Amount`, `OrderTotal__CurrencyCode`, `OrderType`, `PaymentMethod`, `PaymentMethodDetails__PaymentMethodDetail`, `PurchaseDate`, `SalesChannel`, `SellerOrderId`, `ShipServiceLevel`, `ShipmentServiceLevelCategory`, `ShippedByAmazonTFM`, `ShippingAddress__City`, `ShippingAddress__CountryCode`, `ShippingAddress__PostalCode`, `ShippingAddress__StateOrRegion`, `ShippingAddress__isAddressSharingConfidential`, `id`, `PricePayed`, `MerchantOrderID`, `LastFourDigitsofCCInUsed`, `ShipmentTrackingNumber`, `ShipmentCarrierFormat`, `TrackingNumber`, `CarrierFormat`, `RMANumber`, `BuyerRefund`, `SupplierRefunded`, `AmazonFeeKept`, `RefundReason`, `ListedBy`, `ModalOrderChildStatus`, `Note`, `BuyerName`, `product_title`, `isDelete`, `Lastupdate`, `LastupdateBy`, `shippedby_id`, `shipment_date`, `OrderDate`, `add_from`) SELECT * FROM amazon_orders where order_id LIKE '".$row2['order_id']."'";
      $result3 = $conn->query($sql3);

      $sql4 = "DELETE FROM `amazon_orders` WHERE order_id LIKE '".$row2['order_id']."'";
      $result4 = $conn->query($sql4);

      echo $row2['order_id']."<br/>";
    }

  }
} else {
  echo "0 results";
}

$conn->close();
?>