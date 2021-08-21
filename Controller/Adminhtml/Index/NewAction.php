<?php
namespace Mgenius\FeaturedProducts\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * NewAction action.
 */
class NewAction extends \Mgenius\FeaturedProducts\Controller\Adminhtml\Index implements HttpGetActionInterface
{
    /**
     * Create new Featured
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
