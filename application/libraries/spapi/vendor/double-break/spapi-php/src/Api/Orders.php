<?php
/**
* This class is autogenerated by the Spapi class generator
* Date of generation: 2020-12-22
* Specification: ttps://github.com/amzn/selling-partner-api-models/blob/main/models/orders-api-model/ordersV0.json
* Source MD5 signature: 3ee8c0b650b777c8e09919068bdc0f23
*
*
* Selling Partner API for Orders
* The Selling Partner API for Orders helps you programmatically retrieve order information. These APIs let you develop fast, flexible, custom applications in areas like order synchronization, order research, and demand-based decision support tools.
*/
namespace DoubleBreak\Spapi\Api;
use DoubleBreak\Spapi\Client;

class Orders extends Client {

  /**
  * Operation getOrders
  *
  * @param array $queryParams
  *    - *createdAfter* string - A date used for selecting orders created after (or at) a specified time. Only orders placed after the specified time are returned. Either the CreatedAfter parameter or the LastUpdatedAfter parameter is required. Both cannot be empty. The date must be in ISO 8601 format.
  *    - *createdBefore* string - A date used for selecting orders created before (or at) a specified time. Only orders placed before the specified time are returned. The date must be in ISO 8601 format.
  *    - *lastUpdatedAfter* string - A date used for selecting orders that were last updated after (or at) a specified time. An update is defined as any change in order status, including the creation of a new order. Includes updates made by Amazon and by the seller. The date must be in ISO 8601 format.
  *    - *lastUpdatedBefore* string - A date used for selecting orders that were last updated before (or at) a specified time. An update is defined as any change in order status, including the creation of a new order. Includes updates made by Amazon and by the seller. The date must be in ISO 8601 format.
  *    - *orderStatuses* array - A list of OrderStatus values used to filter the results. Possible values: PendingAvailability (This status is available for pre-orders only. The order has been placed, payment has not been authorized, and the release date of the item is in the future.); Pending (The order has been placed but payment has not been authorized); Unshipped (Payment has been authorized and the order is ready for shipment, but no items in the order have been shipped); PartiallyShipped (One or more, but not all, items in the order have been shipped); Shipped (All items in the order have been shipped); InvoiceUnconfirmed (All items in the order have been shipped. The seller has not yet given confirmation to Amazon that the invoice has been shipped to the buyer.); Canceled (The order has been canceled); and Unfulfillable (The order cannot be fulfilled. This state applies only to Multi-Channel Fulfillment orders.).
  *    - *marketplaceIds* array - A list of MarketplaceId values. Used to select orders that were placed in the specified marketplaces.
  *    - *fulfillmentChannels* array - A list that indicates how an order was fulfilled. Filters the results by fulfillment channel. Possible values: FBA (Fulfillment by Amazon); SellerFulfilled (Fulfilled by the seller).
  *    - *paymentMethods* array - A list of payment method values. Used to select orders paid using the specified payment methods. Possible values: COD (Cash on delivery); CVS (Convenience store payment); Other (Any payment method other than COD or CVS).
  *    - *buyerEmail* string - The email address of a buyer. Used to select orders that contain the specified email address.
  *    - *sellerOrderId* string - An order identifier that is specified by the seller. Used to select only the orders that match the order identifier. If SellerOrderId is specified, then FulfillmentChannels, OrderStatuses, PaymentMethod, LastUpdatedAfter, LastUpdatedBefore, and BuyerEmail cannot be specified.
  *    - *maxResultsPerPage* integer - A number that indicates the maximum number of orders that can be returned per page. Value must be 1 - 100. Default 100.
  *    - *easyShipShipmentStatuses* array - A list of EasyShipShipmentStatus values. Used to select Easy Ship orders with statuses that match the specified  values. If EasyShipShipmentStatus is specified, only Amazon Easy Ship orders are returned.Possible values: PendingPickUp (Amazon has not yet picked up the package from the seller). LabelCanceled (The seller canceled the pickup). PickedUp (Amazon has picked up the package from the seller). AtOriginFC (The packaged is at the origin fulfillment center). AtDestinationFC (The package is at the destination fulfillment center). OutForDelivery (The package is out for delivery). Damaged (The package was damaged by the carrier). Delivered (The package has been delivered to the buyer). RejectedByBuyer (The package has been rejected by the buyer). Undeliverable (The package cannot be delivered). ReturnedToSeller (The package was not delivered to the buyer and was returned to the seller). ReturningToSeller (The package was not delivered to the buyer and is being returned to the seller).
  *    - *nextToken* string - A string token returned in the response of your previous request.
  *    - *amazonOrderIds* array - A list of AmazonOrderId values. An AmazonOrderId is an Amazon-defined order identifier, in 3-7-7 format.
  *
  */
  public function getOrders($queryParams = [])
  {
    return $this->send("/orders/v0/orders", [
      'method' => 'GET',
      'query' => $queryParams,
    ]);
  }

  /**
  * Operation getOrder
  *
  * @param string $orderId An Amazon-defined order identifier, in 3-7-7 format.
  *
  */
  public function getOrder($orderId)
  {
    return $this->send("/orders/v0/orders/{$orderId}", [
      'method' => 'GET',
    ]);
  }

  /**
  * Operation getOrderBuyerInfo
  *
  * @param string $orderId An orderId is an Amazon-defined order identifier, in 3-7-7 format.
  *
  */
  public function getOrderBuyerInfo($orderId)
  {
    return $this->send("/orders/v0/orders/{$orderId}/buyerInfo", [
      'method' => 'GET',
    ]);
  }

  /**
  * Operation getOrderAddress
  *
  * @param string $orderId An orderId is an Amazon-defined order identifier, in 3-7-7 format.
  *
  */
  public function getOrderAddress($orderId)
  {
    return $this->send("/orders/v0/orders/{$orderId}/address", [
      'method' => 'GET',
    ]);
  }

  /**
  * Operation getOrderItems
  *
  * @param string $orderId An Amazon-defined order identifier, in 3-7-7 format.
  *
  * @param array $queryParams
  *    - *nextToken* string - A string token returned in the response of your previous request.
  *
  */
  public function getOrderItems($orderId, $queryParams = [])
  {
    return $this->send("/orders/v0/orders/{$orderId}/orderItems", [
      'method' => 'GET',
      'query' => $queryParams,
    ]);
  }

  /**
  * Operation getOrderItemsBuyerInfo
  *
  * @param string $orderId An Amazon-defined order identifier, in 3-7-7 format.
  *
  * @param array $queryParams
  *    - *nextToken* string - A string token returned in the response of your previous request.
  *
  */
  public function getOrderItemsBuyerInfo($orderId, $queryParams = [])
  {
    return $this->send("/orders/v0/orders/{$orderId}/orderItems/buyerInfo", [
      'method' => 'GET',
      'query' => $queryParams,
    ]);
  }
}