<?php

namespace Application;

class ProductsQuery
{
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository,
        private \Application\Interfaces\RatingRepository $ratingRepository
    ) {
    }
    public function execute(): array
    {
        $res = [];
        foreach ($this->productRepository->getProducts() as $p) {
            $res[] = new ProductData(
                $p->getId(), 
                $p->getName(), 
                $p->getProducer(), 
                $p->getCreatorName(),
                $this->ratingRepository->getCountOfRatingsForProduct($p->getId()),
                $this->ratingRepository->getAvgRatingForProduct($p->getId())
            );
        }
        return $res;
    }
}
