<?php

namespace Mage2tv\AuthorizationDocument\Model\ResourceModel\AuthorizationDocument;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(AuthorizationDocumentModel::class, AuthorizationDocumentResource::class);
    }
}
