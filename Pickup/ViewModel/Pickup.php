<?php

/*
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class Pickup implements ArgumentInterface
{
    protected $_pickupCollection;
    protected $countryFactory;
        
    public function __construct(        
        \Flat\Pickup\Model\ResourceModel\Pickup\CollectionFactory $pickupCollection,
        \Magento\Directory\Model\CountryFactory $countryFactory
    )
    {    
        $this->_pickupCollection = $pickupCollection;   
        $this->_countryFactory = $countryFactory; 
        
    }
    
    public function getPickupCollection()
    {
        $collection = $this->_pickupCollection->create();
        return $collection;
    }

    public function getLocation($countryCode)
    {
        $country = $this->_countryFactory->create()->loadByCode($countryCode);
        return $country->getName();
        
    }
}