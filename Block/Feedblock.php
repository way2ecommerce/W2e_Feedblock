<?php

namespace W2e\Feedblock\Block;

use W2e\Feedblock\Model\ResourceModel\Feedblock\CollectionFactory as FeedCollection;
use Magento\Framework\Logger\Monolog;

/**
 * Class Feedblock
 * @package W2e\Feedblock\Block
 */
class Feedblock extends \Magento\Framework\View\Element\Template implements
	\Magento\Framework\DataObject\IdentityInterface
{

	/**
	 * @var FeedCollection
	 */
	protected $feedCollectionFactory;

	/**
	 * @var Monolog
	 */
	protected $logger;

    /**
     * @var string
     */
    protected $_template = 'feedblock.phtml';

    /**
     * @var \W2e\Feedblock\Model\Feedblock
     */
    protected $model;

    /**
     * @var \W2e\Feedblock\Helper\Data
     */
    protected $helper;


    /**
     * Feedblock constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param FeedCollection $feedCollectionFactory
     * @param Monolog $logger
     * @param \W2e\Feedblock\Model\Feedblock $model
     * @param \W2e\Feedblock\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		FeedCollection $feedCollectionFactory,
		Monolog $logger,
		\W2e\Feedblock\Model\Feedblock $model,
		\W2e\Feedblock\Helper\Data $helper
	) {
		parent::__construct($context);
		$this->feedCollectionFactory = $feedCollectionFactory;
		$this->logger = $logger;
		$this->model = $model;
		$this->helper = $helper;
	}

	/**
	 * @return mixed
	 */
	public function getFeed()
	{
		if (!$this->hasData('feed')) {
			$feed = $this->feedCollectionFactory
				->create()
				->addFilter('status', 1);
			$this->setData('feed', $feed);
		}
		return $this->getData('feed');
	}

	/**
	 * @return array
	 */
	public function getIdentities()
	{
		return [\W2e\Feedblock\Model\Feedblock::CACHE_TAG . '_' . $this->getFeed()->getFeedblockId()];
	}

	/**
	 * @return $this|void
	 */
	public function getFeedData()
	{
		$id = $this->getData('feed_id');
		$model = $this->model;
		$helper = $this->helper;

		if ($id) {
			$model->load($id);
		}

		if($helper->feedblockEnabled()) {
			$this->setFeedConfData($model);

			$feed = $this->getFeedConfData();

			if (!$feed || $feed->getStatus() == 2) {
				return;
			}

			$context = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));

			try {
				$xml = @file_get_contents($feed->getFeedUrl(), false, $context);
				if($xml === false) {
					$this->logger->addDebug('Error in  ' . $feed->getFeedUrl());
					return;
				}
			} catch (\Exception $e) {
				$this->logger->addDebug('Error parsing xml ' . $feed->getFeedUrl());
				$this->logger->critical($e);
				return;
			}

			try {
				$rawData = $helper->xml2array($xml);
			} catch (\Exception $e) {
				$this->logger->addDebug('Error parsing xml');
				$this->logger->critical($e);
				return;
			}

			$this->setItems($rawData['rss']['channel']['item']);

			return $this;
		}
	}

	/**
	 * @param $post
	 *
	 * @return string
	 */
	public function getImage($post)
	{
		$src = '';

		if (isset($post['media:thumbnail_attr']) && isset($post['media:thumbnail_attr']['url'])) {
			$src = $post['media:thumbnail_attr']['url'];
		} else if (isset($post['content:encoded'])) {
			$dom = new \Zend_Dom_Query($post['content:encoded']);
			$elements = $dom->query('img');
			foreach ($elements as $result) {
				$src = utf8_decode($result->getAttribute('src'));
				continue;
			}
		} elseif(isset($post['enclosure_attr']['url'])){
			$src = $post['enclosure_attr']['url'];
		}else {
            $dom = new \Zend_Dom_Query($post['description']);
			$elements = $dom->query('img');
			foreach ($elements as $result) {
				$src = (utf8_decode($result->getAttribute('src')));
				continue;
			}
		}

		$checkUrl = parse_url($src);

		if (!isset($checkUrl['host'])) {
			$feedUrl = parse_url($this->getFeedConfData()->getFeedUrl());
			$src = $feedUrl['scheme'].'://'.$feedUrl['host'] . $src;
		}

		return $src;
	}

	/**
	 * @param $categories
	 *
	 * @return string
	 */
	public function getCategories($categories)
	{
		$c = 0;
		$cats = array();
		if(is_array($categories)) {
			foreach ($categories as $cat) {
				if ($c > 2) {
					continue;
				}
				$cats[] = $cat;
				$c++;
			}
		} else{
			$cats[] = $categories;
		}

		return implode(', ', $cats);
	}
}
