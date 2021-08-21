<?php

namespace Mgenius\FeaturedProducts\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Featured model
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Featured extends AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('mgenius_featured', 'id');
    }

    public function _detachProduct($parent_id, $id){
        $connection = $this->getConnection();
        $connection->delete(
            $connection->getTableName('mgenius_featured_item'),
            [
                'featured_id = ?' => $parent_id,
                'product_id = ?' => $id
            ]
        );
        return true;
    }    

    public function _attachProduct($parent_id, $ids){
        $connection = $this->getConnection();
        $connection->insertMultiple(
            $connection->getTableName('mgenius_featured_item'),
            array_map(function($id) use($parent_id){
                return [
                    'featured_id' => $parent_id,
                    'product_id' => $id
                ];
            }, $ids)
        );
        return true;
    }

    public function _getProductIds($id){
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $connection->getTableName('mgenius_featured_item'),
            ['product_id']            
        )->where("featured_id = $id");

        return $connection->fetchCol($select);
    }
}