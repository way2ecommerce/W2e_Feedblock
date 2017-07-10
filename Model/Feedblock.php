<?php

namespace W2e\Feedblock\Model;

use W2e\Feedblock\Api\Data\FeedblockInterface;
use Magento\Framework\DataObject\IdentityInterface;

/**
 * Class Feedblock
 * @package W2e\Feedblock\Model
 */
class Feedblock extends \Magento\Framework\Model\AbstractModel implements FeedblockInterface, IdentityInterface
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const OPTION_YES = 1;
    const OPTION_NO = 0;

    const CACHE_TAG = "feedblock";

    protected $_cacheTag = "feedblock";

    protected $_eventPrefix = "feedblock";


    /**
     * Construct
     */
    public function _construct()
    {
        $this->_init("W2e\Feedblock\Model\ResourceModel\Feedblock");
    }

    /**
     * @param $feedblock_url
     *
     * @return mixed
     */
    public function checkFeedblockUrl($feedblock_url)
    {
        return $this->getResource()->checkFeedblockUrl($feedblock_url);
    }

    /**
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }

    /**
     * @return array
     */
    public function getYesNoOption()
    {
        return [self::OPTION_YES => __('Yes'), self::OPTION_NO => __('No')];
    }

    /**
     * @return mixed
     */
    public function getFeedUrl()
    {
        return $this->getData(self::FEED_URL);
    }

    /**
     * @return mixed
     */
    public function getBlockTitle()
    {
        return $this->getData(self::BLOCK_TITLE);
    }

    /**
     * @return mixed
     */
    public function getDescrLimit()
    {
        return $this->getData(self::DESCR_LIMIT);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * @return mixed
     */
    public function getShowCategories()
    {
        return $this->getData(self::SHOW_CATEGORIES);
    }

    /**
     * @return mixed
     */
    public function getUseImages()
    {
        return $this->getData(self::USE_IMAGES);
    }

    /**
     * @return mixed
     */
    public function getItemQty()
    {
        return $this->getData(self::ITEM_QTY);
    }

    /**
     * @return mixed
     */
    public function getUseSlider()
    {
        return $this->getData(self::USE_SLIDER);
    }

    /**
     * @param $feed_url
     *
     * @return $this
     */
    public function setFeedUrl($feed_url)
    {
        return $this->setData(self::FEED_URL, $feed_url);
    }

    /**
     * @param $block_title
     *
     * @return $this
     */
    public function setBlockTitle($block_title)
    {
        return $this->setData(self::BLOCK_TITLE, $block_title);
    }

    /**
     * @param $descr_limit
     *
     * @return $this
     */
    public function setDescrLimit($descr_limit)
    {
        return $this->setData(self::DESCR_LIMIT, $descr_limit);
    }

    /**
     * @param $status
     *
     * @return $this
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * @param $show_categories
     *
     * @return $this
     */
    public function setShowCategories($show_categories)
    {
        return $this->setData(self::SHOW_CATEGORIES, $show_categories);
    }

    /**
     * @param $use_images
     *
     * @return $this
     */
    public function setUseImages($use_images)
    {
        return $this->setData(self::USE_IMAGES, $use_images);
    }

    /**
     * @param $item_qty
     *
     * @return $this
     */
    public function setItemQty($item_qty)
    {
        return $this->setData(self::ITEM_QTY, $item_qty);
    }

    /**
     * @param $use_slider
     *
     * @return $this
     */
    public function setUseSlider($use_slider)
    {
        return $this->setData(self::USE_SLIDER, $use_slider);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


}