<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Flat\Pickup\Api\Data\PickupInterface;
use Flat\Pickup\Api\Data\PickupSearchResultInterface;

interface PickupRepositoryInterface
{
    /**
     * @param int $id
     * @return \Flat\Pickup\Api\Data\PickupInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($id);

    /**
     * @param \Flat\Pickup\Api\Data\PickupInterface
     * @return void
     */
    public function save(PickupInterface $Pickup);

    /**
     * @param \Flat\Pickup\Api\Data\PickupInterface
     * @return void
     */
    public function delete(PickupInterface $Pickup);

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Flat\Pickup\Api\Data\PickupSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria);
}
