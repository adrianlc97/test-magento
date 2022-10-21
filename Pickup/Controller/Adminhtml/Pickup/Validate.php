<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Controller\Adminhtml\Pickup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class Validate extends Action
{
    const ADMIN_RESOURCE = 'Flat_Pickup::pickup';

    /**
     * @var JsonFactory $jsonFactory
     */
    protected $jsonFactory;

    /**
     * @var  \Magento\Framework\DataObject $response
     */
    protected $response;

    /**
     * @param Context $context
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        JsonFactory $jsonFactory
    ) {
        parent::__construct($context);
        $this->jsonFactory = $jsonFactory;
        $this->response = new \Magento\Framework\DataObject();
    }

    /**
     * Check if required fields is not empty
     *
     * @param array $data
     */
    public function validateRequireEntries(array $data)
    {
        $requiredFields = [
                    'name' => 'Name',
                            'direction' => 'Direction',
                            'latitude' => 'Latitude',
                            'longitude' => 'Longitude',
                            'location' => 'Location',
                            'shipping_method' => 'ShippingMethod',
                ];
        foreach ($data as $field => $value) {
            if (in_array($field, array_keys($requiredFields)) && $value == '') {
                $this->_addErrorMessage(
                    __('To apply changes you should fill in required "%1" field', $requiredFields[$field])
                );
            }
        }
    }

    /**
     * Add error message validation
     *
     * @param $message
     */
    protected function _addErrorMessage($message)
    {
        $this->response->setError(true);
        if (!is_array($this->response->getMessages())) {
            $this->response->setMessages([]);
        }
        $messages = $this->response->getMessages();
        $messages[] = $message;
        $this->response->setMessages($messages);
    }

    /**
     * AJAX customer validation action
     *
     * @return \Magento\Framework\Controller\Result\Json
     */
    public function execute()
    {
        $this->response->setError(0);

        $this->validateRequireEntries($this->getRequest()->getParams());

        $resultJson = $this->jsonFactory->create()->setData($this->response);
        return $resultJson;
    }
}
