<?php

namespace Application\Interfaces;

interface ProductRepository
{
    public function getProducts(): array; //array of \Application\Entities\Product
    public function getProductById(int $productId): ?\Application\Entities\Product;
    public function getProductsForFilter(string $filter): array; //array of \Application\Entities\Product
    public function createProduct(int $userId, string $productName, string $producerName): ?int;
    public function updateProduct(int $userId, int $productId, string $productName, string $producerName): ?int;
}