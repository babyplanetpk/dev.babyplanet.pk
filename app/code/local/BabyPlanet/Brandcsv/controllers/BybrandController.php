<?php

class Babyplanet_Brandcsv_BybrandController extends Mage_Core_Controller_Front_Action {

	public function brandcsvSelectedOrdersAction() {
		
		$filename = "OrderSheet " . date('d:m:Y') . ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$orderIds = $this->getRequest()->getPost('id');
		$brand = $this->getRequest()->getPost('brand');
		
		//$data[] = array( 0 => 'Order Id', 1 => 'Customer Name', 3 => 'Email', 4 => 'Status', 5 => 'Address', 6 => 'No', 7 => 'Product', 8 => 'Sku', 9 => 'Price', 10 => 'Qty', 11 => 'Total', 12 => 'Shipment', 13 => 'Grand Total', 14 => 'brand');
		$data[] = array( 0 => 'Product Name', 1 => 'SKU', 2 => 'Size - Color', 3 => 'Qty', 4 => 'Price', 5 => 'Total');		

		foreach ($orderIds as $orderId) {
			
			$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
			$addressDetails = $order->getShippingAddress()->getData();
			$items = $order->getAllVisibleItems();
			
			foreach($items as $item) {
				$price = Mage::helper('core')->formatPrice($item->getPrice());
				$price = str_replace(',', '', $price);
				$price = substr($price, 23, -7);
				
				$product = Mage::getModel('catalog/product')->load($item->getProductId());
 
				if ( $brand == $product->getAttributeText('manufacturer')) {
				
					//$data[] = array( 0 => $order->getIncrementId(), 1 => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(), 3 => $order->getCustomerEmail(), 4 => $order->getStatus(), 5 => $addressDetails['street'] . ' ' . $addressDetails['city'], 6=> $order->getShippingAddress()->getTelephone(), 7 => $item->getName(), 8 => $item->getSku(), 9 => $price, 10 => substr($item->getQtyOrdered(), 0, -5), 11 => $item->getQtyOrdered() * $price, 12 => $order->getShippingAmount(), 13 => $order->getGrandTotal(), 14 => $brand);
					$data[] = array( 0 => $item->getName(), 1 => $item->getSku(), 2 => substr( $this->getItemOptions($item) , 5 ), 3 => substr($item->getQtyOrdered(), 0, -5), 4 => $price, 5 => $item->getQtyOrdered() * $price );
					
				}
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
