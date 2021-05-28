<?php

namespace Application\Entities;

class Rating
{
    public function __construct(
        private int $id,
        private int $creatorId,
        private int $productId,
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
    public function getDate(): int
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
}