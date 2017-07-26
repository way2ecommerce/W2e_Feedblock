<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

use Magento\Backend\App\Action;

/**
 * Class Delete
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $model;

    /**
     * Delete constructor.
     *
     * @param Action\Context $context
     * @param \W2e\Feedblock\Model\Feedblock $model
     */
    public function __construct(Action\Context $context, \W2e\Feedblock\Model\Feedblock $model)
    {
        parent::__construct($context);
        $this->model = $model;
    }

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
                $this->model->load($id);
                $this->model->delete();
                $this->messageManager->addSuccess(__('Successfully deleted feed.'));
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
