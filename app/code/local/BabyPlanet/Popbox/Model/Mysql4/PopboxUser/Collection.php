<?php
  
class BabyPlanet_Popbox_Model_Mysql4_PopboxUser_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('popbox/popboxUser');
    }
}
