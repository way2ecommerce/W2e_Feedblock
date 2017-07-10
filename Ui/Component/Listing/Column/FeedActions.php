<?php

namespace W2e\Feedblock\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\UrlInterface;

/**
 * Class FeedActions
 * @package W2e\Feedblock\Ui\Component\Listing\Column
 */
class FeedActions extends Column
{
    const BLOG_URL_PATH_EDIT = 'feedblock/feedblock/edit';
    const BLOG_URL_PATH_DELETE = 'feedblock/feedblock/delete';

    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var string
     */
    private $editUrl;

    /**
     * FeedActions constructor.
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     * @param string $editUrl
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = [],
        $editUrl = self::BLOG_URL_PATH_EDIT
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->editUrl    = $editUrl;
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
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['feedblock_id'])) {
                    $item[$name]['edit']   = [
                        'href'  => $this->urlBuilder->getUrl($this->editUrl, ['feedblock_id' => $item['feedblock_id']]),
                        'label' => __('Edit')
                    ];
                    $item[$name]['delete'] = [
                        'href'    => $this->urlBuilder->getUrl(self::BLOG_URL_PATH_DELETE,
                            ['feedblock_id' => $item['feedblock_id']]),
                        'label'   => __('Delete'),
                        'confirm' => [
                            'title'   => __('Delete "${ $.$data.block_title }"'),
                            'message' => __('Are you sure you want to delete the block "${ $.$data.block_title }" with id "${ $.$data.feedblock_id }"?')
                        ]
                    ];
                }
            }
        }

        return $dataSource;
    }
}