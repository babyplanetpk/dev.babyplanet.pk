<?php
  
class BabyPlanet_Popbox_Block_Adminhtml_Popbox_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('popbox_form', array('legend'=>Mage::helper('popbox')->__('Item information')));
        
        $fieldset->addField('title', 'text', array(
            'label'     => Mage::helper('popbox')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'title',
        ));
  
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('popbox')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('popbox')->__('Active'),
                ),
  
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('popbox')->__('Inactive'),
                ),
            ),
        ));
        
        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => Mage::helper('popbox')->__('Content'),
            'title'     => Mage::helper('popbox')->__('Content'),
            'style'     => 'width:98%; height:400px;',
            'wysiwyg'   => false,
            'required'  => true,
        ));
        
        if ( Mage::getSingleton('adminhtml/session')->getPopboxData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getPopboxData());
            Mage::getSingleton('adminhtml/session')->setPopboxData(null);
        } elseif ( Mage::registry('popbox_data') ) {
            $form->setValues(Mage::registry('popbox_data')->getData());
        }
        return parent::_prepareForm();
    }
}
