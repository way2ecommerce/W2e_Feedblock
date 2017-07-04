<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

use Magento\Backend\App\Action;

/**
 * Class Save
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class Save extends \Magento\Backend\App\Action
{

	/**
	 * Save constructor.
	 *
	 * @param Action\Context $context
	 */
	public function __construct(Action\Context $context)
	{
		parent::__construct($context);
	}

	/**
	 * @return bool
	 */
	protected function _isAllowed()
	{
		return $this->_authorization->isAllowed('feedblock_feedblock::save');
	}

	/**
	 * @return $this
	 */
	public function execute()
	{
		$data = $this->getRequest()->getPostValue();

		$resultRedirect = $this->resultRedirectFactory->create();
		if ($data) {

			$model = $this->_objectManager->create('W2e\Feedblock\Model\Feedblock');

			$id = $this->getRequest()->getParam('feedblock_id');
			if ($id) {
				$model->load($id);
			}

			$model->setData($data);

			$this->_eventManager->dispatch(
				'feedblock_feedblock_prepare_save',
				['feed' => $model, 'request' => $this->getRequest()]
			);

			try {
				$model->save();
				$this->messageManager->addSuccess(__('You saved this Feed.'));
				$this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath('*/*/edit', ['feedblock_id' => $model->getId(), '_current' => true]);
				}
				return $resultRedirect->setPath('*/*/');
			} catch (\Magento\Framework\Exception\LocalizedException $e) {
				$this->messageManager->addError($e->getMessage());
			} catch (\RuntimeException $e) {
				$this->messageManager->addError($e->getMessage());
			} catch (\Exception $e) {
				$this->messageManager->addException($e, __('Something went wrong while saving the feed.'));
			}

			$this->_getSession()->setFormData($data);
			return $resultRedirect->setPath('*/*/edit', ['feedblock_id' => $this->getRequest()->getParam('feedblock_id')]);
		}
		return $resultRedirect->setPath('*/*/');
	}
}