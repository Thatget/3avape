<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace MW\TestImport\Controller\Adminhtml\Quote;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\SalesRule\Model\ResourceModel\Rule\CollectionFactory;
use Magento\SalesRule\Model\RuleFactory;


class MassChange extends \Magento\SalesRule\Controller\Adminhtml\Promo\Quote implements HttpPostActionInterface
{

    /**
     * @var RuleFactory
     */
    protected $ruleFactory;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @param RuleFactory $ruleFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter,
        CollectionFactory $collectionFactory,
        ResultFactory $ruleFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->ruleFactory = $ruleFactory;
        parent::__construct($context, $coreRegistry, $fileFactory, $dateFilter);
    }

    /**
     * Update rule(s) status action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        try {
            $collection = $this->collectionFactory->create();
            $allID = $this->getRequest()->getParam('rule_id');
            if (!is_array($allID)) {
                $allID = [];
            }
            foreach ($collection as $rule){
                if (in_array($rule->getId(),$allID)){
                    $chekc = $rule->getIsActive();
                    if ($chekc == 0) {
                        $rule->setIsActive(1);
                    } else {
                        $rule->setIsActive(0);
                    }
                    $rule->save();
                }
            }
        }catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('An error occurred while change status.'));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('sales_rule/promo_quote/index');
    }
}
