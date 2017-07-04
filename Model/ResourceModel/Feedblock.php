<?php

namespace W2e\Feedblock\Model\ResourceModel;

/**
 * Class Feedblock
 * @package W2e\Feedblock\Model\ResourceModel
 */
class Feedblock extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
	/**
	 * @var \Magento\Framework\Stdlib\DateTime\DateTime
	 */
	protected $_date;

	/**
	 * Feedblock constructor.
	 *
	 * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
	 * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
	 * @param null $resourcePrefix
	 */
	public function __construct(
		\Magento\Framework\Model\ResourceModel\Db\Context $context,
		\Magento\Framework\Stdlib\DateTime\DateTime $date,
		$resourcePrefix = null
	) {
		parent::__construct($context,$resourcePrefix);
		$this->_date = $date;
	}

	/**
	 * Construct
	 */
	protected function _construct() {
		$this->_init('w2e_feedblock','feedblock_id');
	}
}