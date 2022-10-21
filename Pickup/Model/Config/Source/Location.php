<?php
/**
 * Location
 *
 */

namespace Flat\Pickup\Model\Config\Source;


use Magento\Framework\Data\OptionSourceInterface;

class Location implements OptionSourceInterface
{

    protected $_collectionFactoryCountry;

    public function __construct(
        \Magento\Directory\Model\ResourceModel\Country\CollectionFactory $collectionFactoryCountry
    ){
        $this->_collectionFactoryCountry = $collectionFactoryCountry;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $stores= $this->_collectionFactoryCountry->create();
        $stores_result=[];
        $stores_result[]=['value'=>null,'label'=>'Please Select you Location'];
        foreach ($stores as $store) {
            $stores_result[]= ['value' => $store->getId(), 'label' => $store->getName()];
        }
        return $stores_result;
    }
}
