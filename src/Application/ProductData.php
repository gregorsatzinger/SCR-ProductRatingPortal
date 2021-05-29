<?php

namespace Application;

class ProductData
{
    public function __construct(
        private int $id,
        private string $name,
        private string $producer,
        private string $creatorName,
        private int $ratingCount,
        private float $avgRating
    ) {
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getProducer(): string
    {
        return $this->producer;
    }
    public function getCreatorName(): string
    {
        return $this->creatorName;
    }
    public function getRatingCount(): int
    {
        return $this->ratingCount;
    }
    public function getAvgRating(): float
    {
        return $this->avgRating;
    }
}
