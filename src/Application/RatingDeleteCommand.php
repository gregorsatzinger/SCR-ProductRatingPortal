<?php

namespace Application;

class RatingDeleteCommand
{
    const Error_NotAuthenticated = 0x01;
    const Error_DbErrorOccured = 0x02;
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Interfaces\RatingRepository $ratingRepository,
        private \Application\Services\AuthenticationService $authenticationService
    ) {
    }
    public function execute(int $productId): int
    {
        $errors = 0;
        //check for authenticated user
        $userId = $this->authenticationService->getUserId();
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            $rows = $this->ratingRepository->deleteRatingForProduct($userId, $productId);
            if($rows === null) {
                $errors |= self::Error_DbErrorOccured;
            }
        }
        return $errors;
    }
}
