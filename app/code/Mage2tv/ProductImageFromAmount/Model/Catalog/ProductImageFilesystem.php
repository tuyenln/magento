<?php

namespace Mage2tv\ProductImageFromAmount\Model\Catalog;

use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\Filesystem\Directory\WriteFactory;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\DriverPool;

class ProductImageFilesystem extends Filesystem
{
    /**
     * @var \Mage2tv_ProductImageFromAmount\Model\Catalog\DirectoryReadProductImageFromAmount
     */
    private $factory;

    /**
     * @var DirectoryReadProductImageFromAmount[]
     */

    private $readerInstance = [];

    /**
     * @var DriverPool
     */

    private $filesystemDriverPool;

    public function __construct(
        DirectoryList $directoryList,
        ReadFactory $readerFactory,
        WriteFactory $writerFactory,
        DriverPool $filesystemDriverPool,
        DirectoryReadProductImageFromAmountFactory $directoryReadProductImageFromAmountFactory
    ){
        parent::__construct($directoryList, $readerFactory, $writerFactory);
        $this->factory = $directoryReadProductImageFromAmountFactory;
        $this->filesystemDriverPool = $filesystemDriverPool;
    }

    public function getDirectoryRead($directoryCode, $driverCode = DriverPool::FILE)
    {
        return DriverPool::FILE === $driverCode?
            $this->createCustomDirReader($directoryCode):
            parent::getDirectoryRead($directoryCode, $driverCode);
    }

    private function createCustomDirReader(string $directoryCode): DirectoryReadProductImageFromAmount
    {
        if (!array_key_exists($directoryCode, $this->readerInstance)) {
            $this->readerInstance[$directoryCode] = $this->createProductImageDirReader($directoryCode);
        }
        return $this->readerInstance[$directoryCode];
    }

    private function createProductImageDirReader(string $directoryCode): DirectoryReadProductImageFromAmount
    {
        return $this->factory->create([
            'path' => $this->getDirPath($directoryCode),
            'driver' => $this->filesystemDriverPool->getDriver(DriverPool::FILE)
        ]);
    }


}
