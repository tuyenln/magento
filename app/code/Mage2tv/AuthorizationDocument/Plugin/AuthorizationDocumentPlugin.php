<?php

namespace Mage2tv\AuthorizationDocument\Plugin;

use Mage2tv\AuthorizationDocument\Model\AuthorizationDocumentRepository;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerExtensionInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\NoSuchEntityException;

class AuthorizationDocumentPlugin
{
    /**
     * @var AuthorizationDocumentRepository
     */
    private $authorizationDocumentRepository;

    public function __construct(AuthorizationDocumentRepository $authorizationDocumentRepository)
    {
        $this->authorizationDocumentRepository = $authorizationDocumentRepository;
    }
    public function afterGet(CustomerRepositoryInterface $subject, CustomerInterface $result): CustomerInterface
    {
        $this->poppulateAuthorizationDocumentExtAttr( $result->getId() , $result->getExtensionAttributes());
        return $result;
    }

    public function afterGetById(CustomerRepositoryInterface  $subject, CustomerInterface $result): CustomerInterface
    {
        echo 1;die;
        $this->poppulateAuthorizationDocumentExtAttr( $result->getId() , $result->getExtensionAttributes());
        return $result;
    }

    private function poppulateAuthorizationDocumentExtAttr (
        int $customerId,
        CustomerExtensionInterface $customerExtensionAttributes
    ): void {
        if ($customerExtensionAttributes->getMage2tvAuthorizationDocument()) {
            return;
        }
        try {
            $document = $this->authorizationDocumentRepository->getByCustomerId($customerId);
            $customerExtensionAttributes->setMage2tvAuthorizationDocument($document);
        } catch (NoSuchEntityException $exception) {

        }
    }

    /**
     * @throw AlreadyExistsException
     */
    public function aroundSave(
        CustomerRepositoryInterface $subject,
        callable $proceed,
        CustomerInterface $customer,
        $passwordHash= null
    ): CustomerInterface
    {
        $authorizationDocument = $customer->getExtensionAttributes()->getMage2tvAuthorizationDocument();

        /** @var CustomerInterface $result */
        $result = $proceed($customer, $passwordHash);

        if ($authorizationDocument) {
            $this->authorizationDocumentRepository->setForCustomerId((int)$result->getId(), $authorizationDocument);
        } else {
            $this->authorizationDocumentRepository->deleteForCustomerId((int)$result->getId());
        }
        return $result;
    }
}
