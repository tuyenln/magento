<?php

namespace Mage2tv\EavCustomer\Setup;


use Magento\Customer\Api\AddressMetadataInterface;
use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Model\Config as EavConfig;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * @var EavConfig
     */
    private $eavConfig;

    public function __construct(EavSetupFactory $eavSetupFactory, EavConfig $eavConfig)
    {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->eavConfig = $eavConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $this->addCustomerInterestsAttribute($eavSetup);
        $attributeCode = 'is_home_address';
        $entityType = AddressMetadataInterface::ENTITY_TYPE_ADDRESS;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Is home address?',
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

    private function addEavCustomerAddressAttribute(eavSetup $eavSetup)
    {
//        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $attributeCode = 'is_home_address';
        $entityType = AddressMetadataInterface::ENTITY_TYPE_ADDRESS;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Is home address?',
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

    private function addCustomerInterestsAttribute(EavSetup $eavSetup) {
        $attributeCode = 'interests';
        $entityType = CustomerMetadataInterface::ENTITY_TYPE_CUSTOMER;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Interests',
            'required' => 0,
            'user_defined' => 1,
            'note' => 'Separate multiple interests with a comma',
            'system' => 0,
            'position' => 100,
        ]);

        $eavSetup->addAttributeToSet(
            $entityType,
            CustomerMetadataInterface::ATTRIBUTE_SET_ID_CUSTOMER,
            null,
            $attributeCode
        );

        $attribute = $this->eavConfig->getAttribute($entityType, $attributeCode);
        $attribute->setData('used_in_forms', [
            'adminhtml_customer',
            'customer_account_create',
            'customer_acount_edit'
        ]);
        $attribute->save();
    }
}
