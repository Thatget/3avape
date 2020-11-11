<?php

namespace MW\ChangeAttribute\Block\Adminhtml\Attribute\Edit;

class Form extends \Magento\Backend\Block\Widget\Form\Generic
{
    /**
     * @return $this
     */
    protected function _prepareForm()
    {
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'    => 'edit_form',
                    'action' => $this->getUrl('*/*/save',
                        [
                            'id' => $this->getRequest()->getParam('id'),
                            'store' => $this->getRequest()->getParam('store')
                        ]
                    ),
                    'method' => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $fieldset = $form->addFieldset('general_fieldset', ['legend' => __('Import Information')]);

        $fieldset->addField(
            'filecsv',
            'file',
            [
                'title'    => __('Import File'),
                'label'    => __('Import File'),
                'name'     => 'filecsv',
                'required' => true
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
