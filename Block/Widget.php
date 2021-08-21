<?php
namespace Mgenius\FeaturedProducts\Block;

use Magento\CatalogWidget\Block\Product\ProductsList;
use Mgenius\FeaturedProducts\Api\FeaturedRepositoryInterface;
use Magento\Framework\App\ObjectManager;

class Widget extends ProductsList {
	
    protected $_template = "Mgenius_FeaturedProducts::list.phtml";

    private $_featured = null;

	/**
     * Prepare and return product collection
     *
     * @return Collection
     * @SuppressWarnings(PHPMD.RequestAwareBlockMethod)
     * @throws LocalizedException
     */
    public function createCollection()
    {

        if(!$this->_featured){
            $this->_featured = ObjectManager::getInstance()->create('\Mgenius\FeaturedProducts\Model\Featured')->load($this->getIdentifier(), 'identifier');    
        }

        /** @var $collection Collection */
        $collection = $this->productCollectionFactory->create();

        if ($this->getData('store_id') !== null) {
            $collection->setStoreId($this->getData('store_id'));
        }

        if($this->_featured->getStatus()){
            $collection->addFieldToFilter('entity_id', ['in' => $this->_featured->getProductIds()]);
        }else{
            $collection->addFieldToFilter('entity_id', ['in' => [0]]);
        }

        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        /**
         * Change sorting attribute to entity_id because created_at can be the same for products fastly created
         * one by one and sorting by created_at is indeterministic in this case.
         */
        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addStoreFilter()
            ->addAttributeToSort('entity_id', 'desc')
            ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1));

        /**
         * Prevent retrieval of duplicate records. This may occur when multiselect product attribute matches
         * several allowed values from condition simultaneously
         */
        $collection->distinct(true);

        return $collection;
    }

	/**
     * Render block HTML
     *
     * @return string empty string if url can't be prepared
     */
    protected function _toHtml()
    {
        if ($this->getWidgetStatus()) {
            return parent::_toHtml();
        }
        return '';
    }
}