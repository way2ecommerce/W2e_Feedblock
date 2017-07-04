<?php

namespace W2e\Feedblock\Controller\Adminhtml\Feedblock;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use W2e\Feedblock\Model\ResourceModel\Feedblock\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class MassDisable
 * @package W2e\Feedblock\Controller\Adminhtml\Feedblock
 */
class MassDisable  extends \Magento\Backend\App\Action
{
	/**
	 * @var Filter
	 */
    protected $filter;

	/**
	 * @var CollectionFactory
	 */
    protected $collectionFactory;


	/**
	 * MassDisable constructor.
	 *
	 * @param Context $context
	 * @param Filter $filter
	 * @param CollectionFactory $collectionFactory
	 */
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

	/**
	 * @return mixed
	 */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());

        foreach ($collection as $item) {
            $item->setStatus(0);
            $item->save();
        }

        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
