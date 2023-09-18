<?php

declare(strict_types=1);

namespace Application\Manager;

use Application\Exception\BudgetExceededException;
use Application\Model\Transaction;
use Application\Model\User;
use Application\TableGateway\TransactionGateway;
use DateTime;

use function date;
use function strtotime;

class TransactionManager
{
    public function __construct(
        private TransactionGateway $transactionGateway
    ) {
    }

    /**
     * @throws BudgetExceededException
     */
    public function validateTransaction(User $user, Transaction $transaction): void
    {
        if (! $user->isStrictBalance()) {
            return;
        }

        [$from, $to] = $this->extractMonthRange($transaction);

        $totalUsed = $this->transactionGateway->getUserTotalByPeriod($user->getId(), $from, $to);

        $totalUsed += $transaction->getAmount();

        if ($totalUsed > $user->getBudget()) {
            throw new BudgetExceededException();
        }
    }

    private function extractMonthRange(Transaction $transaction)
    {
        $date = $transaction->getDate() instanceof DateTime
            ? $transaction->getDate()
            : new DateTime($transaction->getDate());

        $year  = $date->format('Y');
        $month = $date->format('m');

        $firstDayOfMonth = new DateTime("$year-$month-01");
        $lastDayOfMonth  = new DateTime("$year-$month-" . date('t', strtotime("$year-$month-01")));

        return [$firstDayOfMonth, $lastDayOfMonth];
    }
}
