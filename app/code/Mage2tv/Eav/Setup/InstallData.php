<?php

namespace Mage2tv\Eav\Setup;

use Magento\Catalog\Api\Data\ProductAttributeInterface;
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
        $attributeCode = 'legacy_sku';
        $entityType = ProductAttributeInterface::ENTITY_TYPE_CODE;
        $setId = $eavSetup->getDefaultAttributeSetId($entityType);
        $groupId = $eavSetup->getDefaultAttributeGroupId($entityType, $setId);
        $groupName = $eavSetup->getAttributeGroup($entityType, $setId, $groupId, 'attribute_group_name');

        $eavSetup->addAttribute($entityType, $attributeCode, [
            'label' => 'Legacy SKU',
            'required' => 0,
            'user_defined' => 1,
            'unique' => 1,
            'searchable' => 1,
            'visible_on_front' => 1,
            'visible_in_advance_search' => 1,
            'is_used_in_grid'   => 1,
            'group' => $groupName,
            'sort_order' => 30
        ]);
    }
}
