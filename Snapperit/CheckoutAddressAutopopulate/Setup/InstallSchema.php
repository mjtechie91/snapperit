<?php

namespace Snapperit\CheckoutAddressAutopopulate\Setup;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{

    public function install(\Magento\Framework\Setup\SchemaSetupInterface $setup, \Magento\Framework\Setup\ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $installer->getConnection()
        ->addColumn(
            $installer->getTable('quote_address'),
            'delivery_address_attribute',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 500,
                'comment' => 'Delivery Address Field'
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_address'),
            'delivery_address_attribute',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'length' => 500,
                'comment' => 'Delivery Address Field'
            ]
        );

        $installer->endSetup();
    }
}