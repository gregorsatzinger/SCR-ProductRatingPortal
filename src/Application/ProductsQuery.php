<?php

namespace Application;

class ProductsQuery
{
    public function __construct(
        private \Application\Interfaces\ProductRepository $productRepository
    ) {
    }
    public function execute(): array
    {
        $res = [];
        foreach ($this->productRepository->getProducts() as $p) {
            $res[] = new ProductData($p->getId(), $p->getName(), $p->getProducer(), $p->getCreatorName());
        }
        return $res;
    }
}
