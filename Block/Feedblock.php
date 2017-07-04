<?php

namespace W2e\Feedblock\Block;

use W2e\Feedblock\Model\ResourceModel\Feedblock\CollectionFactory as FeedCollection;
use Magento\Framework\App\ObjectManager;
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
	protected $_feedCollectionFactory;

	protected $_feed_conf_data;

	/**
	 * @var Monolog
	 */
	protected $_logger;


	/**
	 * Feedblock constructor.
	 *
	 * @param \Magento\Framework\View\Element\Template\Context $context
	 * @param FeedCollection $feedCollectionFactory
	 * @param \Magento\Framework\Filter\FilterManager $filter_manager
	 * @param Monolog $logger
	 * @param array $data
	 */
	public function __construct(
		\Magento\Framework\View\Element\Template\Context $context,
		FeedCollection $feedCollectionFactory,
		\Magento\Framework\Filter\FilterManager $filter_manager,
		Monolog $logger,
		array $data = []
	) {
		parent::__construct($context, $data);
		$this->_feedCollectionFactory = $feedCollectionFactory;
		$this->_filter = $filter_manager;
		$this->setTemplate('W2e_Feedblock::feedblock.phtml');
		$this->_logger = $logger;
	}


	/**
	 * @return mixed
	 */
	public function getFeed()
	{
		if (!$this->hasData('feed')) {
			$feed = $this->_feedCollectionFactory
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
		$objectManager = ObjectManager::getInstance();
		$model = $objectManager->create('W2e\Feedblock\Model\Feedblock');
		$helper = $objectManager->create('W2e\Feedblock\Helper\Data');

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
					$this->_logger->addDebug('Error in  ' . $feed->getFeedUrl());
					return;
				}
			} catch (Exception $e) {
				$this->_logger->addDebug('Error parsing xml ' . $feed->getFeedUrl());
				$this->_logger->critical($e);
				return;
			}


			try {
				$rawData = $helper->xml2array($xml);
			} catch (Exception $e) {
				$this->_logger->addDebug('Error parsing xml');
				$this->_logger->critical($e);
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
			//$dom = \Zend_Dom_Query($post['content:encoded']);
			$dom = new \Zend_Dom_Query($post['content:encoded']);
			$elements = $dom->query('img');
			foreach ($elements as $result) {
				$src = utf8_decode($result->getAttribute('src'));
				continue;
			}
		} else if(isset($post['enclosure_attr']['url'])){
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