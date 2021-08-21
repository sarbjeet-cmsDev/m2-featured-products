<?php
namespace Mgenius\FeaturedProducts\Ui\Component\Listing;


use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
/**
 * Class ItemDataProvider
 *
 * @api
 * @since 100.0.2
 */
class ItemDataProvider extends \Magento\Catalog\Ui\DataProvider\Product\ProductDataProvider
{
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        $collection = $this->getCollection();

        $request = ObjectManager::getInstance()->get(RequestInterface::class);

        $parent_id = $request->getParam('parent_id',0);

        $resource = ObjectManager::getInstance()->get(ResourceConnection::class);
        $table = $resource->getTableName('mgenius_featured_item');

        $collection->getSelect()
        ->where("`e`.`entity_id` IN (SELECT `product_id` FROM `$table` WHERE `featured_id` = $parent_id)");

        $items = $collection->toArray();

        $data = [
            'totalRecords' => $this->getCollection()->getSize(),
            'items' => array_values($items),
        ];

        return $data;
    }
}