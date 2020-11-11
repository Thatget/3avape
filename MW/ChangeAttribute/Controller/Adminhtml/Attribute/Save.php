<?php

namespace MW\ChangeAttribute\Controller\Adminhtml\Attribute;

use Magento\Backend\App\Action;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\File\Csv;
use Magento\Setup\Exception;

class Save extends  \Magento\Backend\App\Action
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Csv
     */
    protected $csvObject;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Action\Context $context,
        ProductRepositoryInterface $productRepository,
        Csv $csvObject
    )
    {
        $this->productRepository = $productRepository;
        $this->csvObject = $csvObject;
        parent::__construct($context);
    }

    public function execute()
    {
        if (isset($_FILES['filecsv'])) {
            if (substr($_FILES['filecsv']['name'], -4) != '.csv') {
                $this->messageManager->addError('Please choose a CSV file');
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
            $storeId = (int)$this->getRequest()->getParam('store',0);
            $fileName = $_FILES['filecsv']['tmp_name'];
            $csvData = $this->csvObject->getData($fileName);
            $attribute = array();
            for ($j = 1;$j < count($csvData[0]);$j++){
                $attribute[$j] = $csvData[0][$j];
            }
            for ($i = 1;$i < count($csvData);$i++) {
                try {
                        $product = $this->productRepository->get($csvData[$i][0],false, $storeId,true);
                        foreach ($attribute as $key => $value) {
                            //$product->setCustomAttribute($value, 1);
                            $product->addAttributeUpdate($value, 0,$storeId);
                            //$product->setCustomAttribute($value, $csvData[$i][$key]);
                        }
                        //$product->save($product);
                } catch (\Exception $exception) {
                }
            }
            $this->messageManager->addSuccess(__('Save successful !'));
            return $this->_redirect('*/*/edit');
        }
        $this->messageManager->addError(__('File doesn\'t exit'));
        return $this->_redirect('*/*/edit');
    }
}
