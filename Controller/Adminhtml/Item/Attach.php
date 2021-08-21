<?php
namespace Mgenius\FeaturedProducts\Controller\Adminhtml\Item;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Attach action.
 */
class Attach extends \Mgenius\FeaturedProducts\Controller\Adminhtml\Index implements HttpPostActionInterface
{
    /**
     * Attach action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $featuredId = $this->getRequest()->getParam('parent_id', false);
        $itemIds = $this->getRequest()->getParam('ids', false);
        $error = false;
        $message = '';

        try {
            $model = $this->_featuredFactory->create();
            $model->load($featuredId);

            $model->attachProduct($itemIds);            

            $message = __('Item removed');

        } catch (LocalizedException $e) {
            $error = true;
            $message = __('We can\'t delete the item right now.');
        }

        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData(
            [
                'message' => $message,
                'error' => $error,
            ]
        );

        return $resultJson;
    }
}
