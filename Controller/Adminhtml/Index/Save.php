<?php
namespace Mgenius\FeaturedProducts\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

/**
 * Save action.
 */
class Save extends \Mgenius\FeaturedProducts\Controller\Adminhtml\Index implements HttpPostActionInterface
{
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $post = $this->getRequest()->getPostValue();
        $data = $post['featured'];

        // print_r($post);
        // die();

        if ($data) {

            $model = $this->_featuredFactory->create();

            $id = $data['id'] ?? false;
            if ($id) {
                try {
                    $model->load($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This featured collection no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }
            try {

                $model
                ->setName($data['name'])
                ->setIdentifier($data['identifier'])
                ->setStatus($data['status'])
                ->save();
                
                $this->messageManager->addSuccessMessage(__('You saved the featured collection.'));
                $this->dataPersistor->clear('mgenius_featured');
                return $this->processBlockReturn($model, $post, $resultRedirect);
            } catch (\PDOException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }  catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the featured collection.'));
            }

            $this->dataPersistor->set('mgenius_featured', $post);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        
        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }
}

