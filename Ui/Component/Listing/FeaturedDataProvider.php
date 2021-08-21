<?php
namespace Mgenius\FeaturedProducts\Ui\Component\Listing;

use Magento\Framework\Api\Filter;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Mgenius\FeaturedProducts\Model\ResourceModel\Featured\CollectionFactory;

/**
 * DataProvider for featured ui.
 */
class FeaturedDataProvider extends AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }

    /**
     * Filter Customer Which Has Organisation Request ID
     *
     * @return array
     */
    public function getData(): array
    {
        /** @var GridCollection $collection */
        $collection = $this->getCollection();
        return $collection->toArray();
    }

    /**
     * Add full text search filter to collection
     *
     * @param Filter $filter
     * @return void
     */
    public function addFilter(Filter $filter): void{
        /** @var GridCollection $collection */
        $collection = $this->getCollection();
        if ($filter->getField() === 'fulltext') {
            $collection->addFullTextFilter(trim($filter->getValue()));
        } else {
            $collection->addFieldToFilter(
                $filter->getField(),
                [$filter->getConditionType() => $filter->getValue()]
            );
        }
    }   
}
