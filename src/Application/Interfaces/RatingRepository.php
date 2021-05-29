<?php

namespace Application\Interfaces;

interface RatingRepository
{
    public function getRatingsForProduct(int $productId): array; //array of \Application\Entities\Rating
    public function getAvgRatingForProduct(int $productId): float; 
    public function getCountOfRatingsForProduct(int $productId): int; 

}