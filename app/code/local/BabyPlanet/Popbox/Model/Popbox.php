<?php
  
class BabyPlanet_Popbox_Model_Popbox extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('popbox/popbox');
    }
}
