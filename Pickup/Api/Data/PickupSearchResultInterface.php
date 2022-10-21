<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface PickupSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Flat\Pickup\Api\Data\PickupInterface[]
     */
    public function getItems();

    /**
     * @param \Flat\Pickup\Api\Data\PickupInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
