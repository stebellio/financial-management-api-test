<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\Model\Transaction;
use DateTime;
use Exception;

class TransactionsEntity
{
    public int $id;
    public float $amount;
    public DateTime $date;

    public array $category;

    /**
     * @throws Exception
     */
    public function initFromModel(Transaction $transaction): void
    {
        $this->id       = $transaction->getId();
        $this->amount   = $transaction->getAmount();
        $this->date     = new DateTime($transaction->getDate());
        $this->category = [
            'id'   => $transaction->getCategoryId(),
            'name' => $transaction->getCategoryName(),
        ];
    }
}
