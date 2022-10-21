<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Controller\Adminhtml\Pickup;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Flat\Pickup\Model\PickupFactory;

class Delete extends Action
{
    const ADMIN_RESOURCE = 'Flat_Pickup::pickup';

    /**
     * @var pickupFactory $objectFactory
     */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param PickupFactory $objectFactory
     */
    public function __construct(
        Context $context,
        PickupFactory $objectFactory
    ) {
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('entity_id', null);

        try {
            $objectInstance = $this->objectFactory->create()->load($id);
            if ($objectInstance->getId()) {
                $objectInstance->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the record.'));
            } else {
                $this->messageManager->addErrorMessage(__('Record does not exist.'));
            }
        } catch (Exception $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }
        
        return $resultRedirect->setPath('*/*');
    }
}
