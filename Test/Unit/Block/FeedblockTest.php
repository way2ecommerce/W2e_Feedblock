<?php

namespace W2e\Feedblock\Test\Unit\Block;

class FeedblockTest extends \PHPUnit_Framework_TestCase
{
    protected $feed;

    protected $block;

    protected function setUp()
    {
        $objectManager      = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->block        = $objectManager->getObject('W2e\Feedblock\Block\Feedblock');
        $this->feed         = $objectManager->getObject('W2e\Feedblock\Model\Feedblock');
        $reflection         = new \ReflectionClass($this->feed);
        $reflectionProperty = $reflection->getProperty('_idFieldName');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->feed, 'feedblock_id');
        $this->feed->setId(1);
    }

    public function testGetIdentities()
    {
        $id = 1;
        $this->block->setFeed($this->feed);
        $this->assertEquals(
            [\W2e\Feedblock\Model\Feedblock::CACHE_TAG . '_' . $id],
            $this->block->getIdentities()
        );
    }

    protected function tearDown()
    {
        $this->block = null;
    }
}