<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Controller\Adminhtml\Pickup;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Flat\Pickup\Api\PickupRepositoryInterface;
use Flat\Pickup\Model\Pickup;

/**
 * Grid inline edit controller
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class InlineEdit extends Action
{
    const ADMIN_RESOURCE = 'Flat_Pickup::pickup';

    /**
     * @var JsonFactory
     */
    private $jsonFactory;

    /**
     * @var PickupRepositoryInterface
     */
    private $repository;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     * @param PickupRepositoryInterface $repository
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory,
        PickupRepositoryInterface $repository
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->repository = $repository;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        try {
            foreach (array_keys($postItems) as $pickupId) {
                /** @var  Pickup $pickup */
                $pickup = $this->repository->getById($pickupId);
                $pickup->setData(array_merge($pickup->getData(), $postItems[$pickupId]));
                $this->repository->save($pickup);
            }
        } catch (Exception $e) {
            $messages[] = __('There was an error saving the data: ') . $e->getMessage();
            $error = true;
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }
}
