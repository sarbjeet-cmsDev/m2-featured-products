<?php

namespace Mgenius\FeaturedProducts\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class Featured extends AbstractModel implements IdentityInterface
{
	/**
     * CMS block cache tag
     */
    const CACHE_TAG = 'Mgenius_FeaturedProducts';

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

	/**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'Mgenius_FeaturedProducts';

	/**
     * Construct.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Mgenius\FeaturedProducts\Model\ResourceModel\Featured::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId(), self::CACHE_TAG . '_' . $this->getIdentifier()];
    }

    public function detachProduct($id)
    {
        return $this->getResource()->_detachProduct($this->getId(), $id);
    } 

    public function attachProduct($ids)
    {
        return $this->getResource()->_attachProduct($this->getId(), $ids);
    } 

    public function getProductIds()
    {
        return $this->getResource()->_getProductIds($this->getId());
    }    
}

