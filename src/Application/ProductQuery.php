<?php

namespace Application;

class ProductQuery
{
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Interfaces\RatingRepository $ratingRepository
    ) {
    }
    public function execute(int $productId): ?\Application\ProductData
    {
        $p = $this->productRepository->getProductById($productId);
        if($p == null) {
            return null;
        }

        return new ProductData(
            $p->getId(), 
            $p->getName(), 
            $p->getProducer(), 
            $p->getCreatorName(),
            $this->ratingRepository->getCountOfRatingsForProduct($p->getId()),
            $this->ratingRepository->getAvgRatingForProduct($p->getId())
        );
    }
}