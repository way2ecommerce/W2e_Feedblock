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
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     *
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry     = $registry;
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
        $id    = $this->getRequest()->getParam('feedblock_id');
        $model = $this->_objectManager->create('W2e\Feedblock\Model\Feedblock');

        if ($id) {
            $model->load($id);
            if ( ! $model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }


        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if ( ! empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('feedblock_feedblock', $model);

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
