<?php
namespace Mgenius\FeaturedProducts\Model;

use Mgenius\FeaturedProducts\Api\FeaturedRepositoryInterface;
use Mgenius\FeaturedProducts\Model\FeaturedFactory;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteriaBuilder;

class FeaturedRepository implements FeaturedRepositoryInterface
{
    private $featuredFactory;
    private $productRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        FeaturedFactory $featuredFactory,
        ProductRepository $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->featuredFactory = $featuredFactory;
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getList(string $identifier)
    {
        $featured = $this->featuredFactory->create()->load($identifier, 'identifier');

        if($featured->getId()){
            $ids = $featured->getProductIds();

            $searchCriteria = $this->searchCriteriaBuilder
                                ->addFilter('entity_id', $ids, 'in')
                                ->create();

            return $this->productRepository->getList($searchCriteria);
        }

        return [];
    }
}