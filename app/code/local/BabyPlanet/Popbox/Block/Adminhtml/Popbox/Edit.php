<?php
  
class BabyPlanet_Popbox_Block_Adminhtml_Popbox_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                
        $this->_objectId = 'id';
        $this->_blockGroup = 'popbox';
        $this->_controller = 'adminhtml_popbox';
  
        $this->_updateButton('save', 'label', Mage::helper('popbox')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('popbox')->__('Delete Item'));
    }
  
    public function getHeaderText()
    {
        if( Mage::registry('popbox_data') && Mage::registry('popbox_data')->getId() ) {
            return Mage::helper('popbox')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('popbox_data')->getTitle()));
        } else {
            return Mage::helper('popbox')->__('Add Item');
        }
    }
}
