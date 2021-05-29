<?php

namespace Application;

class RatingData
{
    public function __construct(
        private int $id,
        private int $creatorId,
        private string $creatorName,
        private int $productId,
        private string $productName,
        private string $date,
        private int $rating,
        private string $comment
    ) {
    }
    public function getId(): int
    {
        return $this->id;
    }
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }
    public function getProductId(): int
    {
        return $this->productId;
    }
    public function getDate(): string
    {
        return $this->date;
    }
    public function getRating(): int
    {
        return $this->rating;
    }
    public function getComment(): string
    {
        return $this->comment;
    }
    public function getCreatorName(): string
    {
        return $this->creatorName;
    }
    public function getProductName(): string
    {
        return $this->productName;
    }
}
