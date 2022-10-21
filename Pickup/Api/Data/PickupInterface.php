<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Api\Data;

interface PickupInterface
{
    /**
     * @return int|null
     */
    public function getId();

    /**
     * @param int $value
     * @return void
     */
    public function setId($value);

    /**
     * @return string|null
     */
    public function getName();

    /**
     * @param string $value
     * @return void
     */
    public function setName(string $value);

    /**
     * @return string|null
     */
    public function getDirection();

    /**
     * @param string $value
     * @return void
     */
    public function setDirection(string $value);

    /**
     * @return float|null
     */
    public function getLatitude();

    /**
     * @param float $value
     * @return void
     */
    public function setLatitude(float $value);

    /**
     * @return float|null
     */
    public function getLongitude();

    /**
     * @param float $value
     * @return void
     */
    public function setLongitude(float $value);

    /**
     * @return string|null
     */
    public function getLocation();

    /**
     * @param string $value
     * @return void
     */
    public function setLocation(string $value);

    /**
     * @return string|null
     */
    public function getShippingMethod();

    /**
     * @param string $value
     * @return void
     */
    public function setShippingMethod(string $value);
}
