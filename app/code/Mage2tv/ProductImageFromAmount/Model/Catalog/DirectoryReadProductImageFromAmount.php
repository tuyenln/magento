<?php

namespace Mage2tv\ProductImageFromAmount\Model\Catalog;

use Magento\Framework\Filesystem\Directory\Read as DirectoryRead;
use Psr\Log\LoggerInterface;

class DirectoryReadProductImageFromAmount extends DirectoryRead
{
    /**
     * @var LoggerInterface
     */

    private $logger;

    public function __construct(
        \Magento\Framework\Filesystem\File\ReadFactory $fileFactory,
        \Magento\Framework\Filesystem\DriverInterface $driver,
        $path,
        LoggerInterface $logger
    ){
        parent::__construct($fileFactory, $driver, $path);
        $this->logger = $logger;
    }

    public function getAbsolutePath($path = null, $schema = null)
    {
        $this->logger->info(sprintf('Copying product image "%s" from file mount.', $path));
        return parent::getAbsolutePath($path, $schema);
    }

}
