<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     *
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('W2e');
        $resultPage->addBreadcrumb(__('Feedblock'), __('Feedblock'));
        $resultPage->addBreadcrumb(__('Manage Feedblock'), __('Manage Feedblock'));
        $resultPage->getConfig()->getTitle()->prepend(__('Feedblock'));

        return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('W2e_Feedblock::feedblock');
    }
}