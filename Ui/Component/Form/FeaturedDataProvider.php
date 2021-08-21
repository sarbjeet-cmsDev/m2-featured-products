<?php
namespace Mgenius\FeaturedProducts\Ui\Component\Form;

use Mgenius\FeaturedProducts\Model\ResourceModel\Featured\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class FeaturedDataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var \Mgenius\FeaturedProducts\Model\ResourceModel\Featured\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Magento\Cms\Model\Block $block */
        foreach ($items as $featured) {
            $this->loadedData[$featured->getId()]['featured'] = $featured->getData();
        }

        $data = $this->dataPersistor->get('mgenius_featured');
        if (!empty($data)) {
            $featured = $this->collection->getNewEmptyItem();
            $featured->setData($data);
            $this->loadedData[$featured->getId()] = $featured->getData();
            $this->dataPersistor->clear('mgenius_featured');
        }

        return $this->loadedData;
    }
}
