<?php

declare(strict_types=1);

namespace Application\Model;

class User
{
    private int $id;

    private string $username;

    private float $budget;

    private bool $strict;

    public function getId(): int
    {
        return $this->id;
    }

    public function getBudget(): float
    {
        return $this->budget;
    }

    public function isStrictBalance()
    {
        return $this->strict;
    }
}
