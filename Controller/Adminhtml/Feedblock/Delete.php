<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

/**
 * Class Delete
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class Delete extends \Magento\Backend\App\Action
{

	/**
	 * @return bool
	 */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('W2e_Feedblock::delete');
    }

	/**
	 * @return $this
	 */
    public function execute()
    {
        $id = $this->getRequest()->getParam('feedblock_id');

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('W2e\Feedblock\Model\Feedblock');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('We cannot find the feed to delete.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['feedblock_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We cannot find the feed to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}
