<?php

namespace Application;

class ProductData
{
    public function __construct(
        private int $id,
        private string $name,
        private string $producer,
        private int $creatorId,
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
}
