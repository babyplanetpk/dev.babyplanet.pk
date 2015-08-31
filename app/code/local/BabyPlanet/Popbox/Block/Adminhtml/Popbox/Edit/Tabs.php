<?php
  
class BabyPlanet_Popbox_Block_Adminhtml_Popbox_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('popbox_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('popbox')->__('News Information'));
    }
  
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('popbox')->__('Item Information'),
            'title'     => Mage::helper('popbox')->__('Item Information'),
            'content'   => $this->getLayout()->createBlock('popbox/adminhtml_popbox_edit_tab_form')->toHtml(),
        ));
        
        return parent::_beforeToHtml();
    }
}
