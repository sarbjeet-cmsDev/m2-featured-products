<?php
namespace Mgenius\FeaturedProducts\Controller\Adminhtml\Item;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Exception\LocalizedException;

/**
 * Delete action.
 */
class Delete extends \Mgenius\FeaturedProducts\Controller\Adminhtml\Index implements HttpPostActionInterface
{
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $featuredId = $this->getRequest()->getParam('parent_id', false);
        $itemId = $this->getRequest()->getParam('id', false);
        $error = false;
        $message = '';

        try {
            $model = $this->_featuredFactory->create();
            $model->load($featuredId);

            $model->detachProduct($itemId);            

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
