<?php

namespace Mage2tv\PluginExample\Plugin;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Psr\Log\LoggerInterface;

class PluginRepositotyExamplePlugin
{
    /**
     * @param LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function beforeGetById(
        ProductRepositoryInterface $subject,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ){
        $this->logger->info("Before get product by id ". $productId);
        return [$productId, $editMode, $storeId, $forceReload];
    }
}
