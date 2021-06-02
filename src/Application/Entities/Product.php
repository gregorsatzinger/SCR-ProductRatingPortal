<?php

namespace Application\Entities;

class Product
{
    public function __construct(
        private int $id,
        private string $name,
        private string $producer,
        private int $creatorId,
        private string $creatorName,
        private string $image
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
    public function getCreatorId(): int
    {
        return $this->creatorId;
    }
    public function getCreatorName(): string
    {
        return $this->creatorName;
    }
    public function getImage(): string
    {
        return $this->image;
    }
}
