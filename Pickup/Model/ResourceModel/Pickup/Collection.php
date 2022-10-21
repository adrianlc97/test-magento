<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Model\ResourceModel\Pickup;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Flat\Pickup\Model\Pickup;
use Flat\Pickup\Model\ResourceModel\Pickup as PickupResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Pickup::class, PickupResourceModel::class);
    }
}
