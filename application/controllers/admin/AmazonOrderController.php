<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

require APPPATH . '/libraries/BaseController.php';
require_once 'application/libraries/simplehtmldom/simple_html_dom_new.blade.php';
require_once 'application/libraries/spapi/vendor/autoload.php';

class AmazonOrderController extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Crud', 'crud');
        $this->load->library('Ajax_pagination.php');
        $this->table = 'amazon_orders';
        $this->perPage = 10;
    }
    
    public function import_order_backup()
    {
        $amazon_orders_backup = $this->crud->getFromSQL("SELECT `AmazonSellerId`, `AmazonOrderId`, `ASIN_NO`, `BuyerEmail`, `DefaultShipFromLocationAddress__AddressLine1`, `DefaultShipFromLocationAddress__AddressLine3`, `DefaultShipFromLocationAddress__City`, `DefaultShipFromLocationAddress__CountryCode`, `DefaultShipFromLocationAddress__Name`, `DefaultShipFromLocationAddress__Phone`, `DefaultShipFromLocationAddress__PostalCode`, `DefaultShipFromLocationAddress__StateOrRegion`, `DefaultShipFromLocationAddress__isAddressSharingConfidential`, `EarliestDeliveryDate`, `EarliestShipDate`, `FulfillmentChannel`, `IsBusinessOrder`, `IsGlobalExpressEnabled`, `IsISPU`, `IsPremiumOrder`, `IsPrime`, `IsReplacementOrder`, `IsSoldByAB`, `LastUpdateDate`, `LatestDeliveryDate`, `LatestShipDate`, `MarketplaceId`, `NumberOfItemsShipped`, `NumberOfItemsUnshipped`, `OrderItems`, `OrderStatus`, `reason_cancel`, `OrderTotal__Amount`, `OrderTotal__CurrencyCode`, `OrderType`, `PaymentMethod`, `PaymentMethodDetails__PaymentMethodDetail`, `PurchaseDate`, `SalesChannel`, `SellerOrderId`, `ShipServiceLevel`, `ShipmentServiceLevelCategory`, `ShippedByAmazonTFM`, `ShippingAddress__City`, `ShippingAddress__CountryCode`, `ShippingAddress__PostalCode`, `ShippingAddress__StateOrRegion`, `ShippingAddress__isAddressSharingConfidential`, `id`, `PricePayed`, `MerchantOrderID`, `LastFourDigitsofCCInUsed`, `ShipmentTrackingNumber`, `ShipmentCarrierFormat`, `TrackingNumber`, `CarrierFormat`, `RMANumber`, `BuyerRefund`, `SupplierRefunded`, `AmazonFeeKept`, `RefundReason`, `ListedBy`, `ModalOrderChildStatus`, `Note`, `BuyerName`, `product_title`, `isDelete`, `Lastupdate`, `LastupdateBy`, `shippedby_id`, `shipment_date`, `OrderDate`, `add_from` FROM `amazon_orders_backup`");
        // echo '<pre>'; print_r($amazon_orders_backup); echo '</pre>';exit;
        foreach(array_chunk($amazon_orders_backup, 50) as $amazon_orders) { 
            foreach($amazon_orders as $amazon_order) { 
                $check_array = array(
                    "AmazonOrderId" => $amazon_order->AmazonOrderId,
                    "OrderStatus" => $amazon_order->OrderStatus,
                );
                $amazonOrder = $this->crud->get_all_with_where($this->table, 'order_id', 'asc', $check_array);
                if (!empty($amazonOrder)) {
                    $amazonOrder = $amazonOrder[0];
                }
                $amazon_order->PurchaseDate = changeDateFormatUtcToPst($amazon_order->PurchaseDate);
                if (empty($amazonOrder) || $amazonOrder->OrderStatus != $amazon_order->OrderStatus) {
                    $this->crud->insert($this->table, (array) $amazon_order);
                    echo '<pre>'; print_r('PurchaseDate'. $amazon_order->PurchaseDate); echo '</pre>';
                    echo '<pre>'; print_r('AmazonOrderId'. $amazon_order->AmazonOrderId); echo '</pre>';
                }                
            }
            sleep(5);
        }

        echo '<pre>'; print_r('complete'); echo '</pre>'; exit;
    }

    public function index()
    {
        $this->isLoggedIn();

        $data = array();
        $data['totol_order_count'] = $this->crud->get_num_rows_with_where($this->table, array("isDelete" => 0));

        $data["user_lists"] = $this->crud->getFromSQL("select fname, id from tbl_users where isDeleted = 0 and (roleId = 4 OR roleId = 5)");
        $data["user_lists1"] = $this->crud->getFromSQL("select fname, lname, id from tbl_users where isDeleted = 0");
        $data["search"] = $this->session->userdata('filter_data');
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
                "BuyerName" => 1,
                "Store_name" => 1,
                "Note" => 1
            );
        }
        $data["field_row"] = $field_row;
        $data['site_email'] = $this->generalSetting()->site_from_email;
        $this->global['pageTitle'] = ' : Manage Amazon Orders';
        $this->loadViews(ADMIN . "ManageAmazonOrder", $this->global, $data, null);
    }

    public function export_excel()
    {
        $params = array();

        // $join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, JSON_EXTRACT(OrderItems, "$.OrderItems[0].Title") AS Title, (SELECT name from store as s WHERE s.AmazonSellerId = ao.AmazonSellerId Limit 1) as storeName';
        $join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(OrderItems, "{\'", "{\""), "\':", "\":"), ": \'", ": \""), "\', \'", "\", \""), "\'}", "\"}"), ", \'", ", \""), "\'", "") as OrderItems, (SELECT name from store as s WHERE s.AmazonSellerId = ao.AmazonSellerId Limit 1) as storeName';
        
        $join['table'] = 'amazon_orders ao';
        
        $userstores = $this->crud->get_row_by_id('tbl_users', ' id = ' . $this->session->userdata('userId') . '');
        if (!empty($userstores) && !empty($userstores['store_id'])) {
            if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
                $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
                
                $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
    
            } else {
                if($userstores['roleId'] == 1 || $userstores['roleId'] == 2){
                    $wh = array("ao.isDelete" => '0');                
                }else{
                    $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
    
                    if (!empty($active_store['AmazonSellerId'])) {
                        $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
                    } else {
                        $storeID = implode(', ', explode(',', $userstores['store_id']));
                        $stores = $this->crud->getFromSQL("SELECT store.AmazonSellerId FROM `store` WHERE  `isDelete` = 0 AND store.id IN (".$storeID.")");
                        
                        $sellerId = [];
                        foreach ($stores as $key => $value) {
                            $sellerId[] = $value->AmazonSellerId;
                        }
                        $params['in_field'] = 'ao.AmazonSellerId';
                        $params['in_value'] = $sellerId;
                        $wh['ao.isDelete'] = '0';
                    }
                }
    
            }
    
            if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
                $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
                $search['OrdersType'] = $_REQUEST['OrdersType'];
            }

            if (isset($_REQUEST['SearchTerm'])) {
                $SearchTerm = $_REQUEST['SearchTerm'];
                $search['SearchTerm'] = $_REQUEST['SearchTerm'];
            }

            if (!empty($SearchTerm)) {
                $params['like'] = array('ao.AmazonOrderId' => $SearchTerm, "ao.BuyerEmail" => $SearchTerm, "ao.OrderItems" => $SearchTerm,"ao.BuyerName"=> $SearchTerm);
            }

            if (isset($_REQUEST['SearchNote']) && !empty($_REQUEST['SearchNote'])) {
                $params['like'] = array('ao.Note' => $_REQUEST['SearchNote']);
            }

            if (isset($_REQUEST['StartDate']) && isset($_REQUEST['EndDate'])) {
                $search['StartDate'] = $_REQUEST['StartDate'];
                $search['EndDate'] = $_REQUEST['EndDate'];
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
            }

            if (isset($_REQUEST['OrderDate']) && !empty($_REQUEST['OrderDate']) && $_REQUEST['OrderDate'] != '00/00/0000') {
                $search['OrderDate'] = $_REQUEST['OrderDate'];
                $wh['DATE_FORMAT(ao.OrderDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['OrderDate']));
            }

            if (isset($_REQUEST['ShippedDate']) && !empty($_REQUEST['ShippedDate']) && $_REQUEST['ShippedDate'] != '00/00/0000') {
                $search['ShippedDate'] = $_REQUEST['ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['ShippedDate']));
            }
            
            if (isset($_REQUEST['end_ShippedDate']) && !empty($_REQUEST['end_ShippedDate']) && $_REQUEST['end_ShippedDate'] != '00/00/0000') {
                $search['end_ShippedDate'] = $_REQUEST['end_ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['end_ShippedDate']));
            }

            if (isset($_REQUEST['DeliveryDate']) && !empty($_REQUEST['DeliveryDate']) && $_REQUEST['DeliveryDate'] != '00/00/0000') {
                $search['DeliveryDate'] = $_REQUEST['DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") >='] = date('Y/m/d', strtotime($_REQUEST['DeliveryDate']));
            }

            if (isset($_REQUEST['end_DeliveryDate']) && !empty($_REQUEST['end_DeliveryDate']) && $_REQUEST['end_DeliveryDate'] != '00/00/0000') {
                $search['end_DeliveryDate'] = $_REQUEST['end_DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") <='] = date('Y/m/d', strtotime($_REQUEST['end_DeliveryDate']));
            }

            if (isset($_REQUEST['OrderedBy']) && !empty($_REQUEST['OrderedBy'])) {
                $search['OrderedBy'] = $_REQUEST['OrderedBy'];
                $wh['ao.ListedBy'] = $_REQUEST['OrderedBy'];
            }

            if (isset($_REQUEST['Status']) && !empty($_REQUEST['Status'])) {
                $search['Status'] = $_REQUEST['Status'];
                $wh['ao.OrderStatus'] = $_REQUEST['Status'];
            }
            
            $sortBy = 'desc';
            if (isset($_REQUEST['sortBy']) && !empty($_REQUEST['sortBy'])) {
                $search['sortBy'] = $_REQUEST['sortBy'];
                $sortBy = $_REQUEST['sortBy'];
                
            }

            $sortColumn = "ao.order_id";
            if (isset($_REQUEST['sortColumn']) && !empty($_REQUEST['sortColumn'])) {
                $search['sortColumn'] = $_REQUEST['sortColumn'];
                switch ($_REQUEST['sortColumn']) {
                    case '1':
                        $sortColumn = "ao.ASIN_NO";
                        break;
                    case '2':
                        $sortColumn = "storeName";
                        break;
                    case '3':
                        $sortColumn = "ao.order_id";
                        break;
                    case '4':
                        $sortColumn = "ao.BuyerName";
                        break;
                    case '5':
                        $sortColumn = "ao.Note";
                        break;
                    case '6':
                        $sortColumn = "ao.MerchantOrderID";
                        break;
                    // case '7':
                    //     $sortColumn = "Title";
                    //     break;
                    case '8':
                        $sortColumn = "ao.PurchaseDate";
                        break;
                    case '9':
                        $sortColumn = "ao.Lastupdate";
                        break;
                    default:
                        $sortColumn = "ao.order_id";
                        break;
                }
            }

            $params['ShortBy'] = $sortColumn;
            $params['ShortOrder'] = $sortBy;
    
            $totalRec = count($this->crud->get_join($join, $wh, $params));
            $posts = $this->crud->get_join($join, $wh, $params);
    
            // create file name
            $fileName = 'data-' . time() . '.xlsx';
            // load excel library
            $this->load->library('excel');
    
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            // set Header
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ASIN Number');
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Order ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Supplier Order ID');
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Note');
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'AMAZON TITLE');
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Purchase Date');
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'SKU');
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'SHIPMENT TRACKING #');
            $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'SHIPMENT TRACKING STATUS');
            $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'BUYER PAID');
            $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'ORDER TOTAL');
            $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'PURCHASE COST');
            $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'TOTAL PROFIT');
            $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'NET ROI');
            $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'STATUS');
            $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'LATE SHIPMENT');
            // set Row
            $rowCount = 2;
            $total_purchase_cost = 0;
            $total_profit = 0;
            $total_buyer_paid = 0;
            $buyer_profit = 0;
            
            foreach ($posts as $post) {
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
                    // echo "<pre>";
                    // print_r($order_item_arr); exit;
                    $orderitem_data = $order_item_arr['OrderItems'][0];
    
                }
                
                $amazon_fees = 0;
                $cal_profit = "0.00";
                $dis_roi_cal = "0.00 %";

                $buyer_amazon_fees = 0;
                $buyer_cal_profit = "0.00";
                $buyer_dis_roi_cal = "0.00";
                
                if ($post['OrderTotal__Amount'] != 0 && $post['PricePayed'] != 0) {
                    $amazon_fees = (0.15 * $post['OrderTotal__Amount']);
                    $price_diff = ($post['OrderTotal__Amount'] - $post['PricePayed']);
                    $cal_profit = round($price_diff - $amazon_fees, 2);
                    $dis_roi_cal = round($cal_profit / $post['PricePayed'] * 100, 2) . " %";

                    //Buyer paid
                    $buyer_amazon_fees = (0.15 * $orderitem_data['ItemPrice']['Amount']);
                    $buyer_price_diff = ($orderitem_data['ItemPrice']['Amount'] - $post['PricePayed']);
                    $buyer_cal_profit = round($buyer_price_diff - $buyer_amazon_fees, 2);
                    $buyer_dis_roi_cal = round($buyer_cal_profit / $post['PricePayed'] * 100, 2);
                }
    
                $total_purchase_cost += $post['PricePayed'];
                $total_profit += $cal_profit;
                $total_paid += is_numeric($post['OrderTotal__Amount']) ? $post['OrderTotal__Amount'] : 0;

                $buyerPaid = $orderitem_data['ItemPrice']['Amount'];
                $total_buyer_paid += is_numeric($buyerPaid) ? $buyerPaid : 0;
                $buyer_profit += $buyer_cal_profit;
    
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $orderitem_data['ASIN']);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $post['AmazonOrderId']);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $post['MerchantOrderID']);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $post['Note']);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $orderitem_data['Title']);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $post['PurchaseDateNew']);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $orderitem_data['SellerSKU']);
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $post['ShipmentTrackingNumber']);
                $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
                $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, CURR_SYMBOL . " " . $buyerPaid);
                $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, CURR_SYMBOL . " " . $post['OrderTotal__Amount']);
                $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, CURR_SYMBOL . " " . $post['PricePayed']);
                $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, CURR_SYMBOL . " " . $buyer_cal_profit);
                $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, $buyer_dis_roi_cal);
                $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, $post['OrderStatus']);
                $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, '');
                $rowCount++;
            }
    
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Total');
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, CURR_SYMBOL . " " . $total_buyer_paid);
            $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowCount, CURR_SYMBOL . " " . $total_paid);
            $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowCount, CURR_SYMBOL . " " . $total_purchase_cost);
            $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowCount, CURR_SYMBOL . " " . $buyer_profit);
            $objPHPExcel->getActiveSheet()->SetCellValue('N' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('O' . $rowCount, '');
            $objPHPExcel->getActiveSheet()->SetCellValue('P' . $rowCount, '');
    
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    
            //header("Content-Type: application/vnd.ms-excel");
    
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
            header("Content-Disposition: attachment; filename=" . $fileName);
            header("Cache-Control: max-age=0");
            $objWriter->save("php://output");
            redirect(ADMIN . 'manage-amazon-order');
        }

        redirect(ADMIN . 'manage-amazon-order');
    }

    public function export_pdf()
    {
        error_reporting(E_ERROR | E_PARSE);
        require_once 'application/libraries/vendor/autoload.php';
        
        $join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, DATE_FORMAT(ao.Lastupdate, "%m/%d/%Y") as Lastupdate, ao.*, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(OrderItems, "{\'", "{\""), "\':", "\":"), ": \'", ": \""), "\', \'", "\", \""), "\'}", "\"}"), ", \'", ", \""), "\'", "") as OrderItems, (SELECT name from store as s WHERE s.AmazonSellerId = ao.AmazonSellerId Limit 1) as storeName';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';
        
        $userstores = $this->crud->get_row_by_id('tbl_users', ' id = ' . $this->session->userdata('userId') . '');
        
        if (!empty($userstores) && !empty($userstores['store_id'])) {
            if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
                $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
                
                $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
    
            } else {
                if($userstores['roleId'] == 1 || $userstores['roleId'] == 2){
                    $wh = array("ao.isDelete" => '0');                
                }else{
                    $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
    
                    if (!empty($active_store['AmazonSellerId'])) {
                        $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
                    } else {
                        $storeID = implode(', ', explode(',', $userstores['store_id']));
                        $stores = $this->crud->getFromSQL("SELECT store.AmazonSellerId FROM `store` WHERE  `isDelete` = 0 AND store.id IN (".$storeID.")");
                        
                        $sellerId = [];
                        foreach ($stores as $key => $value) {
                            $sellerId[] = $value->AmazonSellerId;
                        }
                        $params['in_field'] = 'ao.AmazonSellerId';
                        $params['in_value'] = $sellerId;
                        $wh['ao.isDelete'] = '0';
                    }
                }
    
            }
    
            if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
                $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
                $search['OrdersType'] = $_REQUEST['OrdersType'];
            }

            if (isset($_REQUEST['SearchTerm'])) {
                $SearchTerm = $_REQUEST['SearchTerm'];
                $search['SearchTerm'] = $_REQUEST['SearchTerm'];
            }

            if (!empty($SearchTerm)) {
                $params['like'] = array('ao.AmazonOrderId' => $SearchTerm, "ao.BuyerEmail" => $SearchTerm, "ao.OrderItems" => $SearchTerm,"ao.BuyerName"=> $SearchTerm);
            }

            if (isset($_REQUEST['SearchNote']) && !empty($_REQUEST['SearchNote'])) {
                $params['like'] = array('ao.Note' => $_REQUEST['SearchNote']);
            }

            if (isset($_REQUEST['StartDate']) && isset($_REQUEST['EndDate'])) {
                $search['StartDate'] = $_REQUEST['StartDate'];
                $search['EndDate'] = $_REQUEST['EndDate'];
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
            }

            if (isset($_REQUEST['OrderDate']) && !empty($_REQUEST['OrderDate']) && $_REQUEST['OrderDate'] != '00/00/0000') {
                $search['OrderDate'] = $_REQUEST['OrderDate'];
                $wh['DATE_FORMAT(ao.OrderDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['OrderDate']));
            }

            if (isset($_REQUEST['ShippedDate']) && !empty($_REQUEST['ShippedDate']) && $_REQUEST['ShippedDate'] != '00/00/0000') {
                $search['ShippedDate'] = $_REQUEST['ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['ShippedDate']));
            }
            
            if (isset($_REQUEST['end_ShippedDate']) && !empty($_REQUEST['end_ShippedDate']) && $_REQUEST['end_ShippedDate'] != '00/00/0000') {
                $search['end_ShippedDate'] = $_REQUEST['end_ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['end_ShippedDate']));
            }

            if (isset($_REQUEST['DeliveryDate']) && !empty($_REQUEST['DeliveryDate']) && $_REQUEST['DeliveryDate'] != '00/00/0000') {
                $search['DeliveryDate'] = $_REQUEST['DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") >='] = date('Y/m/d', strtotime($_REQUEST['DeliveryDate']));
            }

            if (isset($_REQUEST['end_DeliveryDate']) && !empty($_REQUEST['end_DeliveryDate']) && $_REQUEST['end_DeliveryDate'] != '00/00/0000') {
                $search['end_DeliveryDate'] = $_REQUEST['end_DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") <='] = date('Y/m/d', strtotime($_REQUEST['end_DeliveryDate']));
            }

            if (isset($_REQUEST['OrderedBy']) && !empty($_REQUEST['OrderedBy'])) {
                $search['OrderedBy'] = $_REQUEST['OrderedBy'];
                $wh['ao.ListedBy'] = $_REQUEST['OrderedBy'];
            }

            if (isset($_REQUEST['Status']) && !empty($_REQUEST['Status'])) {
                $search['Status'] = $_REQUEST['Status'];
                $wh['ao.OrderStatus'] = $_REQUEST['Status'];
            }
            
            $sortBy = 'desc';
            if (isset($_REQUEST['sortBy']) && !empty($_REQUEST['sortBy'])) {
                $search['sortBy'] = $_REQUEST['sortBy'];
                $sortBy = $_REQUEST['sortBy'];
                
            }

            $sortColumn = "ao.order_id";
            if (isset($_REQUEST['sortColumn']) && !empty($_REQUEST['sortColumn'])) {
                $search['sortColumn'] = $_REQUEST['sortColumn'];
                switch ($_REQUEST['sortColumn']) {
                    case '1':
                        $sortColumn = "ao.ASIN_NO";
                        break;
                    case '2':
                        $sortColumn = "storeName";
                        break;
                    case '3':
                        $sortColumn = "ao.order_id";
                        break;
                    case '4':
                        $sortColumn = "ao.BuyerName";
                        break;
                    case '5':
                        $sortColumn = "ao.Note";
                        break;
                    case '6':
                        $sortColumn = "ao.MerchantOrderID";
                        break;
                    // case '7':
                    //     $sortColumn = "Title";
                    //     break;
                    case '8':
                        $sortColumn = "ao.PurchaseDate";
                        break;
                    case '9':
                        $sortColumn = "ao.Lastupdate";
                        break;
                    default:
                        $sortColumn = "ao.order_id";
                        break;
                }
            }

            $params['ShortBy'] = $sortColumn;
            $params['ShortOrder'] = $sortBy;
            
            $posts = $this->crud->get_join($join, $wh, $params);
    
            $html = '<!DOCTYPE html>
                    <html lang="en">
                        <head>
                        <meta charset="utf-8">
                        <title>Amazon Order Report</title>
                        <style>
                            body {
                                margin: 0 auto;
                                color: #001028;
                                background: #FFFFFF;
                                font-family: Arial, sans-serif;
                                font-size: 12px;
                            }
    
                            table {
                                width: 100%;
                                border-collapse: collapse;
                                border-spacing: 0;
                            }
    
                            table tr:nth-child(2n-1) td {
                                background: #F5F5F5;
                            }
    
                            table th,
                            table td {
                                text-align: center;
                            }
    
                            table th {
                                padding: 10px 20px;
                                color: #5D6975;
                                white-space: nowrap;
                                font-weight: normal;
                            }
    
                            table td {
                                padding: 15px;
                                text-align: center;
                            }
                        </style>
                        </head>
                        <body>
                            <main>
                                <table style="border: 1px solid #C1CED9;">
                                    <thead>
                                        <tr style="border: 1px solid #C1CED9;">
                                            <th>ASIN Number</th>
                                            <th>Order ID</th>
                                            <th>Supplier Order ID</th>
                                            <th>Note</th>
                                            <th>AMAZON TITLE</th>
                                            <th>Purchase Date</th>
                                            <th>SKU</th>
                                            <th>SHIPMENT TRACKING #</th>
                                            <th>SHIPMENT TRACKING STATUS</th>
                                            <th>BUYER PAID</th>
                                            <th>PURCHASE COST</th>
                                            <th>TOTAL PROFIT</th>
                                            <th>NET ROI</th>
                                            <th>STATUS</th>
                                            <th>LATE SHIPMENT</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
    
            $total_purchase_cost = 0;
            $total_profit = 0;
            $total_buyer_paid = 0;
            $buyer_profit = 0;
            
            if (!empty($posts)) {
                foreach ($posts as $post) {
    
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
    
                    // $order_item = $this->crud->fixJSON( $order_item );
                    // $order_item_arr = json_decode($order_item, true);
    
                    // $orderitem_data = $order_item_arr[0]['OrderItem'];
                    
                    $amazon_fees = 0;
                    $cal_profit = "0.00";
                    $dis_roi_cal = "0.00 %";

                    $buyer_amazon_fees = 0;
                    $buyer_cal_profit = "0.00";
                    $buyer_dis_roi_cal = "0.00";
                    if ($post['OrderTotal__Amount'] != 0 && $post['PricePayed'] != 0) {
                        //Total order
                        $amazon_fees = (0.15 * $post['OrderTotal__Amount']);
                        $price_diff = ($post['OrderTotal__Amount'] - $post['PricePayed']);
                        $cal_profit = round($price_diff - $amazon_fees, 2);
                        $dis_roi_cal = round($cal_profit / $post['PricePayed'] * 100, 2) . " %";

                        //Buyer paid
                        $buyer_amazon_fees = (0.15 * $orderitem_data['ItemPrice']['Amount']);
                        $buyer_price_diff = ($orderitem_data['ItemPrice']['Amount'] - $post['PricePayed']);
                        $buyer_cal_profit = round($buyer_price_diff - $buyer_amazon_fees, 2);
                        $buyer_dis_roi_cal = round($buyer_cal_profit / $post['PricePayed'] * 100, 2);
                    }
    
                    $total_purchase_cost += $post['PricePayed'];
                    $total_profit += $cal_profit;
                    $total_paid += $post['OrderTotal__Amount'];

                    $buyerPaid = $orderitem_data['ItemPrice']['Amount'];
                    $total_buyer_paid += is_numeric($buyerPaid) ? $buyerPaid : 0;
                    $buyer_profit += $buyer_cal_profit;
    
                    $html .= '<tr style="border: 1px solid #C1CED9;">
                                    <td>' . $orderitem_data['ASIN'] . '</td>
                                    <td>' . $post['AmazonOrderId'] . '</td>
                                    <td>' . $post['MerchantOrderID'] . '</td>
                                    <td>' . $post['Note'] . '</td>
                                    <td><div class="d-flex align-items-center "><i class="fas fa-envelope mr-2"></i> <p>' . $orderitem_data['Title'] . '</p></div></td>
                                    <td>' . $post['PurchaseDateNew'] . '</td>
                                    <td>' . $orderitem_data['SellerSKU'] . '</td>
                                    <td>' . $post['ShipmentTrackingNumber'] . '</td>
                                    <td></td>
                                    <td>' . CURR_SYMBOL . " " . $buyerPaid . '</td>
                                    <td>' . CURR_SYMBOL . " " . $post['OrderTotal__Amount'] . '</td>
                                    <td>' . CURR_SYMBOL . " " . $post['PricePayed'] . '</td>
                                    <td>' . CURR_SYMBOL . " " . $buyer_cal_profit . '</td>
                                    <td>' . $buyer_dis_roi_cal . '</td>
                                    <td>' . $post['OrderStatus'] . '</td>
                                    <td></td>
                                </tr>';
    
                }
    
                $html .= '<tr>
                            <td><b>Total</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>' . CURR_SYMBOL . " " . $total_buyer_paid . '</b></td>
                            <td><b>' . CURR_SYMBOL . " " . $total_paid . '</b></td>
                            <td><b>' . CURR_SYMBOL . " " . $total_purchase_cost . '</b></td>
                            <td><b>' . CURR_SYMBOL . " " . $buyer_profit . '</b></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>';
            } else {
                $html .= '<tr>
                            <td colspan="15">
                                There are currently no amazon orders to show.
                            </td>
                        </tr>';
            }
            $html .= '</tbody>
                                </table>
                            </main>
                        </body>
                    </html>';
    
            //echo $html;die();
            $mpdf = new mPDF();
            $mpdf->SetDisplayMode('fullpage');
            // $mpdf->defaultfooterfontstyle='';
            // $mpdf->defaultfooterfontsize=12;
            // $mpdf->defaultfooterline=0;
            // $mpdf->setFooter('{PAGENO}');
            $mpdf->WriteHTML($html);
            $pdf_name = "Amazon Order Report" . ".pdf";
            $mpdf->Output($pdf_name, 'D');
            exit;
        }
        $this->session->set_flashdata('error', 'There are currently no amazon orders to show.');
        redirect(ADMIN.'manage-amazon-order');
    }

    public function ajaxPaginationData()
    {
        $params = array();
        $page = $this->input->post('page');
        
        if (!$page) {$offset = 0;} else { $offset = $page;}

        $perpage = $this->input->post('perpage');
        $this->perPage = $perpage;
        $search['OrdersType'] = $this->perPage;

        $join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, DATE_FORMAT(ao.Lastupdate, "%m/%d/%Y") as Lastupdate, ao.*, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(OrderItems, "{\'", "{\""), "\':", "\":"), ": \'", ": \""), "\', \'", "\", \""), "\'}", "\"}"), ", \'", ", \""), "\'", "") as OrderItems, (SELECT name from store as s WHERE s.AmazonSellerId = ao.AmazonSellerId Limit 1) as storeName';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';

        //$wh = array("ao.isDelete" => '0','ao.AmazonOrderId' => '113-0136548-0674656');
        
        $userstores = $this->crud->get_row_by_id('tbl_users', ' id = ' . $this->session->userdata('userId') . '');
        
        $wh = [];
        $params = [];
        $data = [];
        if (!empty($userstores) && !empty($userstores['store_id'])) {
            if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
                $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
                
                $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
    
            } else {
                if($userstores['roleId'] == 1 || $userstores['roleId'] == 2){
                    $wh = array("ao.isDelete" => '0');                
                }else{
                    $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');
    
                    if (!empty($active_store['AmazonSellerId'])) {
                        $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);
                    } else {
                        $storeID = implode(', ', explode(',', $userstores['store_id']));
                        $stores = $this->crud->getFromSQL("SELECT store.AmazonSellerId FROM `store` WHERE  `isDelete` = 0 AND store.id IN (".$storeID.")");
                        
                        $sellerId = [];
                        foreach ($stores as $key => $value) {
                            $sellerId[] = $value->AmazonSellerId;
                        }
                        $params['in_field'] = 'ao.AmazonSellerId';
                        $params['in_value'] = $sellerId;
                        $wh['ao.isDelete'] = '0';
                    }
                }
    
            }
    
            if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
                $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
                $search['OrdersType'] = $_REQUEST['OrdersType'];
            }
    
            if (isset($_REQUEST['SearchTerm'])) {
                $SearchTerm = $_REQUEST['SearchTerm'];
                $search['SearchTerm'] = $_REQUEST['SearchTerm'];
            }
    
            if (!empty($SearchTerm)) {
                $params['like'] = array('ao.AmazonOrderId' => $SearchTerm, "ao.BuyerEmail" => $SearchTerm, "ao.OrderItems" => $SearchTerm,"ao.BuyerName"=> $SearchTerm);
            }
    
            if (isset($_REQUEST['SearchNote']) && !empty($_REQUEST['SearchNote'])) {
                $params['like'] = array('ao.Note' => $_REQUEST['SearchNote']);
            }
    
            if (!empty($_REQUEST['StartDate']) && !empty($_REQUEST['EndDate'])) {
                $search['StartDate'] = $_REQUEST['StartDate'];
                $search['EndDate'] = $_REQUEST['EndDate'];
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
                $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
            }
    
            if (isset($_REQUEST['OrderDate']) && !empty($_REQUEST['OrderDate']) && $_REQUEST['OrderDate'] != '00/00/0000') {
                $search['OrderDate'] = $_REQUEST['OrderDate'];
                $wh['DATE_FORMAT(ao.OrderDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['OrderDate']));
            }
    
            if (isset($_REQUEST['ShippedDate']) && !empty($_REQUEST['ShippedDate']) && $_REQUEST['ShippedDate'] != '00/00/0000') {
                $search['ShippedDate'] = $_REQUEST['ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['ShippedDate']));
            }
            
            if (isset($_REQUEST['end_ShippedDate']) && !empty($_REQUEST['end_ShippedDate']) && $_REQUEST['end_ShippedDate'] != '00/00/0000') {
                $search['end_ShippedDate'] = $_REQUEST['end_ShippedDate'];
                $wh['DATE_FORMAT(ao.shipment_date, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['end_ShippedDate']));
            }
    
            if (isset($_REQUEST['DeliveryDate']) && !empty($_REQUEST['DeliveryDate']) && $_REQUEST['DeliveryDate'] != '00/00/0000') {
                $search['DeliveryDate'] = $_REQUEST['DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") >='] = date('Y/m/d', strtotime($_REQUEST['DeliveryDate']));
            }
    
            if (isset($_REQUEST['end_DeliveryDate']) && !empty($_REQUEST['end_DeliveryDate']) && $_REQUEST['end_DeliveryDate'] != '00/00/0000') {
                $search['end_DeliveryDate'] = $_REQUEST['end_DeliveryDate'];
                $wh['DATE_FORMAT(ao.EarliestDeliveryDate, "%Y/%m/%d") <='] = date('Y/m/d', strtotime($_REQUEST['end_DeliveryDate']));
            }
    
            if (isset($_REQUEST['OrderedBy']) && !empty($_REQUEST['OrderedBy'])) {
                $search['OrderedBy'] = $_REQUEST['OrderedBy'];
                $wh['ao.ListedBy'] = $_REQUEST['OrderedBy'];
            }
    
            if (isset($_REQUEST['Status']) && !empty($_REQUEST['Status'])) {
                $search['Status'] = $_REQUEST['Status'];
                $wh['ao.OrderStatus'] = $_REQUEST['Status'];
            }
            
            $sortBy = 'desc';
            if (isset($_REQUEST['sortBy']) && !empty($_REQUEST['sortBy'])) {
                $search['sortBy'] = $_REQUEST['sortBy'];
                $sortBy = $_REQUEST['sortBy'];
                
            }

            $sortColumn = "ao.PurchaseDate";
            if (isset($_REQUEST['sortColumn']) && !empty($_REQUEST['sortColumn'])) {
                $search['sortColumn'] = $_REQUEST['sortColumn'];
                switch ($_REQUEST['sortColumn']) {
                    case '1':
                        $sortColumn = "ao.ASIN_NO";
                        break;
                    case '2':
                        $sortColumn = "storeName";
                        break;
                    case '3':
                        $sortColumn = "ao.order_id";
                        break;
                    case '4':
                        $sortColumn = "ao.BuyerName";
                        break;
                    case '5':
                        $sortColumn = "ao.Note";
                        break;
                    case '6':
                        $sortColumn = "ao.MerchantOrderID";
                        break;
                    // case '7':
                    //     $sortColumn = "Title";
                    //     break;
                    case '8':
                        $sortColumn = "ao.PurchaseDate";
                        break;
                    case '9':
                        $sortColumn = "ao.Lastupdate";
                        break;
                    default:
                        $sortColumn = "ao.order_id";
                        break;
                }
            }

            $params['ShortBy'] = $sortColumn;
            $params['ShortOrder'] = $sortBy;
            
            $totalRec = count($this->crud->get_join($join, $wh, $params));
            $config['target'] = '#resultList';
            $config['base_url'] = base_url() . 'admin/AmazonOrderController/ajaxPaginationData';
            $config['total_rows'] = $totalRec;
            $config['per_page'] = $this->perPage;
            $config['uri_segment'] = 4;
            $config['link_func'] = "searchFilter";
    
            $this->ajax_pagination->initialize($config);
            $data['all_total_details'] = $this->crud->get_join($join, $wh, $params);
    
            $params['start'] = $offset;
            $params['Limit'] = $this->perPage;
            $data['posts'] = $this->crud->get_join($join, $wh, $params);
        }
        
        $this->session->set_userdata('filter_data', $search);
        $this->load->view(ADMIN . "amazon_order_ajax_data", $data);
    }
    
    function anydeskData()
    {
        $this->isLoggedIn();
        if ($this->loggedInUserRole() == 1) {
            $this->global['pageTitle'] = ' : Manage AnyDesk Credentials';
            $this->loadViews(ADMIN . "excel_import", $this->global, null);
        }
        echo "You are not admin!";
    }

    public function ajaxAnyDeskPaginationData()
    {
        $data['anyDeskDatas'] = $this->crud->get_all_records('anydesk_credentials', 'id', 'ASC');
    
        $this->load->view(ADMIN . "anydesk_ajax_data", $data);
    }

    public function store()
    {
        $post = $this->input->post();
        $type = $post['type'];
        $this->form_validation->set_rules('PricePayed', 'PricePayed', 'trim');
        $this->form_validation->set_rules('MerchantOrderID', 'MerchantOrderID', 'trim');
        $this->form_validation->set_rules('LastFourDigitsofCCInUsed', 'LastFourDigitsofCCInUsed', 'trim');
        $this->form_validation->set_rules('ShipmentTrackingNumber', 'ShipmentTrackingNumber', 'trim');
        $this->form_validation->set_rules('ShipmentCarrierFormat', 'ShipmentCarrierFormat', 'trim');
        $this->form_validation->set_rules('TrackingNumber', 'TrackingNumber', 'trim');
        $this->form_validation->set_rules('CarrierFormat', 'CarrierFormat', 'trim');
        $this->form_validation->set_rules('RMANumber', 'RMANumber', 'trim');
        $this->form_validation->set_rules('BuyerRefund', 'BuyerRefund', 'trim');
        $this->form_validation->set_rules('SupplierRefunded', 'SupplierRefunded', 'trim');
        $this->form_validation->set_rules('AmazonFeeKept', 'AmazonFeeKept', 'trim');
        $this->form_validation->set_rules('ListedBy', 'ListedBy', 'trim');
        $this->form_validation->set_rules('OrderStatus', 'OrderStatus', 'trim');
        $this->form_validation->set_rules('ModalOrderChildStatus', 'ModalOrderChildStatus', 'trim');
        $this->form_validation->set_rules('Note', 'Note', 'trim');

        $PricePayed = $post['PricePayed'];
        $MerchantOrderID = $post['MerchantOrderID'];
        $LastFourDigitsofCCInUsed = $post['LastFourDigitsofCCInUsed'];
        $ShipmentTrackingNumber = $post['ShipmentTrackingNumber'];
        $ShipmentCarrierFormat = $post['ShipmentCarrierFormat'];
        $TrackingNumber = $post['TrackingNumber'];
        $CarrierFormat = $post['CarrierFormat'];
        $shipment_date = $post['shipment_date'];
        $RMANumber = $post['RMANumber'];
        $BuyerRefund = $post['BuyerRefund'];
        $SupplierRefunded = $post['SupplierRefunded'];
        $AmazonFeeKept = $post['AmazonFeeKept'];
        $ListedBy = $post['ListedBy'];
        $OrderStatus = $post['OrderStatus'];
        $ModalOrderChildStatus = $post['ModalOrderChildStatus'];
        $BuyerName = $post['BuyerName'];
        $Note = $post['Note'];

        $arshipment_date = explode('/', $shipment_date);
        $shipment_date = $arshipment_date[2] . '-' . $arshipment_date[0] . '-' . $arshipment_date[1];

        if ($post['OrderStatus'] == "Canceled") {
            $reason_cancel = $post['reason_cancel'];
        } else {
            $reason_cancel = "";
        }

        if ($post['RMANumber'] != '' || $post['BuyerRefund'] != 0 || $post['SupplierRefunded'] != 0 || $post['AmazonFeeKept'] != 0) {
            $RefundReason = $post['RefundReason'];
        } else {
            $RefundReason = "";
        }

        //$ListedBy = 0;
        if ($post['PricePayed'] != $this->session->userdata('PricePayed')) {
            $ListedBy = $this->session->userdata('userId');
            $OrderDate = date("Y-m-d h:i:s");
        }
        //$this->session->unset_userdata('PricePayed');

        $shippedby_id = 0;
        if ($post['ShipmentTrackingNumber'] != $this->session->userdata('ShipmentTrackingNumber')) {
            $shippedby_id = $this->session->userdata('userId');
        }
        $this->session->unset_userdata('ShipmentTrackingNumber');
        if ($this->form_validation->run() == false) {
            $this->showform();
        } else {
            $fieldInfo = array(
                'PricePayed' => $PricePayed,
                'MerchantOrderID' => $MerchantOrderID,
                'LastFourDigitsofCCInUsed' => $LastFourDigitsofCCInUsed,
                'ShipmentTrackingNumber' => $ShipmentTrackingNumber,
                'ShipmentCarrierFormat' => $ShipmentCarrierFormat,
                'TrackingNumber' => $TrackingNumber,
                'CarrierFormat' => $CarrierFormat,
                'shipment_date' => $shipment_date,
                'RMANumber' => $RMANumber,
                'BuyerRefund' => $BuyerRefund,
                'SupplierRefunded' => $SupplierRefunded,
                'AmazonFeeKept' => $AmazonFeeKept,
                'RefundReason' => $RefundReason,
                'ListedBy' => $ListedBy,
                'OrderStatus' => $OrderStatus,
                'reason_cancel' => $reason_cancel,
                'ModalOrderChildStatus' => $ModalOrderChildStatus,
                'Note' => $Note,
                'Lastupdate' => date("Y-m-d h:i:s"),
                'LastupdateBy' => $this->session->userdata('userId'),
                "BuyerName" => $BuyerName,
                'shippedby_id' => $shippedby_id,
            );

            if ($post['PricePayed'] != $this->session->userdata('PricePayed')) {
                $fieldInfo['OrderDate'] = $OrderDate;
            }
            
            if ($OrderStatus == 'Canceled' && $reason_cancel == 'Buyer Cancelled') {
                $fieldInfo['isDelete'] = 1;
            }
            
            $this->session->unset_userdata('PricePayed');

            if ($type == "add") {
                //$insert_result = $this->crud->insert($this->table,$fieldInfo);
            }

            if ($type == "edit") {
                $editid = $this->input->post('editid');
                $where_array = array('order_id' => $editid);
                $update_result = $this->crud->update($this->table, $fieldInfo, $where_array);
                if ($reason_cancel == "Buyer Cancelled") {
                    $amazoneOrder = $this->crud->getFromSQL("SELECT AmazonOrderId FROM `amazon_orders` WHERE `order_id` = ".$editid."");
                    $amazoneOrder = $amazoneOrder[0]->AmazonOrderId;
                    $check_duplicate = $this->crud->check_duplicate('buyer_cancelled_orders', array('AmazonOrderId' => $amazoneOrder));
                    if (!empty($amazoneOrder) && !$check_duplicate) {
                        $array = ['AmazonOrderId' => $amazoneOrder];
                        $this->crud->insert('buyer_cancelled_orders', $array);
                    }
                }
            }

            if ($insert_result > 0) {
                $this->session->set_flashdata('success', 'Details inserted successfully');
            } else if ($update_result > 0) {
                $this->session->set_flashdata('success', 'Details updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Something went wrong.');
            }

            redirect(ADMIN . 'manage-amazon-order');
        }
    }

    public function getOrderfromAmazon($AmazonSellerId = "")
    {
        $post = $this->input->post();
        $post['AmazonSellerId'] = isset($AmazonSellerId) ? $AmazonSellerId : "";
        $post['OrderDate'] = strtotime($post['PurchaseDate']);
        $AmazonOrderId = $post['AmazonOrderId'];
        $check_duplicate = $this->crud->check_duplicate($this->table, array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
        
        if ($check_duplicate) {
            $where_array = array('AmazonOrderId' => $AmazonOrderId);
            $update_result = $this->crud->update($this->table, $post, $where_array);
        } else {
            $insert_result = $this->crud->insert($this->table, $post);
        }
    }

    public function getASINRecord()
    {
        error_reporting(0);
        $post = $this->input->post();
        $asin = $post['asin'];

        if (isset($asin) && $asin != "") {
            $generate_url = 'https://www.amazon.com/gp/aod/ajax/ref=dp_aod_NEW_mbc?asin=' . $asin . '&m=&pinnedofferhash=&qid=&smid=&sourcecustomerorglistid=&sourcecustomerorglistitemid=&sr=&pc=dp';

            //$generate_url = 'https://www.amazon.com/gp/aod/ajax/ref=dp_aod_NEW_mbc?asin=B00JDACK3S&m=&pinnedofferhash=&qid=&smid=&sourcecustomerorglistid=&sourcecustomerorglistitemid=&sr=&pc=dp';

            $generate_url = myCleanData($generate_url);
            $html = file_get_html($generate_url);

            if ($html != "") {
                ?>
                <h3><?php echo $html->find('div#all-offers-display-scroller h5#aod-asin-title-text')[0]->plaintext . " (Total other seller :- " . $html->find('#aod-total-offer-count')[0]->value . " )"; ?></h3>
                <?php
        $per_page = 10;
                        $total_page = ceil($html->find('#aod-total-offer-count')[0]->value / $per_page);
                        //echo "Total page :- ".$total_page."<br>";
                        ?>
                        <table class="table table-responsive" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th width="20%">Price</th>
                                    <th width="30%">Sold By</th>
                                    <th width="20%">Delivery Fees</th>
                                    <th width="30%">Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?=$html->find('span.a-offscreen')[0]->plaintext;?></td>
                                    <td><?=$html->find('div.a-fixed-left-grid-col.a-col-right .a-size-small.a-link-normal')[0]->plaintext;?></td>
                                    <td><?=$html->find('div#delivery-message')[0]->plaintext;?></td>
                                    <td><?=$html->find('div#aod-asin-reviews span#aod-asin-reviews-count-title')[0]->plaintext?></td>
                                </tr>
                                <?php
        for ($i = 1; $i <= $total_page; $i++) {
                            $url = $generate_url . '&pageno=' . $i;

                            $html = file_get_html($url);
                            foreach ($html->find('div#aod-offer') as $e1) {
                                $price = $e1->find('span.a-offscreen')[0]->plaintext;
                                $sold_by = $e1->find('a.a-size-small.a-link-normal')[0]->plaintext;
                                //$delivery_fees = $e1->find('span.a-color-secondary.a-size-base')[0]->plaintext;
                                $delivery_fees = $e1->find('div#delivery-message')[0]->plaintext;
                                $rating = $e1->find('div#aod-offer-seller-rating span#seller-rating-count-{iter}')[0]->plaintext;
                                ?>
                                        <tr>
                                            <td><?=$price;?></td>
                                            <td><?=$sold_by;?></td>
                                            <td><?=$delivery_fees;?></td>
                                            <td><?=$rating;?></td>
                                        </tr>
                                        <?php
        }
                }
                ?>
                    </tbody>
                </table>
                <?php
        }
        }
    }

    public function last_update()
    {
        $post = $this->input->post();
        $order_id = $post['order_id'];

        $where_array = array('order_id' => $order_id);
        $rows = array(
            'Lastupdate' => date('Y-m-d'),
            'LastupdateBy' => $this->session->userdata('userId'),
        );
        $update_result = $this->crud->update($this->table, $rows, $where_array);
        // echo $this->db->last_query();
        // die();
    }

    public function notifiy()
    {
        $post = $this->input->post();
        $post['notify_email'] = json_encode($post['notify_email']);
        $insert_result = $this->crud->insert('email_notify', $post);
    }
    
    public function displayDates($date1, $date2, $format = 'Y-m-d' ) {
        $dates = array();
        $current = strtotime($date1);
        $date2 = strtotime($date2);
        $stepVal = '+1 day';
        while( $current <= $date2 ) {
            $nextDay = strtotime($stepVal, $current);

            $dates[] = [date($format, $current), date($format, $nextDay)];
            $current = strtotime($stepVal, $current);
        }
      return $dates;
   }
    
    public function getMissingOrders()
    {
        $this->isLoggedIn();
        error_reporting(0);
        ini_set('max_execution_time', 0);

        $stores = ['A2WQNCO1Z1UMKI'];
        foreach ($stores as $store) {
            $stores_data = $this->crud->getFromSQL("SELECT * FROM `store` WHERE `status` = 'Y' AND `isDelete` = 0 AND `AmazonSellerId` != '' AND `refresh_token` != '' AND `client_id` != '' AND `client_secret` != '' AND AmazonSellerId = '".$store."' ORDER BY `name` ASC");
            
            if (isset($stores_data[0])) {
                $stores_data = $stores_data[0];
            }

            $store = $stores_data;
            $sellerid = $store->AmazonSellerId;
            $refresh_token = $store->refresh_token;
            $client_id = $store->client_id;
            $client_secret = $store->client_secret;

            $config = [
                //Guzzle configuration
                'http' => [
                    'verify' => false, //<--- NOT SAFE FOR PRODUCTION
                    //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
                ],

                //LWA: Keys needed to obtain access token from Login With Amazon Service
                'refresh_token' => $refresh_token,
                'client_id' => $client_id,
                'client_secret' => $client_secret,

                //STS: Keys of the IAM role which are needed to generate Secure Session
                // (a.k.a Secure token) for accessing and assuming the IAM role
                'access_key' => 'AKIATJORSRJFWPH7Z4A3',
                'secret_key' => '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',
                'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

                //API: Actual configuration related to the SP API :)
                'region' => 'us-east-1',
                'host' => 'sellingpartnerapi-na.amazon.com',
            ];

            file_put_contents("aws-tokens", "");
            //Create token storage which will store the temporary tokens
            $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

            //Create the request signer which will be automatically used to sign all of the
            //requests to the API
            $signer = new DoubleBreak\Spapi\Signer();

            //Create Credentials service and call getCredentials() to obtain
            //all the tokens needed under the hood

            $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
            $cred = $credentials->getCredentials();

            $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);
            
            $dates = $this->displayDates('2021-10-01', '2021-10-21');
            
            foreach ($dates as $key => $date) {
                $result = $reportClient->getOrders([
                    'MarketplaceIds' => 'A2EUQ1WTGCTBG2,ATVPDKIKX0DER,A1AM78C64UM0Y8,A2Q3Y263D00KWC',
                    'CreatedAfter' => $date[0],
                    'CreatedBefore' => $date[1]
                ]);
                $data = json_encode($result);
                $date = json_encode($dates[$key]);
                echo '<pre>'; print_r($date); echo '</pre>';
                echo '<pre>'; print_r($data); echo '</pre>';
                echo '<pre>'; print_r('Total Order = '.count($result['payload']['Orders'])); echo '</pre>';
                $curron_count = 1;
                foreach ($result['payload']['Orders'] as $ke => $order) {

                    $AmazonOrderId = $order['AmazonOrderId'];
                    $check_duplicate = $this->crud->check_duplicate('amazon_orders_backup', array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
                    // $check_duplicate1 = $this->crud->check_duplicate('amazon_orders', array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
                    if (!$check_duplicate) {

                        $order_d = $reportClient->getOrder($AmazonOrderId);
                        $buyer_d = $reportClient->getOrderBuyerInfo($AmazonOrderId);
                        $address_d = $reportClient->getOrderAddress($AmazonOrderId);
                        $order_item = $reportClient->getOrderItems($AmazonOrderId);

                        unset($order_item['payload']['AmazonOrderId']);
                        $AmazonSellerId = isset($sellerid) ? $sellerid : "";
                        $AmazonOrderId = isset($AmazonOrderId) ? $AmazonOrderId : "";
                        $BuyerEmail = isset($buyer_d['payload']['BuyerEmail']) ? $buyer_d['payload']['BuyerEmail'] : "";
                        $DefaultShipFromLocationAddress__AddressLine1 = isset($order_d['payload']['DefaultShipFromLocationAddress']['AddressLine1']) ? $order_d['payload']['DefaultShipFromLocationAddress']['AddressLine1'] : "";
                        $DefaultShipFromLocationAddress__AddressLine3 = isset($order_d['payload']['DefaultShipFromLocationAddress']['AddressLine2']) ? $order_d['payload']['DefaultShipFromLocationAddress']['AddressLine2'] : "";
                        $DefaultShipFromLocationAddress__City = isset($order_d['payload']['DefaultShipFromLocationAddress']['City']) ? $order_d['payload']['DefaultShipFromLocationAddress']['City'] : "";
                        $DefaultShipFromLocationAddress__CountryCode = isset($order_d['payload']['DefaultShipFromLocationAddress']['CountryCode']) ? $order_d['payload']['DefaultShipFromLocationAddress']['CountryCode'] : "";
                        $DefaultShipFromLocationAddress__Name = isset($order_d['payload']['DefaultShipFromLocationAddress']['Name']) ? $order_d['payload']['DefaultShipFromLocationAddress']['Name'] : "";
                        $DefaultShipFromLocationAddress__Phone = isset($order_d['payload']['DefaultShipFromLocationAddress']['Phone']) ? $order_d['payload']['DefaultShipFromLocationAddress']['Phone'] : "";
                        $DefaultShipFromLocationAddress__PostalCode = isset($order_d['payload']['DefaultShipFromLocationAddress']['PostalCode']) ? $order_d['payload']['DefaultShipFromLocationAddress']['PostalCode'] : "";
                        $DefaultShipFromLocationAddress__StateOrRegion = isset($order_d['payload']['DefaultShipFromLocationAddress']['StateOrRegion']) ? $order_d['payload']['DefaultShipFromLocationAddress']['StateOrRegion'] : "";
                        $DefaultShipFromLocationAddress__isAddressSharingConfidential = isset($order_d['payload']['DefaultShipFromLocationAddress']['isAddressSharingConfidential']) ? $order_d['payload']['DefaultShipFromLocationAddress']['isAddressSharingConfidential'] : "";
                        $EarliestDeliveryDate = isset($order_d['payload']['EarliestDeliveryDate']) ? $order_d['payload']['EarliestDeliveryDate'] : "";
                        $EarliestShipDate = isset($order_d['payload']['EarliestShipDate']) ? $order_d['payload']['EarliestShipDate'] : "";
                        $FulfillmentChannel = isset($order_d['payload']['FulfillmentChannel']) ? $order_d['payload']['FulfillmentChannel'] : "";
                        $IsBusinessOrder = isset($order_d['payload']['IsBusinessOrder']) ? $order_d['payload']['IsBusinessOrder'] : "";
                        $IsGlobalExpressEnabled = isset($order_d['payload']['IsGlobalExpressEnabled']) ? $order_d['payload']['IsGlobalExpressEnabled'] : "";
                        $IsISPU = isset($order_d['payload']['IsISPU']) ? $order_d['payload']['IsISPU'] : "";
                        $IsPremiumOrder = isset($order_d['payload']['IsPremiumOrder']) ? $order_d['payload']['IsPremiumOrder'] : "";
                        $IsPrime = isset($order_d['payload']['IsPrime']) ? $order_d['payload']['IsPrime'] : "";
                        $IsReplacementOrder = isset($order_d['payload']['IsReplacementOrder']) ? $order_d['payload']['IsReplacementOrder'] : "";
                        $IsSoldByAB = isset($order_d['payload']['IsSoldByAB']) ? $order_d['payload']['IsSoldByAB'] : "";
                        $LastUpdateDate = isset($order_d['payload']['LastUpdateDate']) ? $order_d['payload']['LastUpdateDate'] : "";
                        $LatestDeliveryDate = isset($order_d['payload']['LatestDeliveryDate']) ? $order_d['payload']['LatestDeliveryDate'] : "";
                        $LatestShipDate = isset($order_d['payload']['LatestShipDate']) ? $order_d['payload']['LatestShipDate'] : "";
                        $MarketplaceId = isset($order_d['payload']['MarketplaceId']) ? $order_d['payload']['MarketplaceId'] : "";
                        $NumberOfItemsShipped = isset($order_d['payload']['NumberOfItemsShipped']) ? $order_d['payload']['NumberOfItemsShipped'] : "";
                        $NumberOfItemsUnshipped = isset($order_d['payload']['NumberOfItemsUnshipped']) ? $order_d['payload']['NumberOfItemsUnshipped'] : "";
                        $OrderItems = isset($order_item['payload']) ? json_encode($order_item['payload']) : "";
                        $OrderStatus = isset($order_d['payload']['OrderStatus']) ? $order_d['payload']['OrderStatus'] : "";
                        $OrderTotal__Amount = isset($order_d['payload']['OrderTotal']['Amount']) ? $order_d['payload']['OrderTotal']['Amount'] : "";
                        $OrderTotal__CurrencyCode = isset($order_d['payload']['OrderTotal']['CurrencyCode']) ? $order_d['payload']['OrderTotal']['CurrencyCode'] : "";
                        $OrderType = isset($order_d['payload']['OrderType']) ? $order_d['payload']['OrderType'] : "";
                        $PaymentMethod = isset($order_d['payload']['PaymentMethod']) ? $order_d['payload']['PaymentMethod'] : "";
                        $PaymentMethodDetails__PaymentMethodDetail = isset($order_d['payload']['PaymentMethodDetails'][0]) ? $order_d['payload']['PaymentMethodDetails'][0] : "";
                        $PurchaseDate = isset($order_d['payload']['PurchaseDate']) ? $order_d['payload']['PurchaseDate'] : "";
                        $SalesChannel = isset($order_d['payload']['SalesChannel']) ? $order_d['payload']['SalesChannel'] : "";
                        $ShipServiceLevel = isset($order_d['payload']['ShipServiceLevel']) ? $order_d['payload']['ShipServiceLevel'] : "";
                        $ShipmentServiceLevelCategory = isset($order_d['payload']['ShipmentServiceLevelCategory']) ? $order_d['payload']['ShipmentServiceLevelCategory'] : "";
                        $ShippingAddress__City = isset($address_d['payload']['ShippingAddress']['City']) ? $address_d['payload']['ShippingAddress']['City'] : "";
                        $ShippingAddress__CountryCode = isset($address_d['payload']['ShippingAddress']['CountryCode']) ? $address_d['payload']['ShippingAddress']['CountryCode'] : "";
                        $ShippingAddress__PostalCode = isset($address_d['payload']['ShippingAddress']['PostalCode']) ? $address_d['payload']['ShippingAddress']['PostalCode'] : "";
                        $ShippingAddress__StateOrRegion = isset($address_d['payload']['ShippingAddress']['StateOrRegion']) ? $address_d['payload']['ShippingAddress']['StateOrRegion'] : "";
                        $ShippingAddress__isAddressSharingConfidential = isset($address_d['payload']['ShippingAddress']['isAddressSharingConfidential']) ? $address_d['payload']['ShippingAddress']['isAddressSharingConfidential'] : "";
                        $OrderStatus = ($OrderStatus == 'Unshipped') ? 'Pending' : $OrderStatus;
                        $pstPurchaseDate = changeDateFormatUtcToPst($PurchaseDate);
                        $date = new DateTime($PurchaseDate);
                        $PurchaseDate = (strtotime($pstPurchaseDate->format('Y-m-d')) === strtotime($date->format("Y-m-d"))) ? $PurchaseDate : $pstPurchaseDate->format("Y-m-d H:i:s");
                        
                        $order_data = array(
                            "AmazonSellerId" => $AmazonSellerId,
                            "AmazonOrderId" => $AmazonOrderId,
                            "BuyerEmail" => $BuyerEmail,
                            "DefaultShipFromLocationAddress__AddressLine1" => $DefaultShipFromLocationAddress__AddressLine1,
                            "DefaultShipFromLocationAddress__AddressLine3" => $DefaultShipFromLocationAddress__AddressLine3,
                            "DefaultShipFromLocationAddress__City" => $DefaultShipFromLocationAddress__City,
                            "DefaultShipFromLocationAddress__CountryCode" => $DefaultShipFromLocationAddress__CountryCode,
                            "DefaultShipFromLocationAddress__Name" => $DefaultShipFromLocationAddress__Name,
                            "DefaultShipFromLocationAddress__Phone" => $DefaultShipFromLocationAddress__Phone,
                            "DefaultShipFromLocationAddress__PostalCode" => $DefaultShipFromLocationAddress__PostalCode,
                            "DefaultShipFromLocationAddress__StateOrRegion" => $DefaultShipFromLocationAddress__StateOrRegion,
                            "DefaultShipFromLocationAddress__isAddressSharingConfidential" => $DefaultShipFromLocationAddress__isAddressSharingConfidential,
                            "EarliestDeliveryDate" => $EarliestDeliveryDate,
                            "EarliestShipDate" => $EarliestShipDate,
                            "FulfillmentChannel" => $FulfillmentChannel,
                            "IsBusinessOrder" => $IsBusinessOrder,
                            "IsGlobalExpressEnabled" => $IsGlobalExpressEnabled,
                            "IsISPU" => $IsISPU,
                            "IsPremiumOrder" => $IsPremiumOrder,
                            "IsPrime" => $IsPrime,
                            "IsReplacementOrder" => $IsReplacementOrder,
                            "IsSoldByAB" => $IsSoldByAB,
                            "LastUpdateDate" => $LastUpdateDate,
                            "LatestDeliveryDate" => $LatestDeliveryDate,
                            "LatestShipDate" => $LatestShipDate,
                            "MarketplaceId" => $MarketplaceId,
                            "NumberOfItemsShipped" => $NumberOfItemsShipped,
                            "NumberOfItemsUnshipped" => $NumberOfItemsUnshipped,
                            "OrderItems" => $OrderItems,
                            "OrderStatus" => $OrderStatus,
                            "OrderTotal__Amount" => $OrderTotal__Amount,
                            "OrderTotal__CurrencyCode" => $OrderTotal__CurrencyCode,
                            "OrderType" => $OrderType,
                            "PaymentMethod" => $PaymentMethod,
                            "PaymentMethodDetails__PaymentMethodDetail" => $PaymentMethodDetails__PaymentMethodDetail,
                            "PurchaseDate" => $PurchaseDate,
                            "SalesChannel" => $SalesChannel,
                            "ShipServiceLevel" => $ShipServiceLevel,
                            "ShipmentServiceLevelCategory" => $ShipmentServiceLevelCategory,
                            "ShippingAddress__City" => $ShippingAddress__City,
                            "ShippingAddress__CountryCode" => $ShippingAddress__CountryCode,
                            "ShippingAddress__PostalCode" => $ShippingAddress__PostalCode,
                            "ShippingAddress__StateOrRegion" => $ShippingAddress__StateOrRegion,
                            "ShippingAddress__isAddressSharingConfidential" => $ShippingAddress__isAddressSharingConfidential,
                            "id" => $AmazonOrderId,
                            "add_from" => 1,
                        );
                        $insert_result = $this->crud->insert('amazon_orders_backup', $order_data);
                        echo '<pre>'; print_r($curron_count.' Insert'); echo '</pre>';
                        $curron_count++;
                    }
                }
                if ($key == 10 || $key == 20) {
                    sleep(3);
                }
            }
        }
                        
        echo json_encode(['success' => true, 'message' => 'Order fetch successfully!']);
        exit;
    }
    
    public function getOrderlist()
    {
        $this->isLoggedIn();
        error_reporting(0);

        $test = file_get_contents('test.php');
        $test .= date('Y-m-d H:i:s') . ' ---- Cron executed successfully \r\n';
        file_put_contents('test.php', $test);

        $store = $this->input->post('id');
        $selectedDate = $this->input->post('selectedDate');

        // roleId 1 is a admin and 5 is a store owner
        if ($this->loggedInUserRole() == 1 || $this->loggedInUserRole() == 5) {
            $storeid = $this->crud->getFromSQL("SELECT `store`.id FROM `store` WHERE `isDelete` = 0 AND ( store.name LIKE '%%' ESCAPE '!' ) ORDER BY `store`.`name` ASC");
            $storeId = [];
            foreach ($storeid as $key => $value) {
                $storeId[] = $value->id;
            }

            if (!empty($store) && in_array($store, $storeId)) {
                $storeId = [$store];
            }
        } else {
            $user = $this->crud->get_data_row_by_id("tbl_users", "id", $this->session->userdata('userId'));
            // roleId 4 is a Store Manager
            if ($user->roleId == 4) {
                $storeId = explode(',', $user->store_id);
                
                if (!empty($store) && in_array($store, $storeId)) {
                    $storeId = [$store];
                }
            }
        }

        foreach ($storeId as $key => $sid) {

            $stores_data = $this->crud->getFromSQL("SELECT * FROM `store` WHERE `status` = 'Y' AND `isDelete` = 0 AND `AmazonSellerId` != '' AND `refresh_token` != '' AND `client_id` != '' AND `client_secret` != '' AND id = ".$sid." ORDER BY `name` ASC");

            if (isset($stores_data[0])) {
                $stores_data = $stores_data[0];
            }

            $store = $stores_data;
            
            if (empty($store)) {
                echo json_encode(['success' => true, 'message' => 'Store details not found!']);
                exit;
            }
            
            try {
                $check_array = array(
                    "store_id" => $store->id,
                    "date" => date('Y-m-d'),
                );

                $store_cron = $this->crud->get_all_with_where('order_cron_data', 'store_id', 'asc', $check_array);
                $inserted = 0;
                if (!empty($store_cron)) {
                    $inserted = $store_cron['0']->inserted_record;
                }
                $store_duplicate = $this->crud->check_duplicate('order_cron_data', $check_array);
                if (!$store_duplicate) {
                    $insert_result = $this->crud->insert("order_cron_data", $check_array);
                }

                $sellerid = $store->AmazonSellerId;
                $refresh_token = $store->refresh_token;
                $client_id = $store->client_id;
                $client_secret = $store->client_secret;

                $config = [
                    //Guzzle configuration
                    'http' => [
                        'verify' => false, //<--- NOT SAFE FOR PRODUCTION
                        //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
                    ],

                    //LWA: Keys needed to obtain access token from Login With Amazon Service
                    'refresh_token' => $refresh_token,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,

                    //STS: Keys of the IAM role which are needed to generate Secure Session
                    // (a.k.a Secure token) for accessing and assuming the IAM role
                    'access_key' => 'AKIATJORSRJFWPH7Z4A3',
                    'secret_key' => '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',
                    'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

                    //API: Actual configuration related to the SP API :)
                    'region' => 'us-east-1',
                    'host' => 'sellingpartnerapi-na.amazon.com',
                ];

                file_put_contents("aws-tokens", "");
                //Create token storage which will store the temporary tokens
                $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

                //Create the request signer which will be automatically used to sign all of the
                //requests to the API
                $signer = new DoubleBreak\Spapi\Signer();

                //Create Credentials service and call getCredentials() to obtain
                //all the tokens needed under the hood

                $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
                $cred = $credentials->getCredentials();
                $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);

                $createdAfter = date('Y-m-d');
                $createdBefore = date('Y-m-d', strtotime("+1 days"));
                
                if (!empty($selectedDate)) {
                    $createdAfter = $selectedDate[0];
                    if (strtotime($selectedDate[1]) === strtotime(date('Y-m-d'))) {
                        $createdBefore = $selectedDate[1];
                    } else {
                        $createdBefore = date('Y-m-d', strtotime($selectedDate[1]. "+1 days"));
                    }
                }
                
                if (strtotime($createdAfter) === strtotime($createdBefore)){
                    $createdAfter = $createdAfter;
                    $createdBefore = date('Y-m-d', strtotime($createdAfter. "+1 days"));
                    if (strtotime($createdAfter) === strtotime(date('Y-m-d'))) {
                        $createdBefore = "";
                    }
                }

                if (strtotime($createdAfter) === strtotime(date('Y-m-d'))) {
                    $createdBefore = "";
                }

                $array = [
                    'MarketplaceIds' => 'A2EUQ1WTGCTBG2,ATVPDKIKX0DER,A1AM78C64UM0Y8,A2Q3Y263D00KWC', 
                    'CreatedAfter' => "$createdAfter",
                    'CreatedBefore' => "$createdBefore"
                ];
                
                if ($array['CreatedBefore'] == "") {
                    unset($array['CreatedBefore']);
                }
                
                $result = $reportClient->getOrders($array);
                // echo '<pre>'; print_r(json_encode($result)); echo '</pre>'; exit;
                $order_count = count($result['payload']['Orders']);
                
                ini_set("memory_limit","-1");
                ini_set("max_execution_time", 0);
                $com_flag = 1;
                $insert_count = 0;
                foreach ($result['payload']['Orders'] as $order) {

                    $AmazonOrderId = $order['AmazonOrderId'];
                    // $order_d = $reportClient->getOrder($AmazonOrderId);
                    $OrderStatus = isset($order['OrderStatus']) ? $order['OrderStatus'] : "";
                    
                    $check_buyer_cancelled = $this->crud->check_buyer_cancelled($this->table, array('AmazonOrderId' => $AmazonOrderId));
                    if ($check_buyer_cancelled['OrderStatus'] == 'Canceled' && $OrderStatus == 'Canceled' && $check_buyer_cancelled['reason_cancel'] == 'Buyer Cancelled'){
                        $this->crud->delete($this->table, array('AmazonOrderId' => $AmazonOrderId));
                    } else {
                        

                        $check_duplicate = $this->crud->check_duplicate($this->table, array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
                        $buyer_cancelled_orders = $this->crud->check_duplicate('buyer_cancelled_orders', array('AmazonOrderId' => $AmazonOrderId)); 
                        
                        if (!$check_duplicate && !$buyer_cancelled_orders) {
                            $curron_count++;
                            $buyer_d = $reportClient->getOrderBuyerInfo($AmazonOrderId);
                            // $address_d = $reportClient->getOrderAddress($AmazonOrderId);
                            $order_item = $reportClient->getOrderItems($AmazonOrderId);

                            unset($order_item['payload']['AmazonOrderId']);
                            
                            $PurchaseDate = isset($order['PurchaseDate']) ? $order['PurchaseDate'] : "";
                            $OrderStatus = ($OrderStatus == 'Unshipped') ? 'Pending' : $OrderStatus;
                            $pstPurchaseDate = changeDateFormatUtcToPst($PurchaseDate);
                            $date = new DateTime($PurchaseDate);
                            $PurchaseDate = (strtotime($pstPurchaseDate->format('Y-m-d')) === strtotime($date->format("Y-m-d"))) ? $PurchaseDate : $pstPurchaseDate->format("Y-m-d H:i:s");

                            $order_data = array(
                                "AmazonSellerId" => isset($sellerid) ? $sellerid : "",
                                "AmazonOrderId" => isset($AmazonOrderId) ? $AmazonOrderId : "",
                                "BuyerEmail" => isset($buyer_d['payload']['BuyerEmail']) ? $buyer_d['payload']['BuyerEmail'] : "",
                                "DefaultShipFromLocationAddress__AddressLine1" => isset($order['DefaultShipFromLocationAddress']['AddressLine1']) ? $order['DefaultShipFromLocationAddress']['AddressLine1'] : "",
                                "DefaultShipFromLocationAddress__AddressLine3" => isset($order['DefaultShipFromLocationAddress']['AddressLine2']) ? $order['DefaultShipFromLocationAddress']['AddressLine2'] : "",
                                "DefaultShipFromLocationAddress__City" => isset($order['DefaultShipFromLocationAddress']['City']) ? $order['DefaultShipFromLocationAddress']['City'] : "",
                                "DefaultShipFromLocationAddress__CountryCode" => isset($order['DefaultShipFromLocationAddress']['CountryCode']) ? $order['DefaultShipFromLocationAddress']['CountryCode'] : "",
                                "DefaultShipFromLocationAddress__Name" => isset($order['DefaultShipFromLocationAddress']['Name']) ? $order['DefaultShipFromLocationAddress']['Name'] : "",
                                "DefaultShipFromLocationAddress__Phone" => isset($order['DefaultShipFromLocationAddress']['Phone']) ? $order['DefaultShipFromLocationAddress']['Phone'] : "",
                                "DefaultShipFromLocationAddress__PostalCode" => isset($order['DefaultShipFromLocationAddress']['PostalCode']) ? $order['DefaultShipFromLocationAddress']['PostalCode'] : "",
                                "DefaultShipFromLocationAddress__StateOrRegion" => isset($order['DefaultShipFromLocationAddress']['StateOrRegion']) ? $order['DefaultShipFromLocationAddress']['StateOrRegion'] : "",
                                "DefaultShipFromLocationAddress__isAddressSharingConfidential" => isset($order['DefaultShipFromLocationAddress']['isAddressSharingConfidential']) ? $order['DefaultShipFromLocationAddress']['isAddressSharingConfidential'] : "",
                                "EarliestDeliveryDate" => isset($order['EarliestDeliveryDate']) ? $order['EarliestDeliveryDate'] : "",
                                "EarliestShipDate" => isset($order['EarliestShipDate']) ? $order['EarliestShipDate'] : "",
                                "FulfillmentChannel" => isset($order['FulfillmentChannel']) ? $order['FulfillmentChannel'] : "",
                                "IsBusinessOrder" => isset($order['IsBusinessOrder']) ? $order['IsBusinessOrder'] : "",
                                "IsGlobalExpressEnabled" => isset($order['IsGlobalExpressEnabled']) ? $order['IsGlobalExpressEnabled'] : "",
                                "IsISPU" => isset($order['IsISPU']) ? $order['IsISPU'] : "",
                                "IsPremiumOrder" => isset($order['IsPremiumOrder']) ? $order['IsPremiumOrder'] : "",
                                "IsPrime" => isset($order['IsPrime']) ? $order['IsPrime'] : "",
                                "IsReplacementOrder" => isset($order['IsReplacementOrder']) ? $order['IsReplacementOrder'] : "",
                                "IsSoldByAB" => isset($order['IsSoldByAB']) ? $order['IsSoldByAB'] : "",
                                "LastUpdateDate" => isset($order['LastUpdateDate']) ? $order['LastUpdateDate'] : "",
                                "LatestDeliveryDate" => isset($order['LatestDeliveryDate']) ? $order['LatestDeliveryDate'] : "",
                                "LatestShipDate" => isset($order['LatestShipDate']) ? $order['LatestShipDate'] : "",
                                "MarketplaceId" => isset($order['MarketplaceId']) ? $order['MarketplaceId'] : "",
                                "NumberOfItemsShipped" => isset($order['NumberOfItemsShipped']) ? $order['NumberOfItemsShipped'] : "",
                                "NumberOfItemsUnshipped" => isset($order['NumberOfItemsUnshipped']) ? $order['NumberOfItemsUnshipped'] : "",
                                "OrderItems" => isset($order_item['payload']) ? json_encode($order_item['payload']) : "",
                                "OrderStatus" => $OrderStatus,
                                "OrderTotal__Amount" => isset($order['OrderTotal']['Amount']) ? $order['OrderTotal']['Amount'] : "",
                                "OrderTotal__CurrencyCode" => isset($order['OrderTotal']['CurrencyCode']) ? $order['OrderTotal']['CurrencyCode'] : "",
                                "OrderType" => isset($order['OrderType']) ? $order['OrderType'] : "",
                                "PaymentMethod" => isset($order['PaymentMethod']) ? $order['PaymentMethod'] : "",
                                "PaymentMethodDetails__PaymentMethodDetail" => isset($order['PaymentMethodDetails'][0]) ? $order['PaymentMethodDetails'][0] : "",
                                "PurchaseDate" => $PurchaseDate,
                                "SalesChannel" => isset($order['SalesChannel']) ? $order['SalesChannel'] : "",
                                "ShipServiceLevel" => isset($order['ShipServiceLevel']) ? $order['ShipServiceLevel'] : "",
                                "ShipmentServiceLevelCategory" => isset($order['ShipmentServiceLevelCategory']) ? $order['ShipmentServiceLevelCategory'] : "",
                                "ShippingAddress__City" => isset($order['ShippingAddress']['City']) ? $order['ShippingAddress']['City'] : "",
                                "ShippingAddress__CountryCode" => isset($order['ShippingAddress']['CountryCode']) ? $order['ShippingAddress']['CountryCode'] : "",
                                "ShippingAddress__PostalCode" => isset($order['ShippingAddress']['PostalCode']) ? $order['ShippingAddress']['PostalCode'] : "",
                                "ShippingAddress__StateOrRegion" => isset($order['ShippingAddress']['StateOrRegion']) ? $order['ShippingAddress']['StateOrRegion'] : "",
                                "ShippingAddress__isAddressSharingConfidential" => isset($order['ShippingAddress']['isAddressSharingConfidential']) ? $order['ShippingAddress']['isAddressSharingConfidential'] : "",
                                "id" => $AmazonOrderId,
                                "add_from" => 1,
                            );
                            
                            $insert_result = $this->crud->insert($this->table, $order_data);
                            $com_flag = 0;
                            //update crone inserted record count
                            $inserted++;
                            $insert_count++;

                            $post = array(
                                "inserted_record" => $inserted,
                                "is_Complite" => $inserted == $order_count ? "1" : "0",
                            );
                            $update_result = $this->crud->update("order_cron_data", $post, $check_array);

                        } 
                        // elseif ($check_duplicate && $check_buyer_cancelled['OrderStatus'] != $OrderStatus) {
                        //     $check_order = array(
                        //         "order_id" => $check_buyer_cancelled['order_id']
                        //     );
                        //     $insert_result = $this->crud->update($this->table, $order_data, $check_order);
                        // }
                    }
                }
                if ($com_flag == 1) {
                    $post = array(
                        "is_Complite" => "1",
                    );
                    $update_result = $this->crud->update("order_cron_data", $post, $check_array);
                }
                $check_array1 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => 200,
                    "response" => 'successfully get orders',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array1);        
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $httpCode = $e->getResponse()->getStatusCode();
                $errorBody =  $e->getResponse()->getBody();

                $check_array2 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => ($httpCode) ? $httpCode : '',
                    "response" => ($errorBody) ? $errorBody : '',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array2);
                $errorCount = 1;
                continue;
            } catch(\Exception $e) {
                $httpCode = $e->getResponse()->getStatusCode();
                $errorBody =  $e->getResponse()->getBody();
                $check_array3 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => $httpCode,
                    "response" => $e->getMessage(),
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array3);
                $errorCount = 1;
                continue;
            }   
        }

        // after foreach
        $count_stores = count($this->crud->get_all_with_where('store', 'name', 'asc', array('status' => 'Y', 'isDelete' => 0, "AmazonSellerId !=" => "", "refresh_token !=" => "", "client_id !=" => "", "client_secret !=" => "")));
        $count_complite = count($this->crud->get_all_with_where('order_cron_data', 'is_Complite', 'asc', array('is_Complite' => '1', "date" => date('Y-m-d'))));
        if ($count_stores == $count_complite) {
            $this->db->query('UPDATE `order_cron_data` SET `is_Complite` = "0" WHERE `date` = "' . date('Y-m-d') . '"');
        }

        $insertedOrder = (!empty($insert_count)) ? $insert_count : 0;
        $message = ($insertedOrder != 0) ? $insertedOrder.' '.'Orders inserted successfully!' : 'Orders already inserted for selected dates!';
        $message = ($errorCount == 1) ? 'Something is wrong please see logs for more details!' : $message;
        echo json_encode(['success' => true, 'message' => $message]);
        exit;
    }

    public function apapi()
    {
        error_reporting(0);

        $test = file_get_contents('test.php');
        $test .= date('Y-m-d H:i:s') . ' ---- Cron executed successfully \r\n';
        file_put_contents('test.php', $test);

        $store_id = $this->crud->getFromSQL('SELECT GROUP_CONCAT(store_id) as store_id FROM `order_cron_data` where is_Complite = 1 AND date = "' . date('Y-m-d') . '"');

        $store_id = $store_id[0]->store_id;
        if ($store_id != "") {
            $stores_data = $this->crud->getFromSQL("SELECT * FROM `store` WHERE `status` = 'Y' AND `isDelete` = 0 AND `AmazonSellerId` != '' AND `refresh_token` != '' AND `client_id` != '' AND `client_secret` != '' AND id NOT IN (" . $store_id . ") ORDER BY `name` ASC");
        } else {
            $stores_data = $this->crud->get_all_with_where('store', 'name', 'asc', array('status' => 'Y', 'isDelete' => 0, "AmazonSellerId !=" => "", "refresh_token !=" => "", "client_id !=" => "", "client_secret !=" => ""));
        }
        $curron_count = 1;
        // echo '<pre>'; print_r($stores_data); echo '</pre>'; exit;
        foreach ($stores_data as $storekey => $store) {
                
            try {
                $check_array = array(
                    "store_id" => $store->id,
                    "date" => date('Y-m-d'),
                );

                $store_cron = $this->crud->get_all_with_where('order_cron_data', 'store_id', 'asc', $check_array);
                $inserted = 0;
                if (!empty($store_cron)) {
                    $inserted = $store_cron['0']->inserted_record;
                }
                $store_duplicate = $this->crud->check_duplicate('order_cron_data', $check_array);
                if (!$store_duplicate) {
                    $insert_result = $this->crud->insert("order_cron_data", $check_array);
                }

                $sellerid = $store->AmazonSellerId;
                $refresh_token = $store->refresh_token;
                $client_id = $store->client_id;
                $client_secret = $store->client_secret;

                $config = [
                    //Guzzle configuration
                    'http' => [
                        'verify' => false, //<--- NOT SAFE FOR PRODUCTION
                        //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
                    ],

                    //LWA: Keys needed to obtain access token from Login With Amazon Service
                    'refresh_token' => $refresh_token,
                    'client_id' => $client_id,
                    'client_secret' => $client_secret,

                    //STS: Keys of the IAM role which are needed to generate Secure Session
                    // (a.k.a Secure token) for accessing and assuming the IAM role
                    'access_key' => 'AKIATJORSRJFWPH7Z4A3',
                    'secret_key' => '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',
                    'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

                    //API: Actual configuration related to the SP API :)
                    'region' => 'us-east-1',
                    'host' => 'sellingpartnerapi-na.amazon.com',
                ];

                file_put_contents("aws-tokens", "");
                //Create token storage which will store the temporary tokens
                $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

                //Create the request signer which will be automatically used to sign all of the
                //requests to the API
                $signer = new DoubleBreak\Spapi\Signer();

                //Create Credentials service and call getCredentials() to obtain
                //all the tokens needed under the hood

                $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
                $cred = $credentials->getCredentials();

                $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);
                
                

                $result = $reportClient->getOrders([
                    'MarketplaceIds' => 'A2EUQ1WTGCTBG2,ATVPDKIKX0DER,A1AM78C64UM0Y8,A2Q3Y263D00KWC',
                    'CreatedAfter' => date('Y-m-d', strtotime("-1 days")),
                ]);
                // echo '<pre>'; print_r(json_encode($result)); echo '</pre>'; exit;
                $order_count = count($result['payload']['Orders']);

                $com_flag = 1;
                foreach ($result['payload']['Orders'] as $key => $order) {

                    $AmazonOrderId = $order['AmazonOrderId'];
                    // $order_d = $reportClient->getOrder($AmazonOrderId);
                    $OrderStatus = isset($order['OrderStatus']) ? $order['OrderStatus'] : "";
                    $check_buyer_cancelled = $this->crud->check_buyer_cancelled($this->table, array('AmazonOrderId' => $AmazonOrderId));
                    if ($check_buyer_cancelled['OrderStatus'] == 'Canceled' && $OrderStatus == 'Canceled' && $check_buyer_cancelled['reason_cancel'] == 'Buyer Cancelled'){

                        $this->crud->delete($this->table, array('AmazonOrderId' => $AmazonOrderId));
                    } else {
                        
                        $check_duplicate = $this->crud->check_duplicate($this->table, array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0));
                        $buyer_cancelled_orders = $this->crud->check_duplicate('buyer_cancelled_orders', array('AmazonOrderId' => $AmazonOrderId)); 
                        
                        if (!$check_duplicate && !$buyer_cancelled_orders) {
                            $curron_count++;
                            $buyer_d = $reportClient->getOrderBuyerInfo($AmazonOrderId);
                            // $address_d = $reportClient->getOrderAddress($AmazonOrderId);
                            $order_item = $reportClient->getOrderItems($AmazonOrderId);

                            unset($order_item['payload']['AmazonOrderId']);
                            
                            $PurchaseDate = isset($order['PurchaseDate']) ? $order['PurchaseDate'] : "";
                            $OrderStatus = ($OrderStatus == 'Unshipped') ? 'Pending' : $OrderStatus;
                            $pstPurchaseDate = changeDateFormatUtcToPst($PurchaseDate);
                            $date = new DateTime($PurchaseDate);
                            $PurchaseDate = (strtotime($pstPurchaseDate->format('Y-m-d')) === strtotime($date->format("Y-m-d"))) ? $PurchaseDate : $pstPurchaseDate->format("Y-m-d H:i:s");

                            $order_data = array(
                                "AmazonSellerId" => isset($sellerid) ? $sellerid : "",
                                "AmazonOrderId" => isset($AmazonOrderId) ? $AmazonOrderId : "",
                                "BuyerEmail" => isset($buyer_d['payload']['BuyerEmail']) ? $buyer_d['payload']['BuyerEmail'] : "",
                                "DefaultShipFromLocationAddress__AddressLine1" => isset($order['DefaultShipFromLocationAddress']['AddressLine1']) ? $order['DefaultShipFromLocationAddress']['AddressLine1'] : "",
                                "DefaultShipFromLocationAddress__AddressLine3" => isset($order['DefaultShipFromLocationAddress']['AddressLine2']) ? $order['DefaultShipFromLocationAddress']['AddressLine2'] : "",
                                "DefaultShipFromLocationAddress__City" => isset($order['DefaultShipFromLocationAddress']['City']) ? $order['DefaultShipFromLocationAddress']['City'] : "",
                                "DefaultShipFromLocationAddress__CountryCode" => isset($order['DefaultShipFromLocationAddress']['CountryCode']) ? $order['DefaultShipFromLocationAddress']['CountryCode'] : "",
                                "DefaultShipFromLocationAddress__Name" => isset($order['DefaultShipFromLocationAddress']['Name']) ? $order['DefaultShipFromLocationAddress']['Name'] : "",
                                "DefaultShipFromLocationAddress__Phone" => isset($order['DefaultShipFromLocationAddress']['Phone']) ? $order['DefaultShipFromLocationAddress']['Phone'] : "",
                                "DefaultShipFromLocationAddress__PostalCode" => isset($order['DefaultShipFromLocationAddress']['PostalCode']) ? $order['DefaultShipFromLocationAddress']['PostalCode'] : "",
                                "DefaultShipFromLocationAddress__StateOrRegion" => isset($order['DefaultShipFromLocationAddress']['StateOrRegion']) ? $order['DefaultShipFromLocationAddress']['StateOrRegion'] : "",
                                "DefaultShipFromLocationAddress__isAddressSharingConfidential" => isset($order['DefaultShipFromLocationAddress']['isAddressSharingConfidential']) ? $order['DefaultShipFromLocationAddress']['isAddressSharingConfidential'] : "",
                                "EarliestDeliveryDate" => isset($order['EarliestDeliveryDate']) ? $order['EarliestDeliveryDate'] : "",
                                "EarliestShipDate" => isset($order['EarliestShipDate']) ? $order['EarliestShipDate'] : "",
                                "FulfillmentChannel" => isset($order['FulfillmentChannel']) ? $order['FulfillmentChannel'] : "",
                                "IsBusinessOrder" => isset($order['IsBusinessOrder']) ? $order['IsBusinessOrder'] : "",
                                "IsGlobalExpressEnabled" => isset($order['IsGlobalExpressEnabled']) ? $order['IsGlobalExpressEnabled'] : "",
                                "IsISPU" => isset($order['IsISPU']) ? $order['IsISPU'] : "",
                                "IsPremiumOrder" => isset($order['IsPremiumOrder']) ? $order['IsPremiumOrder'] : "",
                                "IsPrime" => isset($order['IsPrime']) ? $order['IsPrime'] : "",
                                "IsReplacementOrder" => isset($order['IsReplacementOrder']) ? $order['IsReplacementOrder'] : "",
                                "IsSoldByAB" => isset($order['IsSoldByAB']) ? $order['IsSoldByAB'] : "",
                                "LastUpdateDate" => isset($order['LastUpdateDate']) ? $order['LastUpdateDate'] : "",
                                "LatestDeliveryDate" => isset($order['LatestDeliveryDate']) ? $order['LatestDeliveryDate'] : "",
                                "LatestShipDate" => isset($order['LatestShipDate']) ? $order['LatestShipDate'] : "",
                                "MarketplaceId" => isset($order['MarketplaceId']) ? $order['MarketplaceId'] : "",
                                "NumberOfItemsShipped" => isset($order['NumberOfItemsShipped']) ? $order['NumberOfItemsShipped'] : "",
                                "NumberOfItemsUnshipped" => isset($order['NumberOfItemsUnshipped']) ? $order['NumberOfItemsUnshipped'] : "",
                                "OrderItems" => isset($order_item['payload']) ? json_encode($order_item['payload']) : "",
                                "OrderStatus" => $OrderStatus,
                                "OrderTotal__Amount" => isset($order['OrderTotal']['Amount']) ? $order['OrderTotal']['Amount'] : "",
                                "OrderTotal__CurrencyCode" => isset($order['OrderTotal']['CurrencyCode']) ? $order['OrderTotal']['CurrencyCode'] : "",
                                "OrderType" => isset($order['OrderType']) ? $order['OrderType'] : "",
                                "PaymentMethod" => isset($order['PaymentMethod']) ? $order['PaymentMethod'] : "",
                                "PaymentMethodDetails__PaymentMethodDetail" => isset($order['PaymentMethodDetails'][0]) ? $order['PaymentMethodDetails'][0] : "",
                                "PurchaseDate" => $PurchaseDate,
                                "SalesChannel" => isset($order['SalesChannel']) ? $order['SalesChannel'] : "",
                                "ShipServiceLevel" => isset($order['ShipServiceLevel']) ? $order['ShipServiceLevel'] : "",
                                "ShipmentServiceLevelCategory" => isset($order['ShipmentServiceLevelCategory']) ? $order['ShipmentServiceLevelCategory'] : "",
                                "ShippingAddress__City" => isset($order['ShippingAddress']['City']) ? $order['ShippingAddress']['City'] : "",
                                "ShippingAddress__CountryCode" => isset($order['ShippingAddress']['CountryCode']) ? $order['ShippingAddress']['CountryCode'] : "",
                                "ShippingAddress__PostalCode" => isset($order['ShippingAddress']['PostalCode']) ? $order['ShippingAddress']['PostalCode'] : "",
                                "ShippingAddress__StateOrRegion" => isset($order['ShippingAddress']['StateOrRegion']) ? $order['ShippingAddress']['StateOrRegion'] : "",
                                "ShippingAddress__isAddressSharingConfidential" => isset($order['ShippingAddress']['isAddressSharingConfidential']) ? $order['ShippingAddress']['isAddressSharingConfidential'] : "",
                                "id" => $AmazonOrderId,
                                "add_from" => 1,
                            );
                            
                            $insert_result = $this->crud->insert($this->table, $order_data);
                            $com_flag = 0;
                            //update crone inserted record count
                            $inserted++;
                            $insert_count++;

                            $post = array(
                                "inserted_record" => $inserted,
                                "is_Complite" => $inserted == $order_count ? "1" : "0",
                            );
                            $update_result = $this->crud->update("order_cron_data", $post, $check_array);

                        } 
                    }
                    
                    if ($key == 10 || $key == 20 || $key == 30|| $key == 40 ) {
                        sleep(5);
                    }
                }
                
                if ($com_flag == 1) {
                    $post = array(
                        "is_Complite" => "1",
                    );
                    $update_result = $this->crud->update("order_cron_data", $post, $check_array);
                }
                $check_array1 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => 200,
                    "response" => 'successfully get orders',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array1);        
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                $httpCode = $e->getResponse()->getStatusCode();
                $errorBody =  $e->getResponse()->getBody();

                $check_array2 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => ($httpCode) ? $httpCode : '',
                    "response" => ($errorBody) ? $errorBody : '',
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array2);
                continue;
            } catch(\Exception $e) {
                $httpCode = $e->getResponse()->getStatusCode();
                $errorBody =  $e->getResponse()->getBody();
                $check_array3 = array(
                    "amazonSellerId" => $sellerid,
                    "responce_code" => $httpCode,
                    "response" => $e->getMessage(),
                    "created_at" => date('Y-m-d H:i:s'),
                    "updated_at" => date('Y-m-d H:i:s'),
                );
                $insert_result = $this->crud->insert("cron_order_log", $check_array3);
                continue;
            }
            sleep(5);
        }
        
        $count_stores = count($this->crud->get_all_with_where('store', 'name', 'asc', array('status' => 'Y', 'isDelete' => 0, "AmazonSellerId !=" => "", "refresh_token !=" => "", "client_id !=" => "", "client_secret !=" => "")));
        $count_complite = count($this->crud->get_all_with_where('order_cron_data', 'is_Complite', 'asc', array('is_Complite' => '1', "date" => date('Y-m-d'))));
        if ($count_stores == $count_complite) {
            $this->db->query('UPDATE `order_cron_data` SET `is_Complite` = "0" WHERE `date` = "' . date('Y-m-d') . '"');
        }
        echo "success.";exit;
    }

    public function fields_show()
    {
        $post = $this->input->post();
        $fieldInfo = array(
            "ASIN" => isset($post['ASIN']) ? $post['ASIN'] : 0,
            "AmazonOrderId" => isset($post['AmazonOrderId']) ? $post['AmazonOrderId'] : 0,
            "MerchantOrderID" => isset($post['MerchantOrderID']) ? $post['MerchantOrderID'] : 0,
            "Title" => isset($post['Title']) ? $post['Title'] : 0,
            "PurchaseDateNew" => isset($post['PurchaseDateNew']) ? $post['PurchaseDateNew'] : 0,
            "Lastupdate" => isset($post['Lastupdate']) ? $post['Lastupdate'] : 0,
            "LastupdateBy" => isset($post['LastupdateBy']) ? $post['LastupdateBy'] : 0,
            "SellerSKU" => isset($post['SellerSKU']) ? $post['SellerSKU'] : 0,
            "ShipmentTrackingNumber" => isset($post['ShipmentTrackingNumber']) ? $post['ShipmentTrackingNumber'] : 0,
            "ShipmentTrackingStatus" => isset($post['ShipmentTrackingStatus']) ? $post['ShipmentTrackingStatus'] : 0,
            "shipment_date" => isset($post['shipment_date']) ? $post['shipment_date'] : 0,
            "roi" => isset($post['roi']) ? $post['roi'] : 0,
            "OrderStatus" => isset($post['OrderStatus']) ? $post['OrderStatus'] : 0,
            "late_shipment" => isset($post['late_shipment']) ? $post['late_shipment'] : 0,
            "BuyerName" => isset($post['BuyerName']) ? $post['BuyerName'] : 0,
            "Store_name" => isset($post['Store_name']) ? $post['Store_name'] : 0,
            "Note" => isset($post['Note']) ? $post['Note'] : 0,
        );

        $check_duplicate = $this->crud->check_duplicate('fields_module', array('user_id' => $this->session->userdata('userId')));
        if ($check_duplicate) {
            $where_array = array('user_id' => $this->session->userdata('userId'));
            $update_result = $this->crud->update("fields_module", $fieldInfo, $where_array);
            //echo $this->db->last_query();
        } else {
            $fieldInfo['user_id'] = $this->session->userdata('userId');
            $insert_result = $this->crud->insert("fields_module", $fieldInfo);
        }
    }

    public function jsontoasin()
    {
        $sql = 'SELECT ao.order_id,add_from, REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(OrderItems, "{\'", "{\""), "\':", "\":"), ": \'", ": \""), "\', \'", "\", \""), "\'}", "\"}"), ", \'", ", \""), "\'", "") as OrderItems FROM `amazon_orders` `ao` where (ASIN_NO is null or product_title is null) limit 0,5000';

        $orders = $this->crud->getFromSQL($sql);

        //echo "<pre>";
        foreach ($orders as $order) {

            $order_id = $order->order_id;
            $order_item = $order->OrderItems;
            if ($order->add_from == 0) {
                $order_item = addslashes($order_item);
                $order_item = str_replace('{\"', '{"', $order_item);
                $order_item = str_replace('\":', '":', $order_item);
                $order_item = str_replace('": \"', '": "', $order_item);
                $order_item = str_replace('\", \"', '", "', $order_item);
                $order_item = str_replace('\"}, \"', '"}, "', $order_item);
                $order_item = str_replace('\"}', '"}', $order_item);

                $order_item_arr = json_decode($order_item, true);
                $orderitem_data = $order_item_arr[0]['OrderItem'];
                //echo $order_id . " " . $orderitem_data['ASIN'] . " " . $orderitem_data['Title'] . "<br>";
            } else {

                $order_item_arr = json_decode($order_item, true);
                $orderitem_data = $order_item_arr['OrderItems'][0];
                if (empty($orderitem_data)) {
                    $orderitem_data = $order_item_arr[0]['OrderItem'];
                }

                if (empty($orderitem_data)) {
                    $order_item = addslashes($order_item);
                    $order_item = str_replace('{\"', '{"', $order_item);
                    $order_item = str_replace('\":', '":', $order_item);
                    $order_item = str_replace('": \"', '": "', $order_item);
                    $order_item = str_replace('\", \"', '", "', $order_item);
                    $order_item = str_replace('\"}, \"', '"}, "', $order_item);
                    $order_item = str_replace('\"}', '"}', $order_item);

                    $order_item_arr = json_decode($order_item, true);
                    $orderitem_data = $order_item_arr[0]['OrderItem'];
                }
                //echo $order_id . " " . $orderitem_data['ASIN'] . " " . $orderitem_data['Title'] . "<br>";
            }

            $where_array = array('order_id' => $order_id);
            $fieldInfo = array("ASIN_NO" => $orderitem_data['ASIN'], "product_title" => $orderitem_data['Title']);
            $update_result = $this->crud->update("amazon_orders", $fieldInfo, $where_array);
        }
        //echo "success";
    }

    public function manage_asin()
    {
        $this->isLoggedIn();
        $this->jsontoasin();
        $data = array();
        //$data['totol_order_count']

        $asin_count = $this->crud->getFromSQL("SELECT count(DISTINCT (ASIN_NO)) as count FROM `amazon_orders` where isDelete = 0");
        $data['asin_count'] = $asin_count[0]->count;

        $data["search"] = $this->session->userdata('filter_data');
        $data['site_email'] = $this->generalSetting()->site_from_email;
        $this->global['pageTitle'] = ' : Sales By ASIN';
        $this->loadViews(ADMIN . "ManageAmazonAsin", $this->global, $data, null);
    }

    public function ajaxPaginationasin()
    {
        $params = array();
        $page = $this->input->post('page');

        if (!$page) {$offset = 0;} else { $offset = $page;}

        $perpage = $this->input->post('perpage');
        $this->perPage = $perpage;
        $search['OrdersType'] = $this->perPage;

        $join['select'] = 'ao.ASIN_NO,SUM(OrderTotal__Amount) as OrderTotal__Amount,SUM(PricePayed) as PricePayed,FulfillmentChannel,product_title,count(*) as Total_order';
        //$join['select'] = 'DATE_FORMAT(ao.PurchaseDate, "%m/%d/%Y") as PurchaseDateNew, ao.*, REGEXP_REPLACE(OrderItems, \'[^\\x20-\\x7E]\', "") as OrderItems1';
        $join['table'] = 'amazon_orders ao';

        //$wh = array("ao.isDelete" => '0','ao.AmazonOrderId' => '113-0136548-0674656');

        if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
            $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');

            $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);

        } else {
            $wh = array("ao.isDelete" => '0');
        }

        if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
            $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
            $search['OrdersType'] = $_REQUEST['OrdersType'];
        }

        if (isset($_REQUEST['SearchTerm'])) {
            $SearchTerm = $_REQUEST['SearchTerm'];
            $search['SearchTerm'] = $_REQUEST['SearchTerm'];
        }

        if (!empty($SearchTerm)) {
            $params['like'] = array('ao.ASIN_NO' => $SearchTerm);
        }

        if (!empty($_REQUEST['StartDate']) && !empty($_REQUEST['EndDate'])) {
            $search['StartDate'] = $_REQUEST['StartDate'];
            $search['EndDate'] = $_REQUEST['EndDate'];
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
        }
        $params['GroupBy'] = "ao.ASIN_NO";
        $totalRec = count($this->crud->get_join($join, $wh, $params));

        //echo $totalRec;exit;
        $config['target'] = '#resultList';
        $config['base_url'] = base_url() . 'admin/AmazonOrderController/ajaxPaginationData';
        $config['total_rows'] = $totalRec;
        $config['per_page'] = $this->perPage;
        $config['uri_segment'] = 4;
        $config['link_func'] = "searchFilter";

        $this->ajax_pagination->initialize($config);
        $params['ShortBy'] = "ao.order_id";
        $params['ShortOrder'] = "desc";

        $data['all_total_details'] = $this->crud->get_join($join, $wh, $params);

        $params['start'] = $offset;
        $params['Limit'] = $this->perPage;
        $data['posts'] = $this->crud->get_join($join, $wh, $params);
        // /echo "<pre>";

        //echo $this->db->last_query();
        //print_r($data);die();
        $data['search'] = $search;
        $this->session->set_userdata('filter_data', $search);
        $this->load->view(ADMIN . "amazon_asin_ajax_data", $data);
    }
    
    public function asin_export_excel()
    {
        $params = array();

        $join['select'] = 'ao.ASIN_NO,SUM(OrderTotal__Amount) as OrderTotal__Amount,SUM(PricePayed) as PricePayed,FulfillmentChannel,product_title,count(*) as Total_order';
        $join['table'] = 'amazon_orders ao';

        if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
            $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');

            $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);

        } else {
            $wh = array("ao.isDelete" => '0');
        }

        if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
            $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
            $search['OrdersType'] = $_REQUEST['OrdersType'];
        }

        if (isset($_REQUEST['SearchTerm'])) {
            $SearchTerm = $_REQUEST['SearchTerm'];
            $search['SearchTerm'] = $_REQUEST['SearchTerm'];
        }

        if (!empty($SearchTerm)) {
            $params['like'] = array('ao.ASIN_NO' => $SearchTerm);
        }

        if (!empty($_REQUEST['StartDate']) && !empty($_REQUEST['EndDate'])) {
            $search['StartDate'] = $_REQUEST['StartDate'];
            $search['EndDate'] = $_REQUEST['EndDate'];
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
        }
        $params['GroupBy'] = "ao.ASIN_NO";
        $posts = $this->crud->get_join($join, $wh, $params);

        // create file name
        $fileName = 'data-' . time() . '.xlsx';
        // load excel library
        $this->load->library('excel');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'ASIN NUMBER');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'AMAZON TITLE');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Total Order');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Unit Sold');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Unit cancelled');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'BUYER PAID');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'PURCHASE COST');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'TOTAL PROFIT');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'NET ROI');
        // set Row
        $rowCount = 2;
        $total_purchase_cost = 0;
        $total_profit = 0;
        $total_buyer_paid = 0;
        foreach ($posts as $post) {

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

            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $ASIN);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $Title);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $post['Total_order']);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $sold);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $cancled);
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, CURR_SYMBOL . " " . round($post['OrderTotal__Amount'], 2));
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, CURR_SYMBOL . " " . round($post['PricePayed'], 2));
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, CURR_SYMBOL . " " . $cal_profit);
            $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, $dis_roi_cal);
            $rowCount++;
        }

        $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, 'Total');
        $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, CURR_SYMBOL . " " . $total_buyer_paid);
        $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, CURR_SYMBOL . " " . $total_purchase_cost);
        $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, CURR_SYMBOL . " " . $total_profit);
        $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowCount, '');
        $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowCount, '');

        $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

        //header("Content-Type: application/vnd.ms-excel");

        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=" . $fileName);
        header("Cache-Control: max-age=0");
        $objWriter->save("php://output");

        redirect(ADMIN . 'manage-amazon-asin');
    }

    public function asin_export_pdf()
    {
        
        ini_set("memory_limit","-1");
        ini_set("max_execution_time","1000");
        echo "<script>window.close();</script>";
        error_reporting(E_ERROR | E_PARSE);
        require_once 'application/libraries/vendor/autoload.php';

        $join['select'] = 'ao.ASIN_NO,SUM(OrderTotal__Amount) as OrderTotal__Amount,SUM(PricePayed) as PricePayed,FulfillmentChannel,product_title,count(*) as Total_order';
        $join['table'] = 'amazon_orders ao';

        if ($this->session->userdata('store') && $this->session->userdata('store') > 0) {
            $active_store = $this->crud->get_row_by_id('store', ' id = ' . $this->session->userdata('store') . '');

            $wh = array("ao.isDelete" => '0', "ao.AmazonSellerId" => $active_store['AmazonSellerId']);

        } else {
            $wh = array("ao.isDelete" => '0');
        }

        if (isset($_REQUEST['OrdersType']) && !empty($_REQUEST['OrdersType'])) {
            $wh['ao.FulfillmentChannel'] = $_REQUEST['OrdersType'];
            $search['OrdersType'] = $_REQUEST['OrdersType'];
        }

        if (isset($_REQUEST['SearchTerm'])) {
            $SearchTerm = $_REQUEST['SearchTerm'];
            $search['SearchTerm'] = $_REQUEST['SearchTerm'];
        }

        if (!empty($SearchTerm)) {
            $params['like'] = array('ao.ASIN_NO' => $SearchTerm);
        }

        if (!empty($_REQUEST['StartDate']) && !empty($_REQUEST['EndDate'])) {
            $search['StartDate'] = $_REQUEST['StartDate'];
            $search['EndDate'] = $_REQUEST['EndDate'];
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") >='] = date("Y/m/d", strtotime($_REQUEST['StartDate']));
            $wh['DATE_FORMAT(ao.PurchaseDate, "%Y/%m/%d") <='] = date("Y/m/d", strtotime($_REQUEST['EndDate']));
        }
        
        $params['GroupBy'] = "ao.ASIN_NO";
        $posts = $this->crud->get_join($join, $wh, $params);
        // echo '<pre>'; print_r($posts); echo '</pre>'; exit;
        // echo $this->db->last_query();
        $html = '<!DOCTYPE html>
                <html lang="en">
                    <head>
                    <meta charset="utf-8">
                    <title>Sales By ASIN Report</title>
                    <style>
                        body {
                            margin: 0 auto;
                            color: #001028;
                            background: #FFFFFF;
                            font-family: Arial, sans-serif;
                            font-size: 12px;
                        }

                        table {
                            width: 100%;
                            border-collapse: collapse;
                            border-spacing: 0;
                        }

                        table tr:nth-child(2n-1) td {
                            background: #F5F5F5;
                        }

                        table th,
                        table td {
                            text-align: center;
                        }

                        table th {
                            padding: 10px 20px;
                            color: #5D6975;
                            white-space: nowrap;
                            font-weight: normal;
                        }

                        table td {
                            padding: 15px;
                            text-align: center;
                        }
                    </style>
                    </head>
                    <body>
                        <main>
                            <table style="border: 1px solid #C1CED9;">
                                <thead>
                                    <tr style="border: 1px solid #C1CED9;">
                                        <th>ASIN Number</th>
                                        <th>Amazon Title</th>
                                        <th>Total Order</th>
                                        <th>Unit Sold</th>
                                        <th>Unit Cancelled</th>
                                        <th>BUYER PAID</th>
                                        <th>PURCHASE COST</th>
                                        <th>TOTAL PROFIT</th>
                                        <th>NET ROI</th>
                                    </tr>
                                </thead>
                                <tbody>';

        $total_purchase_cost = 0;
        $total_profit = 0;
        $total_buyer_paid = 0;
        if (!empty($posts)) {
            foreach ($posts as $post) {
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

                $html .='<tr style="border: 1px solid #C1CED9;">
                            <td>' . $ASIN . '</td>
                            <td><div class="d-flex align-items-center"><i class="fas fa-envelope mr-2"></i> <p>'.$Title.'</p></div></td>
                            <td>' . $post['Total_order'] . '</td>
                            <td>' . $sold . '</td>
                            <td>' . $cancled .'</td>
                            <td>' . CURR_SYMBOL . " " . round($post['OrderTotal__Amount'], 2) . '</td>
                            <td>' . CURR_SYMBOL . " " . round($post['PricePayed'], 2) . '</td>
                            <td>' . CURR_SYMBOL . " " . $cal_profit . '</td>
                            <td>' . $dis_roi_cal . '</td>
                        </tr>';
            }

            $html .='<tr>
                        <td><b>Total</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><b>' . CURR_SYMBOL . " " . $total_buyer_paid . '</b></td>
                        <td><b>' . CURR_SYMBOL . " " . $total_purchase_cost . '</b></td>
                        <td><b>' . CURR_SYMBOL . " " . $total_profit . '</b></td>
                        <td></td>
                        <td></td>
                    </tr>';
        } else {
            $html .='<tr>
                        <td colspan="15">
                             There are currently no Sales By ASIN show.
                        </td>
                    </tr>';
        }
        $html .= '</tbody>
                            </table>
                        </main>
                    </body>
                </html>';

        // echo '<pre>'; print_r($html); echo '</pre>'; exit;
        $mpdf = new mPDF();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->defaultfooterfontstyle='';
        $mpdf->defaultfooterfontsize=12;
        $mpdf->defaultfooterline=0;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->WriteHTML($html);
        $pdf_name = time()."ASINReport" . ".pdf";
        $mpdf->Output('public/PDF/'.$pdf_name,'F');
        
        // $mpdf->Output(FCPATH.'PDF/'.$pdf_name,'F');
        // $mpdf->Output($pdf_name, 'F');
        
        $pdf_link = base_url().'public/PDF/'.$pdf_name;
        

        /* General setting common from all email start */
        $general_setting            = $this->generalSetting(); 
        $mail_data['site_name']     = $general_setting->site_name;
        $mail_data['site_title']    = $general_setting->site_title;
        $mail_data['site_email']    = $general_setting->email;
        $mail_data['site_logo']     = base_url('public/front/images/logo/'.$general_setting->site_logo );
        $mail_data['address']       = $general_setting->address;
        $mail_data['fb_link']       = $general_setting->fb_link;
        $mail_data['twitter_link']  = $general_setting->twitter_link;
        $mail_data['instagram_link'] = $general_setting->instagram_link;
        /* General setting common from all email end */

        $user = $this->crud->get_row_by_id('tbl_users', ' id = ' . $this->session->userdata('userId') . '');

        $mail_data['fname']         = $user['fname'];
        $mail_data['pdf_link']      = $pdf_link;

        $message = $this->load->view('mail_template/pdf_generate_mail_template', $mail_data, TRUE);

        $mailbody['ToEmail']    = $user['email'];
        $mailbody['FromName']   = $general_setting->site_name;
        $mailbody['FromEmail']  = $general_setting->site_from_email;
        $mailbody['Subject']    = $general_setting->site_name."-".$pdf_name1." - Your ASIN PDF";
        $mailbody['Message']    = $message;

        $mail_result = $this->EmailSend($mailbody);
        echo '<pre>'; print_r($mail_result); echo '</pre>'; exit;
    }


    // public function UpdateorderCron()
    // {
    //         $sellerid = "A32I6ZDTKWTZEK";
    //         $refresh_token = "Atzr|IwEBIAPp7WFl60gLNg7Ohzhv5aDfuh5XP-dBvdZNoaJq7EIUe9yncnS5iRkdw__3Rqqa_AecMcN9Bt0tgZ5QTxppZFexQ637jfwzXIHkPyY4udamrd06zPQAwQpcG3V0S3c0Qr4XoVZidY7975tffAbW-NH_j34k8C7GAiAlSh36v6bLLTZD0PPy1FRv8q7cG0Y6qUuZXPXX4saACjHrZ2oOjb3PU9F-jSAiCMzLtohlDxTBKK_LLkYd8yP7bZREh9I84GsFUFaFyZacQunDybx6BC2bTeaf_wAaqX6nlaSxMbaFHQ";
    //         $client_id = "amzn1.application-oa2-client.01a1b72cd4d643c59687bce2d9247ec5";
    //         $client_secret = "0c6b3fed31bbf46307019f021f16b70c4ce9d94319aef2bf9faa2bcf813ef215";

    //         $config = [
    //             //Guzzle configuration
    //             'http' => [
    //                 'verify' => false, //<--- NOT SAFE FOR PRODUCTION
    //                 //'debug' => true       //<--- NOT SAFE FOR PRODUCTION
    //             ],

    //             //LWA: Keys needed to obtain access token from Login With Amazon Service
    //             'refresh_token' => $refresh_token,
    //             'client_id' => $client_id,
    //             'client_secret' => $client_secret,

    //             //STS: Keys of the IAM role which are needed to generate Secure Session
    //             // (a.k.a Secure token) for accessing and assuming the IAM role
    //             'access_key' => 'AKIATJORSRJFWPH7Z4A3',
    //             'secret_key' => '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',
    //             'role_arn' => 'arn:aws:iam::226462173771:role/SoleSolution_Role',

    //             //API: Actual configuration related to the SP API :)
    //             'region' => 'us-east-1',
    //             'host' => 'sellingpartnerapi-na.amazon.com',
    //         ];

    //         file_put_contents("aws-tokens", "");
    //         //Create token storage which will store the temporary tokens
    //         $tokenStorage = new DoubleBreak\Spapi\SimpleTokenStorage('aws-tokens');

    //         //Create the request signer which will be automatically used to sign all of the
    //         //requests to the API
    //         $signer = new DoubleBreak\Spapi\Signer();

    //         //Create Credentials service and call getCredentials() to obtain
    //         //all the tokens needed under the hood

    //         $credentials = new DoubleBreak\Spapi\Credentials($tokenStorage, $signer, $config);
    //         $cred = $credentials->getCredentials();

    //         $reportClient = new DoubleBreak\Spapi\Api\Orders($cred, $config);

    //         $result = $reportClient->getOrders([
    //             'MarketplaceIds' => 'A1AM78C64UM0Y8,A2EUQ1WTGCTBG2,ATVPDKIKX0DER',
    //             'CreatedAfter' => "2021-06-01",
    //             'CreatedBefore' => "2021-06-17",
    //         ]);
            
            
    //         echo count($result['payload']['Orders']);
            
    //         echo "<pre>";
    //         print_r($result['payload']['Orders']); exit;

    //         foreach ($result['payload']['Orders'] as $order) {
    //             $AmazonOrderId = $order['AmazonOrderId'];

    //             echo $AmazonOrderId."<br>";
    //             $check_duplicate = $this->crud->check_duplicate($this->table, array('AmazonOrderId' => $AmazonOrderId, 'isDelete' => 0, 'AmazonSellerId' => $sellerid));
    //             if (!$check_duplicate) {
    //                 $fieldInfo = array(
    //                     'AmazonSellerId' => $sellerid
    //                 );
    //                 $this->crud->update("amazon_orders",$fieldInfo,array("AmazonOrderId"=>$AmazonOrderId));
    //             }

    //             exit;
    //         }
    // }
}