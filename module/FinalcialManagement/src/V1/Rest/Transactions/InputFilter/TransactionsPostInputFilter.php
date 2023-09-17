<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions\InputFilter;

use Laminas\Filter\ToFloat;
use Laminas\Filter\ToInt;
use Laminas\Hydrator\ReflectionHydrator;
use Laminas\I18n\Validator\IsFloat;
use Laminas\I18n\Validator\IsInt;
use Laminas\InputFilter\Input;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Date;
use stdClass;

class TransactionsPostInputFilter extends InputFilter
{
    public function __construct()
    {
        $this->addDateInput();
        $this->addAmountInput();
        $this->addCategoryInput();
    }

    private function addDateInput(): void
    {
        $date = new Input('date');
        $date->getValidatorChain()->attach(
            new Date()
        );

        $this->add($date);
    }

    private function addAmountInput(): void
    {
        $amount = new Input('amount');
        $amount->getValidatorChain()->attach(new IsFloat());

        $this->add($amount);
    }

    private function addCategoryInput(): void
    {
        $category = new Input('category');
        $category->getValidatorChain()->attach(new IsInt());

        $this->add($category);
    }
}
