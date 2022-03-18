<?php

namespace Mage2tv\BrandExample\Setup\Patch\Data;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchInterface;

class InitializeDefaultBrands implements DataPatchInterface
{
    /**
     * @var ModuleDataSetupInterface
     */
    private $moduleDataSetup;

    public function __construct(ModuleDataSetupInterface $moduleDataSetup)
    {
        $this->moduleDataSetup = $moduleDataSetup;
    }

    public static function getDependencies()
    {
        return [
            \Magento\Store\Setup\Patch\Schema\InitializeStoresAndWebsites::class,
        ];
    }

    public function getAliases()
    {
        return [
            \Mage2tv\BrandExample\Setup\Patch\Data\CreateDefaultBrands::class
        ];
    }

    public function apply()
    {
        $brands = [
            ['name' => 'Trung Nguyen', 'description' => 'Something cool'],
            ['name' => 'HAGL', 'description' => 'Something cool more'],
            ['name' => 'HN T&T', 'description' => 'to cool to care']
        ];
        $records = array_map(function ($brand) {
            return array_merge($brand, ['is_enabled' => 1 , 'website_id' => 1]);
        }, $brands);

        $this->moduleDataSetup->getConnection()->insertMultiple('mage2tv_brand_example', $records);
        return $this;
    }
}
