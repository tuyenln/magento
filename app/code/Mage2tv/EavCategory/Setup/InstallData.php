<?php

namespace Mage2tv\EavCategory\Setup;


use Magento\Catalog\Api\Data\CategoryAttributeInterface;
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
        $attributeCode = 'external_id';
        $entityType = CategoryAttributeInterface::ENTITY_TYPE_CODE;

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'External Id',
            'user_defined' => 1,
            'unique' => 1,
        ]);

        $setId = $eavSetup->getDefaultAttributeSetId($entityType);
        $groupId = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        $eavSetup->addAttributeToSet($entityType, $setId, $groupId, $attributeCode);
    }
}
