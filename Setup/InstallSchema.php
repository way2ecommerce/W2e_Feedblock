<?php

namespace W2e\Feedblock\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class InstallSchema
 * @package W2e\Feedblock\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $table = $installer->getConnection()
                           ->newTable($installer->getTable('w2e_feedblock'))
                           ->addColumn(
                               'feedblock_id', Table::TYPE_INTEGER, null,
                               array(
                                   'identity' => true,
                                   'unsigned' => true,
                                   'nullable' => false,
                                   'primary'  => true,
                               ), 'Unique identifier'
                           )
                           ->addColumn(
                               'feed_url', Table::TYPE_TEXT, 100, array(), 'Feed Url'
                           )
                           ->addColumn(
                               'block_title', Table::TYPE_TEXT, 100, array(), 'Block title'
                           )
                           ->addColumn(
                               'descr_limit', Table::TYPE_SMALLINT, null, array(), 'Description limit'
                           )
                           ->addColumn(
                               'status', Table::TYPE_BOOLEAN, null, array(), 'Status'
                           )
                           ->addColumn(
                               'show_categories', Table::TYPE_BOOLEAN, null, array(), 'Show image?'
                           )
                           ->addColumn(
                               'use_images', Table::TYPE_BOOLEAN, null, array(), 'Use images?'
                           )
                           ->addColumn(
                               'item_qty', Table::TYPE_TEXT, 100, array(), 'Number of items'
                           )
                           ->addColumn(
                               'use_slider', Table::TYPE_BOOLEAN, null, array(), 'Use slider?'
                           );

        if ( ! $installer->getConnection()->isTableExists($table->getName())) {
            $installer->getConnection()->createTable($table);
        }

        $installer->endSetup();
    }
}