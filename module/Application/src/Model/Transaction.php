<?php

declare(strict_types=1);

namespace Application\Model;

use DateTime;

use function date;
use function strtotime;

class Transaction
{
    private int $id;
    private float $amount;
    private DateTime|string $date;
    private int $categoryId;
    private string $categoryName;

    private string $created;

    private int $userId;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getDate(): DateTime|string
    {
        return $this->date;
    }

    public function setDate(DateTime|string $date): void
    {
        $this->date = $date;
    }

    public function getCreated(): string
    {
        return $this->created;
    }

    public function setCreated(string $created): void
    {
        $this->created = $created;
    }

    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): void
    {
        $this->categoryName = $categoryName;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }


}
