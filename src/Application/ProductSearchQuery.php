<?php

namespace Application;

class ProductSearchQuery
{
    public function __construct(
        private Interfaces\ProductRepository $productRepository,
        private \Application\Interfaces\RatingRepository $ratingRepository
    ) {
    }

    public function execute(string $filter): array
    {
        $res = [];
        foreach ($this->productRepository->getProductsForFilter($filter) as $p) {
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
