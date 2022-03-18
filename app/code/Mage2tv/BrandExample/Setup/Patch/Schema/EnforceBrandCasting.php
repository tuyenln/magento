<?php

namespace Mage2tv\BrandExample\Setup\Patch\Schema;

use Mage2tv\BrandExample\Setup\StoreRoutinesProvider;
use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\DB\Ddl\Trigger;
use Magento\Framework\DB\Ddl\TriggerFactory;
use Magento\Framework\Setup\Patch\PatchInterface;
use Magento\Framework\Setup\Patch\SchemaPatchInterface;
use Magento\Framework\Setup\SchemaSetupInterface;;

class EnforceBrandCasting implements SchemaPatchInterface
{

    private $storeRoutinesProvider;

    private $schemaSetup;

    private $triggerFactory;

    public function __construct(
        StoreRoutinesProvider $storeRoutinesProvider,
        SchemaSetupInterface $schemaSetup,
        TriggerFactory $triggerFactory
    )
    {
        $this->storeRoutinesProvider = $storeRoutinesProvider;
        $this->schemaSetup = $schemaSetup;
        $this->triggerFactory = $triggerFactory;
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
        $db = $this->schemaSetup->getConnection();
        if ($db instanceof Mysql)
        foreach($this->storeRoutinesProvider->getStoreFunctionSql() as $sql) {
            strpos(rtrim($sql, "; \n\t"), ';') !== false ?
                $db->multiQuery($sql) :
            $db->query($sql);
        }

        $this->createTriggerToEnforceConsistentCasing();
    }

    private function createTriggerToEnforceConsistentCasing(): void
    {
        $db = $this->schemaSetup->getConnection();
        $tableName = $this->schemaSetup->getTable('mage2tv_brand_example');
        foreach ([Trigger::EVENT_INSERT, Trigger::EVENT_UPDATE] as $event) {
            $trigger = $this->triggerFactory->create();
            $triggerName = $db->getTriggerName($tableName, Trigger::TIME_BEFORE, $event);
            $trigger->setName($triggerName);
            $trigger->setTime(Trigger::TIME_BEFORE);
            $trigger->setEvent($event);
            $trigger->setTable($tableName);

            $trigger->addStatement("SET
                NEW.name = UCWORD(NEW.name),
                NEW.description = CONCAT(UCFIRST_WORD(NEW.description), ' ', BUT_FIRST_WORD(NEW.description))
            ");

            $db->dropTrigger($triggerName);
            $db->createTrigger($trigger);
        }
    }
}
