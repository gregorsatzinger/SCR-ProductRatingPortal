<?php

namespace Application\Interfaces;

interface RatingRepository
{
    public function getRatingsForProduct(int $productId): array; //array of \Application\Entities\Rating
    public function getAvgRatingForProduct(int $productId): float; 
    public function getCountOfRatingsForProduct(int $productId): int; 
    public function createOrUpdateRatingForProduct(int $creatorId, int $productId, int $rating, string $comment): ?int; 
}