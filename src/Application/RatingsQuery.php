<?php

namespace Application;

class RatingsQuery
{
    public function __construct(
        private \Application\Interfaces\RatingRepository $ratingRepository
    ) {
    }
    public function execute(int $productId): array
    {
        $res = [];
        foreach ($this->ratingRepository->getRatingsForProduct($productId) as $p) {
            $res[] = new RatingData(
                $p->getId(), 
                $p->getCreatorId(), 
                $p->getCreatorName(),
                $p->getProductId(),
                $p->getProductName(),
                $p->getDate(),
                $p->getRating(),
                $p->getComment()
            );
        }
        return $res;
    }
}
