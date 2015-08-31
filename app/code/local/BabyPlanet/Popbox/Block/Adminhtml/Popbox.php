<?php
  
class BabyPlanet_Popbox_Block_Adminhtml_Popbox extends Mage_Adminhtml_Block_Widget_Grid_Container 
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_popbox';
        $this->_blockGroup = 'popbox';
        $this->_headerText = Mage::helper('popbox')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('popbox')->__('Add Item');
        parent::__construct();
    }
}
