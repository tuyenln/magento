<?php

namespace Mage2tv\PluginExampleA\Plugin;


use Magento\Customer\Controller\Account\Index;

class PluginA
{
    public function beforeExecute(Index $subject)
    {
        echo '<script>console.log("Plugin A before")</script>';
    }

    public function aroundExecute(Index $subject, callable $proceed)
    {
        echo '<script>console.log("Plugin A around pre-proceed")</script>';
        $result = $proceed();
        echo '<script>console.log("Plugin A around post-proceed")</script>';

        return $result;
    }

    public function afterExecute(Index $subject, $result)
    {
        echo '<script>console.log("Plugin A after")</script>';
        return $result;
    }
}
