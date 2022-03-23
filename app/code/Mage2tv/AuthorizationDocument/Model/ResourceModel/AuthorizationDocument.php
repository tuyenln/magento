<?php

namespace Mage2tv\AuthorizationDocument\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AuthorizationDocument extends  AbstractDb
{

    protected function _construct()
    {
        $this->_init('mage2tv_authorization_document', 'id');
    }
}
