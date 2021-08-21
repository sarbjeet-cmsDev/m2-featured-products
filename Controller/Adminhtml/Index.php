<?php

namespace Mgenius\FeaturedProducts\Controller\Adminhtml;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\Result\JsonFactory;

abstract class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Mgenius_FeaturedProducts::manage';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Featured Factory
     *
     * @var \Mgenius\FeaturedProducts\Model\FeaturedFactory
     */
    protected $_featuredFactory;

    /**
     * Featured Factory
     *
     * @var \Mgenius\FeaturedProducts\Model\FeaturedFactory
     */
    protected $_resourceFeatured;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\ForwardFactory
     */
    protected $resultForwardFactory;
    
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var JsonFactory
     */
    protected $resultJsonFactory;


    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Mgenius\FeaturedProducts\Model\FeaturedFactory $featuredFactory,
        \Mgenius\FeaturedProducts\Model\ResourceModel\Featured $resourceFeatured,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        JsonFactory $resultJsonFactory,
        DataPersistorInterface $dataPersistor,
        \Magento\Framework\Registry $coreRegistry
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->_coreRegistry = $coreRegistry;
        $this->_featuredFactory = $featuredFactory;
        $this->_resourceFeatured = $resourceFeatured;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($context);
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Mgenius_FeaturedProducts::manage')
            ->addBreadcrumb(__('CMS'), __('CMS'))
            ->addBreadcrumb(__('Featureds'), __('Featureds'));
        return $resultPage;
    }
}
