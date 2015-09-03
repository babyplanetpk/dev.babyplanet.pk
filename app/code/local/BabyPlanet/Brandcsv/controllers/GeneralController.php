<?php

class Babyplanet_Brandcsv_GeneralController extends Mage_Core_Controller_Front_Action {

	public function brandcsvSelectedOrdersAction() {
		
		$filename = "OrderSheet " . date('d:m:Y') . ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$orderIds = $this->getRequest()->getPost('id');
		
		$data[] = array( 0 => 'Order Id', 1 => 'Customer Name', 2 => 'Email', 3 => 'Status', 4 => 'Address', 5 => 'No', 6 => 'Product', 7 => 'Sku', 8 => 'Price', 9 => 'Qty', 10 => 'Total', 11 => 'Shipment', 12 => 'Grand Total', 13 => 'Item Option');
		
		foreach ($orderIds as $orderId) {
			
			$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
			$addressDetails = $order->getShippingAddress()->getData();
			$items = $order->getAllVisibleItems();
			
			$orderCount = 1;
			foreach($items as $item) {
				$price = Mage::helper('core')->formatPrice($item->getPrice());
				$price = str_replace(',', '', $price);
				$price = substr($price, 23, -7);
				
				$product = Mage::getModel('catalog/product')->load($item->getProductId());
 				if ($orderCount == 1) {
 					$data[] = array( 0 => $order->getIncrementId(), 1 => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(), 2 => $order->getCustomerEmail(), 3 => $order->getStatus(), 4 => $addressDetails['street'] . ' ' . $addressDetails['city'], 5 => $order->getShippingAddress()->getTelephone(), 6 => $item->getName(), 7 => $item->getSku(), 8 => $price, 9 => substr($item->getQtyOrdered(), 0, -5), 10 => $item->getQtyOrdered() * $price, 11 => $order->getShippingAmount(), 12 => $order->getGrandTotal(), 13 => substr( $this->getItemOptions($item), 6) );
 				} else {
 					$data[] = array( 0 => '', 1 => '', 2 => '', 3 => '', 4 => '', 5 => '', 6 => $item->getName(), 7 => $item->getSku(), 8 => $price, 9 => substr($item->getQtyOrdered(), 0, -5), 10 => $item->getQtyOrdered() * $price, 11 => $order->getShippingAmount(), 12 => $order->getGrandTotal(), 13 => substr( $this->getItemOptions($item), 6) );
 				} $orderCount++;
				
			}
			
		}
			
		$out = fopen("php://output", 'w');
		foreach ($data as $row) {
			fputcsv($out, $row,"\t");
		}
		fclose($out);
		
    }

    protected function getItemOptions($item) {
        $options = '';
        if ($orderOptions = $this->getItemOrderOptions($item)) {
            foreach ($orderOptions as $_option) {
                if (strlen($options) > 0) {
                    $options .= ', ';
                }
                $options .= $_option['label'].': '.$_option['value'];
            }
        }
        return $options;
    }
    
    protected function getItemOrderOptions($item) {
        $result = array();
        if ($options = $item->getProductOptions()) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }
            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }
            if (!empty($options['attributes_info'])) {
                $result = array_merge($options['attributes_info'], $result);
            }
        }
        return $result;
    }

}
