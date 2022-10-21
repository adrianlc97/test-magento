<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Flat\Pickup\Model\PickupFactory;

class Save extends Action
{
    const ADMIN_RESOURCE = 'Flat_Pickup::pickup';

    /**
     * @var pickupFactory $objectFactory
     */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param pickupFactory $objectFactory
     */
    public function __construct(
        Context $context,
        pickupFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $params = [];
            $objectInstance = $this->objectFactory->create();
            $idField = $objectInstance->getIdFieldName();
            if (empty($data[$idField])) {
                $data[$idField] = null;
            } else {
                $objectInstance->load($data[$idField]);
                $params[$idField] = $data[$idField];
            }
            $data['location']=implode(',', $data['location']);
            $data['shipping_method']=implode(',', $data['shipping_method']);
            $objectInstance->addData($data);

            $this->_eventManager->dispatch(
                'flat_pickup_pickup_prepare_save',
                ['object' => $this->objectFactory, 'request' => $this->getRequest()]
            );

            try {
                $objectInstance->save();
                $this->messageManager->addSuccessMessage(__('You saved this record.'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $params = [$idField => $objectInstance->getId(), '_current' => true];
                    return $resultRedirect->setPath('*/*/edit', $params);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the record.'));
            }

            $this->_getSession()->setFormData($this->getRequest()->getPostValue());
            return $resultRedirect->setPath('*/*/edit', $params);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
