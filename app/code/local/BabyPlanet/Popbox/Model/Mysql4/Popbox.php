<?php
  
class BabyPlanet_Popbox_Model_Mysql4_Popbox extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('popbox/popbox', 'popbox_id');
    }
}
