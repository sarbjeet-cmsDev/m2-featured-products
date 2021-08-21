<?php
namespace Mgenius\FeaturedProducts\Block\Adminhtml\Featured\Edit;

use Magento\Backend\Block\Widget\Context;
use Mgenius\FeaturedProducts\Model\FeaturedFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var FeaturedFactory
     */
    protected $featuredFactory;

    /**
     * @param Context $context
     * @param FeaturedFactory $featuredFactory
     */
    public function __construct(
        Context $context,
        FeaturedFactory $featuredFactory
    ) {
        $this->context = $context;
        $this->featuredFactory = $featuredFactory;
    }

    /**
     * Return Featured ID
     *
     * @return int|null
     */
    public function getId()
    {
        try {
            return $this->featuredFactory->create()->load(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
