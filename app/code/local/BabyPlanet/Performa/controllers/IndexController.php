<?php

class Babyplanet_Performa_IndexController extends Mage_Core_Controller_Front_Action {    

	public function indexAction() {
		
		Mage::getSingleton('core/session')->setParameter('first');
		$this->loadLayout();
		$this->renderLayout();	
		
    }   
	/* public function indexAction() {
		
		Mage::getSingleton('core/session')->setParameter('first');
		$this->loadLayout();
		$this->renderLayout();	
		
    }   */

    //===========================================================================================
	//===========================================================================================
	//--------------------------	Additional Functions	-------------------------------------
	//===========================================================================================
	/*
	protected function bookPacket()
	{
		$tempCity = $this->_getCity();
		$tempCityID = 0;
			if($tempCity != 'Lahore' && $tempCity != 'lahore' && $tempCity != 'LAHORE' && $tempCity != 'lhr' && $tempCity != 'LHR')
			{	
				//-----------	CURL Start ----------------
				
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
					
				$tempTotalAmount = $this->_getTotalAmount();
				$tempName = $this->_getCustomerName();
				$tempEmail = $this->_getCustomerEmail();
				$tempPhone = $this->_getCustomerPhone();
				$tempAddress = $this->_getCustomerAddress();
				
				/*$link1 = mysql_connect('localhost', 'abdullah', '4328854');
				$db_selected = mysql_select_db('bp', $link1);
				
				$query2 = "INSERT INTO temp(col,  weight ,  no_pieces ,  collection_amount  ,  origin_city ,  dest_city ,  shipment_name ,  shipment_email ,  shipment_phone ,  shipment_address ,  consignment_name ,  consignment_email ,  consignment_phone ,  consignment_address ,  instructions ) VALUES ('".$tempCityID."','1','1','".$tempTotalAmount."','Lahore','".$tempCity."','self','self','self','self','".$tempName."','".$tempEmail."','".$tempPhone."','".$tempAddress."','Be CareFull With The Pakage')";
				$result1 = mysql_query($query2);
	
				mysql_close($link1);*/
				
				//========================	CURL Start	===============
				/*
				if($tempCityID != 0)
				{
					$curl_handle = curl_init();
					
					curl_setopt($curl_handle, CURLOPT_URL, 'http://leopardscod.com/webservice/bookPacket/format/json/');
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
						'booked_packet_collect_amount' => $tempTotalAmount,          
						'booked_packet_order_id' => NULL,           
						
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
					curl_close($curl_handle);
				}
				//========================   CURL End	===============			
			}
	}
	
	
	protected function _getCity()
    {
		$billing_Address = $this->_getQuote()->getBillingAddress();
		$city = $billing_Address->getCity();
		return $city;
    }
	protected function _getTotalAmount()
    {
		$totalAmount1 = $this->_getQuote()->getGrandTotal();
		return $totalAmount1;
    }
	protected function _getCustomer()
    {
		$customer1 = Mage::getSingleton('customer/session')->getCustomer();
		return $customer1;
    }
	protected function _getCustomerName()
    {
		$name1 = $this->_getCustomer()->getName();
		return $name1;
    }
	protected function _getCustomerEmail()
    {
		$email1 = $this->_getCustomer()->getEmail();
		return $email1;
    }
	protected function _getCustomerPhone()
    {
		$phone1 = $this->_getCustomer()->getPrimaryBillingAddress()->getTelephone();
		return $phone1;
    }
	protected function _getCustomerAddress()
    {
		//$address1 = $this->_getQuote()->getBillingAddress();
		//$address2 = $address1->getData();
		
		$customerAddressId1 = $this->_getCustomer()->getDefaultShipping();
		if ($customerAddressId1)
		{
		$address2 = Mage::getModel('customer/address')->load($customerAddressId1);
		$address1 = $address2->getStreet();
    	$address0 = $address1[0];
		}
		return $address0;
    }*/











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
		
    }

////////////////////////////////////////////////////////////////////////////////////////////////////
/*
	public function testingAction() {
		
		$orderIds = array( 0 => '200000001', 1 => '200000002', 2 => '200000003', 3 => '200000004' );

		foreach ($orderIds as $orderId) {
			
			$order = Mage::getModel('sales/order')->loadByIncrementId($orderId);
			$addressDetails = $order->getShippingAddress()->getData();
			
			$tempOrderID = $order->getIncrementId();
			$tempName = $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname();
			$tempEmail = $order->getCustomerEmail();
			$tempCity = $addressDetails['city'];
			$addressDetails['street'] . ' ' . $addressDetails['city'];
			$tempPhone =$order->getShippingAddress()->getTelephone();
			$tempAddress = $order->getShippingAmount();
			$tempTotalAmount = $order->getGrandTotal();

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
						'booked_packet_collect_amount' => $tempTotalAmount,          
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
		
    }*/

}
