<?php

namespace Application\Interfaces;

interface ProductRepository
{
    public function getProducts(): array; //array of \Application\Entities\Product
}