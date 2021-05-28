<?php

namespace Application\Interfaces;

interface RatingRepository
{
    public function getRatingsForProduct(int $productId): array; //array of \Application\Entities\Rating
}