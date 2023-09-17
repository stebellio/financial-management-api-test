<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\TableGateway\TransactionGateway;
use FinalcialManagement\V1\Rest\Transactions\InputFilter\TransactionsParamsInputFilter;
use FinalcialManagement\V1\Rest\Transactions\InputFilter\TransactionsPostInputFilter;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Http\Response;
use function json_encode;

class TransactionsResource extends AbstractResourceListener
{
    public function __construct(
        private TransactionGateway $transactionGateway,
    ) {
    }

    /**
     * @param $params
     * @return TransactionsCollection|ApiProblem
     */
    public function fetchAll($params = []): ApiProblem|TransactionsCollection
    {
        $this->inputFilter = new TransactionsParamsInputFilter();
        $this->inputFilter->setData($params);

        if (! $this->inputFilter->isValid()) {
            return new ApiProblem(Response::STATUS_CODE_400, json_encode($this->inputFilter->getMessages()));
        }

        $filters = $this->inputFilter->getValues();
        $filters['userId'] = $this->getAuthenticatedUserId();

        return new TransactionsCollection(
            $this->transactionGateway->getAllPaginated(
                $filters,
                TransactionsPaginatorAdapter::class
            )
        );
    }

    public function create($data)
    {
        $this->inputFilter = new TransactionsPostInputFilter();

        $this->inputFilter->setData((array) $data);

        if (! $this->inputFilter->isValid()) {
            return new ApiProblem(Response::STATUS_CODE_400, json_encode($this->inputFilter->getMessages()));
        }

        $data->userId = $this->getAuthenticatedUserId();

        return $data;
    }

    private function getAuthenticatedUserId(): int
    {
        return (int) $this->getIdentity()->getAuthenticationIdentity()['user_id'];
    }
}
