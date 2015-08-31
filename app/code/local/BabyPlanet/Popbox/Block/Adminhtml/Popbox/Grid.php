<?php
  
class BabyPlanet_Popbox_Block_Adminhtml_Popbox_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('popboxGrid');
        // This is the primary key of the database
        $this->setDefaultSort('popbox_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
  
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('popbox/popbox')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
  
    protected function _prepareColumns()
    {
        $this->addColumn('popbox_id', array(
            'header'    => Mage::helper('popbox')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'popbox_id',
        ));
  
        $this->addColumn('title', array(
            'header'    => Mage::helper('popbox')->__('Title'),
            'align'     =>'left',
            'index'     => 'title',
        ));
  
        /*
        $this->addColumn('content', array(
            'header'    => Mage::helper('popbox')->__('Item Content'),
            'width'     => '150px',
            'index'     => 'content',
        ));
        */
  
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('popbox')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'created_time',
        ));
  
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('popbox')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'update_time',
        ));   
  
  
        $this->addColumn('status', array(
  
            'header'    => Mage::helper('popbox')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
  
        return parent::_prepareColumns();
    }
  
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
  
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
  
  
}
