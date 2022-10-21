<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Pickup extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('flat_pickup_pickup', 'entity_id');
    }
}
