<?php

namespace W2e\Feedblock\Api\Data;

/**
 * Interface FeedblockInterface
 * @package W2e\Feedblock\Api\Data
 */
interface FeedblockInterface
{
	const FEEDBLOCK_ID      = "feedblock_id";
	const FEED_URL          = "feed_url";
	const BLOCK_TITLE       = "block_title";
	const DESCR_LIMIT       = "descr_limit";
	const STATUS            = "status";
	const SHOW_CATEGORIES   = "show_categories";
	const USE_IMAGES        = "use_images";
	const ITEM_QTY          = "item_qty";
	const USE_SLIDER        = "use_slider";

	public function getId();
	public function getFeedUrl();
	public function getBlockTitle();
	public function getDescrLimit();
	public function getStatus();
	public function getShowCategories();
	public function getUseImages();
	public function getItemQty();
	public function getUseSlider();

	public function setId($id);
	public function setFeedUrl($feed_url);
	public function setBlockTitle($block_title);
	public function setDescrLimit($descr_limit);
	public function setStatus($status);
	public function setShowCategories($show_categories);
	public function setUseImages($use_images);
	public function setItemQty($item_qty);
	public function setUseSlider($use_slider);

}
