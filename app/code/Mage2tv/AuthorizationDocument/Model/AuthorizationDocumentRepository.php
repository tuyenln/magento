<?php

namespace Mage2tv\AuthorizationDocument\Model;

use Mage2tv\AuthorizationDocument\Api\Data\AuthorizationDocumentInterface;
use Mage2tv\AuthorizationDocument\Model\ResourceModel\AuthorizationDocument as AuthorizationDocumentResource;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class AuthorizationDocumentRepository
{
    /**
     * @var AuthorizationDocumentFactory
     */
    private $authorizationDocumentFactory;

    /**
     * @var AuthorizationDocumentResource
     */
    private $authorizationDocumentResource;

    /**
     * @var AuthorizationDocumentResource\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var DataObjectProcessor
     */
    private $dtProcessor;

    public  function __construct(
        AuthorizationDocumentFactory $authorizationDocumentFactory,
        AuthorizationDocumentResource $authorizationDocumentResource,
        AuthorizationDocumentResource\Collection $collectionFactory,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->authorizationDocumentFactory = $authorizationDocumentFactory;
        $this->authorizationDocumentResource = $authorizationDocumentResource;
        $this->collectionFactory = $collectionFactory;
        $this->dtProcessor = $dataObjectProcessor;
    }

    private function ensureIsModel(AuthorizationDocumentInterface $documentDto): AuthorizationDocument
    {
        return $documentDto instanceof AuthorizationDocument ? $documentDto : $this->convertDtoToModel($documentDto);
    }

    private function convertDtoToModel(AuthorizationDocumentInterface $documentDto): AuthorizationDocument
    {
        $data = $this->dtProcessor->buildOutputDataArray($documentDto, AuthorizationDocumentInterface::class);
        $documentModel = $this->authorizationDocumentFactory->create();
        $documentModel->setData($data);

        return $documentModel;
    }

    public function getByCustomerId(int $customerId): AuthorizationDocumentInterface
    {
        $documents = $this->collectionFactory->create();
        $documents->addfieldToFilter('customer_id', $customerId);
        if ($documents->count() > 0 ) {
            $document = $documents->getFirstItem();
            return $document;
        }
        throw new NoSuchEntityException();
    }

    public function deleteForCustomerId(int $customerId): void
    {
        $documents = $this->collectionFactory->create();
        $documents->addFieldToFilter('customer_id', $customerId);
        $documents->walk('delete');
    }

    public function setForCustomerId(int $customerId, AuthorizationDocumentInterface $authorizationDocument): void
    {
        try {
            $existingDocument = $this->getByCustomerId($customerId);
            if ($existingDocument->getId() != $authorizationDocument->getId()) {
                $this->authorizationDocumentResource->delete($this->ensureIsModel($existingDocument));
            }
        } catch (NoSuchEntityException $exception) {

        }
        $authorizationDocument->setCustomerId($customerId);
        $this->authorizationDocumentResource->save($this->ensureIsModel($authorizationDocument));
    }

    public function getByCustomerIds(int ... $customerIds): array
    {
        $documents = $this->collectionFactory->create();
        $documents->addfieldToFilter('customer_id', ['in' => $customerIds]);
        return $documents->getItems();
    }
}
