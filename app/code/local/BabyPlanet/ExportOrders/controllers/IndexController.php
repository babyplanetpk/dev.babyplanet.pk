<?php

class Babyplanet_ExportOrders_IndexController extends Mage_Core_Controller_Front_Action {    

	public function indexAction() {
		
		Mage::getSingleton('core/session')->setParameter('first');
		$this->loadLayout();
		$this->renderLayout();	
		
    }   

	public function exportOrdersAction() {
		
		Mage::getSingleton('core/session')->setParameter('second');
		
		$this->loadLayout();		
		
		$status = $this->getRequest()->getPost('status');
		$fromDate = $this->getRequest()->getPost('from');
		$toDate = $this->getRequest()->getPost('to');
		$toDate = date_create($toDate);
		date_modify($toDate, '+1 day');
		$toDate = $toDate->format('Y-m-d');
		
		if ($status == 'pending') {
			$orders = Mage::getModel('sales/order')->getCollection()
				->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
				->addFieldToFilter('status', array('in' => array('pending')));
		} elseif ($status == 'process') {
			$orders = Mage::getModel('sales/order')->getCollection()
				->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
				->addFieldToFilter('status', array('in' => array('processing')));
		} elseif ($status == 'both') {
			$orders = Mage::getModel('sales/order')->getCollection()
				->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate))
				->addFieldToFilter('status', array('in' => array('pending','processing')));
		} elseif ($status == 'all') {			
			$orders = Mage::getModel('sales/order')->getCollection()
				->addAttributeToFilter('created_at', array('from'=>$fromDate, 'to'=>$toDate));
		}
		
		foreach ($orders as $order) {
			$orderIds[] = $order->getIncrementId();
		}
					
		Mage::register('orderIds', $orderIds);
		
		$this->renderLayout();
		
    } 

	public function exportSelectedOrdersAction() {
		
		$filename = "OrderSheet " . date('d:m:Y') . ".xls";
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header("Content-Type: application/vnd.ms-excel;");
		header("Pragma: no-cache");
		header("Expires: 0");
		
		$orderIds = $this->getRequest()->getPost('id');
		$brand = $this->getRequest()->getPost('brand');
		
		$data[] = array( 0 => 'Order Id', 1 => 'Customer Name', 3 => 'Email', 4 => 'Status', 5 => 'Address', 6 => 'No', 7 => 'Product', 8 => 'Sku', 9 => 'Price', 10 => 'Qty', 11 => 'Total', 12 => 'Shipment', 13 => 'Grand Total', 14 => 'brand');
		
		foreach ($orderIds as $orderId) {
			
			$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
			$addressDetails = $order->getShippingAddress()->getData();
			$items = $order->getAllVisibleItems();
			
			foreach($items as $item) {
				$price = Mage::helper('core')->formatPrice($item->getPrice());
				$price = substr($price, 23, -7);
				
				$product = Mage::getModel('catalog/product')->load($item->getProductId());
 
				if ( $brand == $product->getAttributeText('manufacturer')) {
				
					$data[] = array( 0 => $order->getIncrementId(), 1 => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(), 3 => $order->getCustomerEmail(), 4 => $order->getStatus(), 5 => $addressDetails['street'] . ' ' . $addressDetails['city'], 6=> $order->getShippingAddress()->getTelephone(), 7 => $item->getName(), 8 => $item->getSku(), 9 => $price, 10 => substr($item->getQtyOrdered(), 0, -5), 11 => $item->getQtyOrdered() * $price, 12 => $order->getShippingAmount(), 13 => $order->getGrandTotal(), 14 => $brand
					);
					
				}
			}
			
		}
			
		$out = fopen("php://output", 'w');
		foreach ($data as $row) {
			fputcsv($out, $row,"\t");
		}
		fclose($out);
		
    }

}