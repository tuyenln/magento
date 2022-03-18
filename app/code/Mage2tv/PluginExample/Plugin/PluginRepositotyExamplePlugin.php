<?php

namespace Mage2tv\PluginExample\Plugin;
use Magento\Catalog\Api\Data\ProductInterface;
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

    public function aroundGetById(
        ProductRepositoryInterface $subject,
        callable $proceed,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    ){
        $this->logger->info("Around before get product by ID ". $productId);
        $result = $proceed($productId, $editMode, $storeId, $forceReload);
        $this->logger->info("Around after get product by ID ". $productId);
        return $result;
    }

    public function afterGetById(
        ProductRepositoryInterface $subject,
        ProductInterface $result,
        $productId,
        $editMode = false,
        $storeId = null,
        $forceReload = false
    )
    {
        $this->logger->info("After get product by ID ". $result->getId());
        return $result;
    }
}
