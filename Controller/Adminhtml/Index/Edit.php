<?php
namespace Mgenius\FeaturedProducts\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Edit action.
 */
class Edit extends \Mgenius\FeaturedProducts\Controller\Adminhtml\Index implements HttpGetActionInterface
{
    /**
     * Edit Featured
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_featuredFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This featured no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('mgenius_featured', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Featured') : __('New Featured'),
            $id ? __('Edit Featured') : __('New Featured')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Featured'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Featured'));
        return $resultPage;
    }
}
