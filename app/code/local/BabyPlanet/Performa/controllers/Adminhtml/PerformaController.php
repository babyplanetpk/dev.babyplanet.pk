<?php
  
class BabyPlanet_Performa_Adminhtml_PerformaController extends Mage_Adminhtml_Controller_Action {
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('performa/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        return $this;
    }   
   
	public function indexAction() {
		
		Mage::getSingleton('core/session')->setParameter('first');
		$this->loadLayout();
		$this->renderLayout();	
		
    }   

	public function performaAction() {
		
		Mage::getSingleton('core/session')->setParameter('second');
		
		$this->loadLayout();		
		
		$status = $this->getRequest()->getPost('stsatus');
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
			
			$addressDetails = $order->getShippingAddress()->getData();

			$orderData[] = array(
							'id' => $order->getIncrementId(),
							'customer' => $order->getCustomerFirstname() . ' ' . $order->getCustomerLastname(),
							'address' => $addressDetails['street'],
							'city' => $addressDetails['city'],
							'phone' => $order->getShippingAddress()->getTelephone(),
							'weight' => '450',
							'price' => $order->getGrandTotal(),
							'email' => $order->getCustomerEmail()
						);
		}

		Mage::register('orderData', $orderData);
		
		$this->renderLayout();
		
    } 

	public function performaSelectedOrdersAction() {
		
		$orderIds = $this->getRequest()->getPost('id');
		$price = $this->getRequest()->getPost('price');
		$weight = $this->getRequest()->getPost('weight');
		$address = $this->getRequest()->getPost('address');
		$city = $this->getRequest()->getPost('city');
		$phone = $this->getRequest()->getPost('phone');
		$email = $this->getRequest()->getPost('email');
		$name = $this->getRequest()->getPost('name');

		Mage::getSingleton('core/session')->setParameter('third');
		
		$this->loadLayout();		
		
		foreach ($orderIds as $key => $orderId) {
			

			$tempOrderID  = $orderId;
			$tempName     = $name[$key];
			$tempEmail    = $email[$key];
			$tempCity     = $city[$key];
			$tempAddress  = $address[$key];
			$tempPhone    = $phone[$key];
			$tempAmount   = $price[$key];
			$tempWeight   = $weight[$key];

			//-----------	CURL Get City ID Start ----------------
				 
			$curl_handle = curl_init();			
			curl_setopt($curl_handle, CURLOPT_URL, 'http://leopardscod.com/webservice/getAllCities/format/json/');
			curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl_handle, CURLOPT_POST, 1);
			curl_setopt($curl_handle, CURLOPT_POSTFIELDS, array('api_key' => 'D7140E0AEF5B7EBABFADBF2E5E0DB96F','api_password' => '!23$AHMED'));
				
			//getting curl data into the array in JSon format
			$curl_result = curl_exec($curl_handle);
				
			//decoding JSon into Human readable format
			$obj = json_decode($curl_result, true);
				
			$city_list = $obj[city_list];

			foreach ($city_list as $customerCity) {

				if ( (strcasecmp($tempCity, $customerCity['name'])) == 0) {
    				$cityID = $customerCity['id'];
					break;
				}		
			}

			curl_close($curl_handle);

			//-----------	 CURL End  ----------------
				
			//========================	CURL Book Packet Start	===============
			
			if( !empty($cityID) ) {
				
				$curl_handle = curl_init();
					
				curl_setopt($curl_handle, CURLOPT_URL, 'http://www.leopardscod.com/webservice/bookPacket/format/json/');
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($curl_handle, CURLOPT_POST, 1);
				curl_setopt($curl_handle, CURLOPT_POSTFIELDS,
					array(
						'api_key' => 'D7140E0AEF5B7EBABFADBF2E5E0DB96F',
						'api_password' => '!23$AHMED',
						'booked_packet_weight' => $tempWeight,                 
						'booked_packet_vol_weight_w' => NULL,
						'booked_packet_vol_weight_h' => NULL, 
						'booked_packet_vol_weight_l' => NULL,
						'booked_packet_no_piece' => 1,       
						'booked_packet_collect_amount' => $tempAmount,          
						'booked_packet_order_id' => $tempOrderID,           
						'origin_city' => 'self', 
						'destination_city' => $cityID, 
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
						'special_instructions' => 'string'
						)
					);
					
				//getting curl data of single item into the array in JSon format
				$curl_result_single = curl_exec($curl_handle);
				//decoding curl data of single JSon into Human readable format
				$obj_single = json_decode($curl_result_single, true);
				
				if($obj_single['status'] == 1) {

					$performa[] = array(
						'id' => $tempOrderID,
						'customer' => $tempName,
						'tracking' => $obj_single['track_number'],
						'link' => $obj_single['slip_link'],
						'error' => 'none'
						);

				} else {

					$performa[] = array(
						'id' => $tempOrderID,
						'customer' => $tempName,
						'tracking' => '',
						'link' => '',
						'error' => $obj_single['error']
						);
				}
				curl_close($curl_handle);
			
				//========================   CURL End	===============		
			}
			if ( empty($cityID) ) {

					$performa[] = array(
					'id' => $tempOrderID,
					'customer' => $tempName,
					'tracking' => '',
					'link' => '',
					'error' => 'mismatch'
					);
			}
		}
					
		Mage::register('performa', $performa);

		$this->renderLayout();
		
    }

}
