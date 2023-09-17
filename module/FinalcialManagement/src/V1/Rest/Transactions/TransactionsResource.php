<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\TableGateway\TransactionGateway;
use Exception;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Http\Response;

use function json_encode;

class TransactionsResource extends AbstractResourceListener
{
    public function __construct(
        private TransactionGateway $transactionGateway,
    ) {
        $this->inputFilter = new TransactionsInputFilter();
    }

    /**
     * @param $params
     * @return TransactionsCollection|ApiProblem
     */
    public function fetchAll($params = []): ApiProblem|TransactionsCollection
    {
        $this->inputFilter->setData($params);

        if (! $this->inputFilter->isValid()) {
            return new ApiProblem(Response::STATUS_CODE_400, json_encode($this->inputFilter->getMessages()));
        }

        return new TransactionsCollection(
            $this->transactionGateway->getAllPaginated(
                $this->inputFilter->getValues(),
                TransactionsPaginatorAdapter::class
            )
        );
    }

    public function create($data)
    {
        return parent::create($data);
    }
}
