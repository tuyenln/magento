<?php

namespace Mage2tv\Example\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    private $changelog = [
        '0.0.2' => 'addSomeTable',
        '0.0.3' => 'dropColumn'
    ];
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
       $setup->startSetup();
       $tableName = 'mage2tv_example';
      $setup->getConnection()->dropColumn(
            $setup->getTable($tableName), 'description'
      );

       $setup->endSetup();
    }


}
