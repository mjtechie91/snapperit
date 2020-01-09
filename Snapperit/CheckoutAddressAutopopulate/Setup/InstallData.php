<?php

namespace Snapperit\CheckoutAddressAutopopulate\Setup;

use Magento\Eav\Model\Config;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class InstallData implements InstallDataInterface
{
    /**
     * @var Config
     */
    private $eavConfig;

     /**
     * @var EavSetupFactory
     */
    private $_eavSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributeSetFactory;

    /**
     * @param Config $eavConfig
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeSetFactory $attributeSetFactory
     */
    public function __construct(
        Config $eavConfig,
        EavSetupFactory $eavSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ) {
        $this->eavConfig            = $eavConfig;
        $this->_eavSetupFactory     = $eavSetupFactory;
        $this->attributeSetFactory  = $attributeSetFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $installer = $setup;

        $eavSetup = $this->_eavSetupFactory->create(['setup' => $setup]);

        $eavSetup->addAttribute('customer_address', 'delivery_address_attribute', [
            'type' => 'varchar',
            'input' => 'text',
            'label' => 'Delivery Address',
            'visible' => true,
            'required' => false,
            'user_defined' => true,
            'system'=> false,
            'group'=> 'General',
            'global' => true,
            'visible_on_front' => true,
        ]);
       
        $customAttribute = $this->eavConfig->getAttribute('customer_address', 'delivery_address_attribute');

		$customAttribute->setData(
			'used_in_forms',
			['adminhtml_customer_address','customer_address_edit','customer_register_address']
		);
        $customAttribute->save();
        
        $setup->endSetup();
    }
}