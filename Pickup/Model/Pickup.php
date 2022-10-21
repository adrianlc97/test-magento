<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Model;

use Magento\Framework\Model\AbstractModel;
use Flat\Pickup\Api\Data\PickupInterface;
use Flat\Pickup\Model\ResourceModel\Pickup as PickupResourceModel;

class Pickup extends AbstractModel implements PickupInterface
{

    protected $_eventPrefix = 'flat_pickup_pickup';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(PickupResourceModel::class);
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->_getData('entity_id');
    }

    /**
     * @param int $value
     * @return void
     */
    public function setId($value)
    {
        $this->setData('entity_id', $value);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getData('name');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setName(string $value)
    {
        $this->setData('name', $value);
    }

    /**
     * @return string|null
     */
    public function getDirection()
    {
        return $this->getData('direction');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setDirection(string $value)
    {
        $this->setData('direction', $value);
    }

    /**
     * @return float|null
     */
    public function getLatitude()
    {
        return $this->getData('latitude');
    }

    /**
     * @param float $value
     * @return void
     */
    public function setLatitude(float $value)
    {
        $this->setData('latitude', $value);
    }

    /**
     * @return float|null
     */
    public function getLongitude()
    {
        return $this->getData('longitude');
    }

    /**
     * @param float $value
     * @return void
     */
    public function setLongitude(float $value)
    {
        $this->setData('longitude', $value);
    }

    /**
     * @return string|null
     */
    public function getLocation()
    {
        return $this->getData('location');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setLocation(string $value)
    {
        $this->setData('location', $value);
    }

    /**
     * @return string|null
     */
    public function getShippingMethod()
    {
        return $this->getData('shipping_method');
    }

    /**
     * @param string $value
     * @return void
     */
    public function setShippingMethod(string $value)
    {
        $this->setData('shipping_method', $value);
    }
}
