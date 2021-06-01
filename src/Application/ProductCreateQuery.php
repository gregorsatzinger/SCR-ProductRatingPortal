<?php

namespace Application;

class ProductCreateQuery
{
    const Error_NotAuthenticated = 0x01;
    const Error_DbErrorOccured = 0x02;
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Services\AuthenticationService $authenticationService
    ) {
    }
    public function execute(string $productName, string $producerName): int
    {
        $errors = 0;
        //check for authenticated user
        $userId = $this->authenticationService->getUserId();
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            $rid = $this->productRepository->createProduct($userId, $productName, $producerName);
            if($rid === null) {
                $errors |= self::Error_DbErrorOccured;
            }
        }
        return $errors;
    }
}
