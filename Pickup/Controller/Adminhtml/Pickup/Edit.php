<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Flat\Pickup\Model\PickupFactory;

class Edit extends Action
{
    const ADMIN_RESOURCE = 'Flat_Pickup::pickup';

    /**
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var pickupFactory $objectFactory
     */
    protected $objectFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param Registry $registry
     * @param pickupFactory $objectFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        pickupFactory $objectFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->objectFactory = $objectFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $objectInstance = $this->objectFactory->create();

        if ($id) {
            $objectInstance->load($id);
            if (!$objectInstance->getId()) {
                $this->messageManager->addErrorMessage(__('This record no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_session->getFormData(true);
        if (!empty($data)) {
            $objectInstance->addData($data);
        }

        $this->_coreRegistry->register('entity_id', $id);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Flat_Pickup::pickup');
        $resultPage->getConfig()->getTitle()->prepend(__('Pickup Edit'));

        return $resultPage;
    }
}
