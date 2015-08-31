<?php

class Babyplanet_Performa_IndexController extends Mage_Core_Controller_Front_Action {    

	public function indexAction() {
		
		Mage::getSingleton('core/session')->setParameter('first');
		$this->loadLayout();
		$this->renderLayout();	
    }   

	public function performaAction() {
		
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

	public function performaSelectedOrdersAction() {
		
		$orderIds = $this->getRequest()->getPost('id');
		
		foreach ($orderIds as $orderId) {
			
			$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
			$addressDetails = $order->getShippingAddress()->getData();
			
			$tempOrderID  = $order->getIncrementId();
			$tempName     = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
			$tempEmail    = $order->getCustomerEmail();
			$tempCity     = $addressDetails['city'];
			$tempAddress  = $addressDetails['street'];
			$tempPhone    = $order->getShippingAddress()->getTelephone();
			$tempAmount   = $order->getGrandTotal();

			    //-----------	CURL Get City ID Start ----------------
				$tempCityID = 0;

				$curl_handle = curl_init();			
				curl_setopt($curl_handle, CURLOPT_URL, 'http://leopardscod.com/webservice/getAllCitiesTest/format/json/');
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('api_key' => 'D7140E0AEF5B7EBABFADBF2E5E0DB96F','api_password' => '!23$AHMED'));
				
				$buffer1 = curl_exec($curl_handle);
				$temp;
				
				$objson1 = json_decode($buffer1, true);
				$i = 0;
				foreach($objson1 AS $prop => $val1) 
				{
					if($i < 2 ){	$i++;	}
					else{
						$temp1 = $val1;
						break;
					}
				}
				foreach ($temp1 as &$value1) {
					if (strcasecmp($tempCity, $value1['name']) == 0) 
					{
    					$tempCityID = $value1['id'];
						break;
					}			
				}			
				curl_close($curl_handle);
				
				//-----------	 CURL End  ----------------
				
				//========================	CURL Book Packet Start	===============
				
				if($tempCityID != 0)
				{
					$curl_handle = curl_init();
					
					curl_setopt($curl_handle, CURLOPT_URL, 'http://www.leopardscod.com/webservice/bookPacketTest/format/json/');
					curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl_handle, CURLOPT_POST, 1);
					curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array(
						'api_key' => 'D7140E0AEF5B7EBABFADBF2E5E0DB96F',
						'api_password' => '!23$AHMED',
						'booked_packet_weight' => 450,                 
						'booked_packet_vol_weight_w' => NULL,
						'booked_packet_vol_weight_h' => NULL, 
						'booked_packet_vol_weight_l' => NULL,
						'booked_packet_no_piece' => 1,       
						'booked_packet_collect_amount' => $tempAmount,          
						'booked_packet_order_id' => $tempOrderID,           
						
						'origin_city' => 'self', 
						'destination_city' => $tempCityID, 
						'shipment_name_eng' => 'self', 
						'shipment_email' => 'self',        
						'shipment_phone' => 'self',                      
						'shipment_address' => 'self',                 
						'consignment_name_eng' => $tempName,           
						'consignment_email' => $tempEmail,               
						'consignment_phone' => $tempPhone, 
						'consignment_phone_two' => NULL, 
						'consignment_phone_three' => NULL,
						'consignment_address' => $tempAddress,     
						'special_instructions' => 'string',
					));
					
					$buffer = curl_exec($curl_handle);
					$objson2 = json_decode($buffer1, true);

					if($objson2['status'] == 1)
						$delivery_Report = "Delivered";
					else if($objson2['status'] != 1)
						$delivery_Report = "Not Delivered";

					echo "<br /><strong>";
					echo $tempOrderID;
					echo "  ";
					echo $delivery_Report;
					echo "</strong><br />";
					curl_close($curl_handle);
				}
				//========================   CURL End	===============		
		}
		
    }s

}
