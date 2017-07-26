<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class Edit extends \Magento\Backend\App\Action
{
	/**
	 * @var \Magento\Framework\Registry|null
	 */
    protected $coreRegistry = null;

	/**
	 * @var \Magento\Framework\View\Result\PageFactory
	 */
    protected $resultPageFactory;

    /**
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $model;

    /**
     * @var \Magento\Backend\Model\Session
     */
    protected $session;


    /**
     * Edit constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \W2e\Feedblock\Model\Feedblock $model
     * @param \Magento\Backend\Model\Session $session
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \W2e\Feedblock\Model\Feedblock $model,
        \Magento\Backend\Model\Session $session
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
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
	 * @return \Magento\Framework\View\Result\Page
	 */
    protected function _initAction()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('W2e')
            ->addBreadcrumb(__('Feedblock'), __('Feedblock'))
            ->addBreadcrumb(__('Edit Feed'), __('Edit Feed'));
        return $resultPage;
    }

	/**
	 * @return $this|\Magento\Framework\View\Result\Page
	 */
    public function execute()
    {
        $id = $this->getRequest()->getParam('feedblock_id');
        $model = $this->model;

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->session->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->coreRegistry->register('feedblock_feedblock', $model);

        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Feed') : __('New Feed'),
            $id ? __('Edit Feed') : __('New Feed')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Feedblock'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Feed'));

        return $resultPage;
    }
}
