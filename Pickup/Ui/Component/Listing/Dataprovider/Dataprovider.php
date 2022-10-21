<?php
/**
 * Dataprovider
 *
 * @copyright Copyright © 2022 Prat Brands. All rights reserved.
 * @author    victor.g@pratbrands.com
 */

namespace Flat\Pickup\Ui\Component\Listing\Dataprovider;


class Dataprovider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $pickupCollectionFactory;
    protected $countryRepository;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Flat\Pickup\Model\ResourceModel\Pickup\CollectionFactory $pickupCollectionFactory,
        \Magento\Directory\Model\Country $countryRepository,
        array $meta = [],
        array $data = []

    )
    {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->pickupCollectionFactory = $pickupCollectionFactory;
        $this->countryRepository = $countryRepository;
        $this->initCollection();

    }


    public function initCollection()

    {
        $collection = $this->pickupCollectionFactory->create();
        foreach ($collection as $item) {
            $country=$this->countryRepository->loadByCode($item->getData('location'));
            $item->setData('location',$country->getName());

        }

        $this->collection = $collection;
    }


    public function getSearchCriteria()
    {

        return $this->getCollection();

    }


}
