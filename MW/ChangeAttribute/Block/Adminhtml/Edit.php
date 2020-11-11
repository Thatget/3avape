<?php
namespace MW\ChangeAttribute\Block\Adminhtml;

class Edit extends \Magento\Backend\Block\Widget\Form\Container{
    protected function _construct()
    {
        $this->_objectId   = 'id';
        $this->_blockGroup = 'MW_ChangeAttribute';
        $this->_controller = 'adminhtml_attribute';

        parent::_construct();
    }
}
