<?php

namespace Mage2tv\Example\Setup;

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
       $tableName = 'mage2_example';
       $newTableName = 'mage2tv_example';
       $setup->getConnection()->renameTable(
           $setup->getTable($tableName),
           $setup->getTable($newTableName)
       );
//       $setup->getConnection()->changeColumn($setup->getTable($tableName), $columnName, $columnName, [
//           'type' => Table::TYPE_TEXT,
//           'length' => $maxLength,
//           'nullable' => true,
//           'after' => 'description',
//           'comment' => 'Image URL'
//       ]);
//       $setup->getConnection()->addColumn($setup->getTable($tableName), $columnName, [
//           'type' => Table::TYPE_TEXT,
//           'length' => 255,
//           'nullable' => true,
//           'after' => 'description',
//           'comment' => 'Image URL'
//       ]);

       $setup->endSetup();
    }


}
