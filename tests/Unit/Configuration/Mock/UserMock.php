<?php

declare(strict_types=1);

namespace Test\Unit\Configuration\Mock;

class UserMock
{
    public function __construct(
        public string $id,
        public string $age
    ) {}

    public function __toString(): string
    {
        return $this->id;
    }
}
