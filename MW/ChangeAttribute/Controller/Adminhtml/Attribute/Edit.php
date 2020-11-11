<?php
namespace MW\ChangeAttribute\Controller\Adminhtml\Attribute;


use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;

class Edit extends Action{

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_setActiveMenu('Magento_Catalog::catalog_products');
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__('Import'));
        $this->_view->renderLayout();
    }
}
