<?php

declare(strict_types=1);

namespace Application\TableGateway;

use Application\Hydrator\DbHydrator;
use Application\Model\Transaction;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Expression;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Paginator\Adapter\DbSelect;

class TransactionGateway extends AbstractTableGateway
{
    /** @var string */
    protected $table = 'transactions';

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter            = $adapter;
        $this->resultSetPrototype = new HydratingResultSet(
            new DbHydrator(),
            new Transaction()
        );
        $this->initialize();
    }

    public function getAllPaginated(array $params = [], string $paginatorAdapterClass = DbSelect::class): DbSelect
    {
        $sql = $this->getSql();

        $select = $sql->select();
        $count  = $sql->select();

        $select->columns([
            'id',
            'amount',
            'date',
        ]);
        $count->columns(['c' => new Expression('COUNT(*)')]);

        $select->join(
            ['c' => 'categories'],
            'transactions.category_id = c.id',
            [
                'categoryId'   => 'id',
                'categoryName' => 'name',
            ]
        );

        if (! empty($params)) {
            $conditions = $this->createQueryConditions($params);
            $select->where($conditions);
            $count->where($conditions);
        }

        return new $paginatorAdapterClass(
            $select,
            $sql,
            $this->resultSetPrototype,
            $count
        );
    }

    /**
     * @param array $params
     * @return array
     */
    private function createQueryConditions(array $params = []): array
    {
        $conditions = [];

        if ($params['userId']) {
            $conditions['userId'] = $params['userId'];
        }

        if ($params['dateFrom']) {
            $date         = $params['dateFrom'];
            $conditions[] = "date >= '$date'";
        }

        if ($params['dateFrom']) {
            $date         = $params['dateTo'];
            $conditions[] = "date <= '$date'";
        }

        return $conditions;
    }
}
