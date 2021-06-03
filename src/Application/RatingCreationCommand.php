<?php

namespace Application;

class RatingCreationCommand
{
    const Error_NotAuthenticated = 0x01;
    const Error_DbErrorOccured = 0x02;
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Interfaces\RatingRepository $ratingRepository,
        private \Application\Services\AuthenticationService $authenticationService
    ) {
    }
    public function execute(int $productId, int $rating, string $comment): int
    {
        $errors = 0;
        //check for authenticated user
        $userId = $this->authenticationService->getUserId();
        if($userId === null) {
            $errors |= self::Error_NotAuthenticated;
        }

        if(!$errors) {
            $rid = $this->ratingRepository->createOrUpdateRatingForProduct($userId, $productId, $rating, $comment);
            if($rid === null) {
                $errors |= self::Error_DbErrorOccured;
            }
        }
        return $errors;
    }
}
