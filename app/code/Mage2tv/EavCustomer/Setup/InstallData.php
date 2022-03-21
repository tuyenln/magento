<?php

namespace Mage2tv\EavCategory\Setup;


use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    /**
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
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

        $setId = $eavSetup->getDefaultAttributeSetId($entityType);
        $groupId = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        $eavSetup->addAttributeToSet($entityType, $setId, $groupId, $attributeCode);
    }
}
