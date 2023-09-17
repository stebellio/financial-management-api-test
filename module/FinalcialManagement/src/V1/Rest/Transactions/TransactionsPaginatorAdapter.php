<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\Model\Transaction;
use Exception;
use Laminas\Paginator\Adapter\DbSelect;

class TransactionsPaginatorAdapter extends DbSelect
{
    /**
     * @param $offset
     * @param $itemCountPerPage
     * @return array
     * @throws Exception
     */
    public function getItems($offset, $itemCountPerPage): array
    {
        $results = parent::getItems($offset, $itemCountPerPage);

        $transformedResults = [];

        /** @var Transaction $result */
        foreach ($results as $result) {
            $entity = new TransactionsEntity();
            $entity->initFromModel($result);

            $transformedResults[] = $entity;
        }

        return $transformedResults;
    }
}
