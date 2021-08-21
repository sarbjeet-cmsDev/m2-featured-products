<?php
namespace Mgenius\FeaturedProducts\Api;


interface FeaturedRepositoryInterface
{
    /**
     * Retrieve Featureds
     *
     * @param string $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(string $identifier);
}
