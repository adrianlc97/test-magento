<?php

/**
 * @copyright Copyright © 2020 Orba. All rights reserved.
 * @author    info@orba.co
 */

namespace Flat\Pickup\Model;

use Flat\Pickup\Api\PickupRepositoryInterface;
use Exception;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Flat\Pickup\Api\Data\PickupInterface;
use Flat\Pickup\Api\Data\PickupSearchResultInterface;
use Flat\Pickup\Api\Data\PickupSearchResultInterfaceFactory;
use Flat\Pickup\Model\ResourceModel\Pickup\CollectionFactory as PickupCollectionFactory;
use Flat\Pickup\Model\ResourceModel\Pickup\Collection;

class PickupRepository implements PickupRepositoryInterface
{

    /**
     * @var PickupFactory
     */
    private $pickupFactory;

    /**
     * @var PickupCollectionFactory
     */
    private $pickupCollectionFactory;

    /**
     * @var PickupSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    public function __construct(
        PickupFactory $pickupFactory,
        PickupCollectionFactory $pickupCollectionFactory,
        PickupSearchResultInterfaceFactory $pickupSearchResultInterfaceFactory
    ) {
        $this->pickupFactory = $pickupFactory;
        $this->pickupCollectionFactory = $pickupCollectionFactory;
        $this->searchResultFactory = $pickupSearchResultInterfaceFactory;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $pickup = $this->pickupFactory->create();
        $pickup->getResource()->load($pickup, $id);
        if (!$pickup->getId()) {
            throw new NoSuchEntityException(__('Unable to find Pickup with ID "%1"', $id));
        }
        return $pickup;
    }

    /**
     * @inheritDoc
     * @throws AlreadyExistsException
     */
    public function save(PickupInterface $pickup)
    {
        /** @var $pickup Pickup **/
        $pickup->getResource()->save($pickup);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function delete(PickupInterface $pickup)
    {
        /** @var $pickup Pickup **/
        $pickup->getResource()->delete($pickup);
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->pickupCollectionFactory->create();
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
        $collection->load();
        return $this->buildSearchResult($searchCriteria, $collection);
    }

    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        /** @var PickupSearchResultInterface $searchResults */
        $searchResults = $this->searchResultFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
