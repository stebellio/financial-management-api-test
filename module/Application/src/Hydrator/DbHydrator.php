<?php

declare(strict_types=1);

namespace Application\Hydrator;

use Laminas\Hydrator\ReflectionHydrator;
use Laminas\Hydrator\Strategy\DateTimeFormatterStrategy;

class DbHydrator extends ReflectionHydrator
{
    public function __construct()
    {
        $this->addStrategy('date', new DateTimeFormatterStrategy());
    }
}
