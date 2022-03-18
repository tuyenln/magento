<?php

namespace Mage2tv\PluginExampleB\Plugin;


use Magento\Customer\Controller\Account\Index;

class PluginB
{
    public function beforeExecute(Index $subject)
    {
        echo '<script>console.log("Plugin B before")</script>';
    }

    public function aroundExecute(Index $subject, callable $proceed)
    {
        echo '<script>console.log("Plugin B around pre-proceed")</script>';
        $result = $proceed();
        echo '<script>console.log("Plugin B around post-proceed")</script>';

        return $result;
    }

    public function afterExecute(Index $subject, $result)
    {
        echo '<script>console.log("Plugin B after")</script>';
        return $result;
    }
}
