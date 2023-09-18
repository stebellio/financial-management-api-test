<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\TableGateway\TransactionGateway;
use Application\TableGateway\UserGateway;
use Laminas\Db\Adapter\AdapterInterface;

class TransactionsResourceFactory
{

    /**
     * @param $services
     * @return TransactionsResource
     */
    public function __invoke($services): TransactionsResource
    {
        /** @var AdapterInterface $adapter */
        $adapter = $services->get('default.adapter');

        return new TransactionsResource(
            new UserGateway($adapter),
            new TransactionGateway($adapter)
        );
    }
}
