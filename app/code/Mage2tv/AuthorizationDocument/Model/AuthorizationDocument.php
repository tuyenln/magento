<?php

namespace Mage2tv\AuthorizationDocument\Model;

use Mage2tv\AuthorizationDocument\Api\Data\AuthorizationDocumentInterface;
use Mage2tv\AuthorizationDocument\Model\ResourceModel\AuthorizationDocument as AuthorizationDocumentResource;
use Magento\Framework\Model\AbstractModel;

class AuthorizationDocument extends AbstractModel  implements AuthorizationDocumentInterface
{
    protected function _construct()
    {
        $this->_init(AuthorizationDocumentResource::class);
    }

    public function setCustomerId($customerId): void
    {
        $this->setData('customer_id', $customerId);
    }
    public function getCustomerId(): ?int
    {
        $customerId = $this->getData('customer_id');
        return $customerId ? (int) $customerId : null;
    }

    public function setFile(?string $file): void
    {
        $this->setData('file', $file);
    }

    public function getFile(): ?string
    {
        return $this->_getData('file');
    }

    public function setDocumentType(?string $documentType): void
    {
        $this->setData('document_type', $documentType);
    }

    public function getDocumentType(): ?string
    {
        return $this->_getData('document_type');
    }

    public function setValidatedAt(?string $validatedAt): void
    {
        $this->setData('validated_at', $validatedAt);
    }

    public function getValidatedAt(): ?string
    {
        return $this->_getData('validated_at');
    }

    public function setValidatedBy(?string $validatedBy): void
    {
        $this->setData('validated_by', $validatedBy);
    }

    public function getValidatedBy(): ?string
    {
        return $this->_getData('validated_by');
    }

    public function setValidationStatus(?string $validationStatus): void
    {
        $this->setData('validation_status', $validationStatus);
    }

    public function getValidationStatus(): ?string
    {
        return $this->_getData('validation_status');
    }

    public function setExpiryDate(?string $expireDate): void
    {
        $this->setData('expiry_date', $expireDate);
    }

    public function getExpiryDate(): ?string
    {
        return $this->_getData('expiry_date');
    }

    public function setAdditionalInformation(?string $additionalInformation): void
    {
        $this->setData('additional_information', $additionalInformation);
    }

    public function getAdditionalInformation(): ?string
    {
        return $this->_getData('additional_information');
    }


}
