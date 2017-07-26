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
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $model;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $session;

    /**
     * Save constructor.
     *
     * @param Action\Context $context
     * @param \W2e\Feedblock\Model\Feedblock $model
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
	    Action\Context $context,
        \W2e\Feedblock\Model\Feedblock $model,
        \Magento\Backend\Model\Session $session)
	{
		parent::__construct($context);
		$this->model = $model;
		$this->session = $session;
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

			$model = $this->model;

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
				$this->session->setFormData(false);
				if ($this->getRequest()->getParam('back')) {
					return $resultRedirect->setPath(
					    '*/*/edit',
                        ['feedblock_id' => $model->getId(), '_current' => true]
                    );
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
			return $resultRedirect->setPath(
			    '*/*/edit',
                ['feedblock_id' => $this->getRequest()->getParam('feedblock_id')]
            );
		}
		return $resultRedirect->setPath('*/*/');
	}
}
