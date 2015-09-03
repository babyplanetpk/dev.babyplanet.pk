<?php

class Babyplanet_Popbox_IndexController extends Mage_Core_Controller_Front_Action {    
    public function indexAction()
    {
		$arg = $this->getRequest()->getParam('which');
		$model = Mage::getModel('popbox/popbox');
		$popup = $model->load($arg, 'title');
		$status = $popup->getData('status');
		if ($status) {
			$content = $popup->getData('content');
			echo $content;
		}
            //$this->loadLayout();
            //$this->renderLayout();
    }

    public function saveDataAction() {
		$name         = $this->getRequest()->getParam('name');
		$email        = $this->getRequest()->getParam('email');
		$child_name   = $this->getRequest()->getParam('child');
		$child_dob    = $this->getRequest()->getParam('dob');
		$child_gender = $this->getRequest()->getParam('gender');
		$phone = $this->getRequest()->getParam('phone');

		$data = array('name'=> $name,'email'=> $email,'child_name'=>$child_name,'child_dob'=>$child_dob,'child_gender'=>$child_gender,'phone_number'=>$phone);
		$model = Mage::getModel('popbox/popboxUser')->setData($data);
		try {
		    $insertId = $model->save()->getId();
		    //echo "Data successfully inserted. Insert ID: ".$insertId;
		} catch (Exception $e){
		 //echo $e->getMessage();   
		}
    }  
}
