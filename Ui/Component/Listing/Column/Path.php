<?php

namespace W2e\Feedblock\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Path
 * @package W2e\Feedblock\Ui\Component\Listing\Column
 */
class Path extends Column
{

	protected $path;

	/**
	 * Path constructor.
	 *
	 * @param ContextInterface $context
	 * @param UiComponentFactory $uiComponentFactory
	 * @param array $components
	 * @param array $data
	 */
	public function __construct(
		ContextInterface $context,
		UiComponentFactory $uiComponentFactory,
		array $components = [],
		array $data = []
	) {
		parent::__construct($context, $uiComponentFactory, $components, $data);
	}

	/**
	 * @param array $dataSource
	 *
	 * @return array
	 */
	public function prepareDataSource(array $dataSource)
	{

		if (isset($dataSource['data']['items'])) {
			$id = '';
			foreach ($dataSource['data']['items'] as & $item) {
				$id = $item['feedblock_id'];
				$item['path'] = '{{block class="W2e\Feedblock\Block\Feedblock" feed_id=' . $id . ' }}';
			}
		}

		return $dataSource;
	}
}