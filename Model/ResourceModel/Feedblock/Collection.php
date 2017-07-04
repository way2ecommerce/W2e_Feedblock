<?php

namespace W2e\Feedblock\Model\ResourceModel\Feedblock;

/**
 * Class Collection
 * @package W2e\Feedblock\Model\ResourceModel\Feedblock
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	protected $_idFieldName = 'feedblock_id';

	protected function _construct() {
		$this->_init('W2e\Feedblock\Model\Feedblock','W2e\Feedblock\Model\ResourceModel\Feedblock');
	}
}