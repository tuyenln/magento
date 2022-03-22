<?php

namespace Mage2tv\EavCustomer\Setup\Patch\Data;

use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Eav\Model\Config as EavConfig;

class AddCustomerAttributes implements DataPatchInterface
{

    /**
     * ModuleDataSetupInterface
     *
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    /**
     * EavSetupFactory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    /**
     * AddProductAttribute constructor.
     *
     * @param ModuleDataSetupInterface  $moduleDataSetup
     * @param EavSetupFactory           $eavSetupFactory
     */
    public function __construct(
        ModuleDataSetupInterface $moduleDataSetup,
        EavSetupFactory $eavSetupFactory,
        EavConfig $eavConfig
    ) {
        $this->moduleDataSetup = $moduleDataSetup;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public static function getDependencies()
    {
        return [];
    }

    public function getAliases()
    {
        return [];
    }

    public function apply()
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);
        $attributeCode = 'is_brand';
        $entityType = AddressMetadataInterface::ENTITY_TYPE_ADDRESS;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Is Brand?',
            'type' => 'int',
            'input' => 'boolean',
            'required' => 0,
            'user_defined' => 1,
            'default'   => 0,
            'system' => 0,
            'position' => 50,
        ]);

        $eavSetup->addAttributeToSet(
            $entityType,
            AddressMetadataInterface::ATTRIBUTE_SET_ID_ADDRESS,
            null,
            $attributeCode
        );
        $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);
        $attribute->setData('used_in_forms', [
            'adminhtml_customer_address',
            'customer_address_edit',
            'customer_register_address'
        ]);
        $attribute->save();
    }
}
