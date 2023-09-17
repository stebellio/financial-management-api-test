<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions\InputFilter;

use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Date;

class TransactionsParamsInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->addDateInput('dateFrom');
        $this->addDateInput('dateTo');
    }

    private function addDateInput(string $name): void
    {
        $date = new Input($name);
        $date->getValidatorChain()->attach(
            new Date()
        );
        $date->setRequired(false);

        $this->add($date);
    }
}
