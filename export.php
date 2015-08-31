<?php

	require_once("app/Mage.php");
	umask(0);
	Mage::app("default");
	
	error_reporting(E_ALL | E_STRICT);
	ini_set('display_errors', 1);
	Mage::init();
	
	// Set an Admin Session
	Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
	Mage::getSingleton('core/session', array('name' => 'adminhtml'));
	$userModel = Mage::getModel('admin/user');
	$userModel->setUserId(1);
	$session = Mage::getSingleton('admin/session');
	$session->setUser($userModel);
	$session->setAcl(Mage::getResourceModel('admin/acl')->loadAcl());
	
	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	
	/* Get orders collection of pending orders, run a query */
			$collection = Mage::getModel('sales/order')
							->getCollection()
					//      ->addFieldToFilter('state',Array('eq'=>Mage_Sales_Model_Order::STATE_NEW))
							->addAttributeToSelect('*');
	
	$out = '<?xml version="1.0" encoding="windows-1250" ?>
	<dataPack id="order001" version="2.0" note="Import Order">';
	
	foreach($collection as $order)
	{
		
		if ($billingAddress = $order->getBillingAddress()) {
			$billingStreet = $billingAddress->getStreet();
		}
		
		if ($shippingAddress = $order->getShippingAddress()){
			$shippingStreet = $shippingAddress->getStreet();
		}
	
		$out .= "<dataPackItem  version=\"2.0\">\n";
		//$out .= "<dataPackItemversion=\"1.0\">\n";
				$out.= "<order>\n";
	
					$out.= "<orderHeader>\n";
						$out.= "<orderType>receivedOrder</orderType>\n";
						$out.= "<numberOrder>".$order->getIncrementId()."</numberOrder>\n";
						$out.= "<date>".date('Y-m-d',strtotime($order->getCreatedAt()))."</date>\n";
						$out.= "<dateFrom>".date('Y-m-d',strtotime($order->getCreatedAt()))."</dateFrom>\n";
						$out.= "<dateTo>".date('Y-m-d',strtotime($order->getCreatedAt()))."</dateTo>\n";
						$out.= "<text>Objednávka z internetového obchodu</text>\n";
						$out.= "<partnerIdentity>\n";
							$out.= "<address>\n";
								$out.= "<company>{$billingAddress->getCompany()}</company>\n";
								$out.= "<division></division>\n";
								$out.= "<name>{$billingAddress->getName()}</name>\n";
								$out.= "<city>{$billingAddress->getCity()}</city>\n";
								$out.= "<street>{$billingStreet[0]}</street>\n";
								$out.= "<zip>{$billingAddress->getPostcode()}</zip>\n";
							$out.= "</address> \n";
							$out.="<shipToAddress>\n";
								/*$out.= "<company>{$shippingAddress->getCompany()}</company>\n";*/
								$out.= "<division></division>\n";
								/*$out.= "<name>{$shippingAddress->getName()}</name>\n";*/
								/*$out.= "<city>{$shippingAddress->getCity()}</city>\n";*/
								$out.= "<street>{$shippingStreet[0]}</street>\n";
								/*$out.= "<zip>{$shippingAddress->getPostcode()}</zip>\n";*/
							$out.= "</shipToAddress>\n";
						$out.= "</partnerIdentity>\n";
						$out.= "<paymentType> \n";
							$out.= "<ids>{$order->getShippingDescription()}</ids>\n";
						$out.= "</paymentType>\n";
						$out.= "<priceLevel>\n";
							$out.= "<ids></ids>\n";
						$out.= "</priceLevel>\n";
					$out.= "</orderHeader>\n";
					$out.= "<orderDetail> \n";
					foreach ($order->getAllItems() as $itemId => $item){
						// textova polozka
						$out.= "<orderItem> \n";
							$itemname =  $item->getName();
				$itemname =  str_replace('&', " ", $itemname);
				$out.= "<text>{$itemname}</text> \n";
							$out.= "<quantity>{$item->getQtyOrdered()}</quantity>\n";
							//$out.= "<delivered></delivered>";
							$out.= "<rateVAT>high</rateVAT> \n";
							$out.= "<homeCurrency> \n";
								$out.= "<unitPrice>{$item->getPrice()}</unitPrice>\n";
							$out.= "</homeCurrency>\n";
							$out.= "<stockItem>\n";
								$out.= "<stockItem>\n";
									$out.= "<ids>{$item->getSku()}</ids>\n";
								$out.= "</stockItem>\n";
							$out.= "</stockItem>\n";
						$out.= "</orderItem>\n";
					}
					$out.= "</orderDetail>\n";
					$out.= "<orderSummary>\n";
						$out.= "<roundingDocument>math2one</roundingDocument>\n";
					$out.= "</orderSummary>\n";
				$out.= "</order>\n";
			$out.= "</dataPackItem>\n\n";
	};
	
	$out.= "</dataPack>\n";
	
	header ("Content-Type:text/xml");
	header ('char-set: cp1250');
	@file_put_contents('./dl/response/'.microtime(true).'.txt', $out);
	@file_put_contents('php://output', $out);