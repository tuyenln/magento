<?php

namespace Mage2tv\AuthorizationDocument\Api\Data;

interface AuthorizationDocumentInterface
{

    public function setId($id);

    public function getId();

    public function setCustomerId($customerId): void;

    public function getCustomerId(): ?int;

    public function setFile(?string $file): void;

    public function getFile(): ?string;

    public function setDocumentType(?string $documentType): void;

    public function getDocumentType(): ?string;

    public function setValidatedAt(?string $validatedAt): void;

    public function getValidatedAt(): ?string;

    public function setValidatedBy(?string $validatedBy): void;

    public function getValidatedBy(): ?string;

    public function setValidationStatus(?string $validationStatus): void;

    public function getValidationStatus(): ?string;

    public function setExpiryDate(?string $expireDate): void;

    public function getExpiryDate(): ?string;

    public function setAdditionalInformation(?string $additionalInformation): void;

    public function getAdditionalInformation(): ?string;
}
