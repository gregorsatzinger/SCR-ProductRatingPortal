<?php

namespace Application;

class ProductCreationQuery
{
    const Error_NotAuthenticated = 0x01;
    const Error_DbErrorOccured = 0x02;
    const Error_InvalidProductName = 0x04;
    const Error_InvalidProducer = 0x08;

    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Services\AuthenticationService $authenticationService
    ) {
    }
    public function execute(?int $productId, string $productName, string $producerName): int
    {
        $errors = 0;
        //check for authenticated user
        $userId = $this->authenticationService->getUserId();
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }
        if(strlen($productName) == 0) {
            $errors |= self::Error_InvalidProductName;
        }
        if(strlen($producerName) == 0) {
            $errors |= self::Error_InvalidProducer;
        }

        if(!$errors) {
            $result = null;
            if($productId === null) {
                $result = $this->productRepository->createProduct($userId, $productName, $producerName);
            } else {
                $result = $this->productRepository->updateProduct($userId, $productId, $productName, $producerName);
            }
            if($result === null) {
                $errors |= self::Error_DbErrorOccured;
            }
        }
        return $errors;
    }
}
