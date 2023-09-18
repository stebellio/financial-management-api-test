<?php

declare(strict_types=1);

namespace Application\TableGateway;

use Application\Hydrator\DbHydrator;
use Application\Model\Transaction;
use DateTime;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\Sql\Expression;
use Laminas\Db\Sql\Sql;
use Laminas\Db\TableGateway\AbstractTableGateway;
use Laminas\Paginator\Adapter\DbSelect;

use const DATE_ATOM;

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

    public function getUserTotalByPeriod(int $userId, DateTime $from, DateTime $to): float
    {
        $sql = new Sql($this->getAdapter());

        $dateFrom = $from->format(DATE_ATOM);
        $dateTo   = $to->format(DATE_ATOM);

        $result = $sql->prepareStatementForSqlObject(
            $sql->select($this->table)
                ->columns([
                    'total' => new Expression('SUM(amount)'),
                ])
                ->where(['userId' => $userId])
            ->where("date >= '$dateFrom'")
            ->where("date <= '$dateTo'")
        )->execute()->current();

        return (float) $result['total'];
    }

    public function addTransaction(Transaction $transaction)
    {
        $date = $transaction->getDate();

        $this->insert([
            'amount'      => $transaction->getAmount(),
            'date'        => $date instanceof DateTime
                ? $date->format(DATE_ATOM)
                : $date,
            'category_id' => $transaction->getCategoryId(),
            'created'     => (new DateTime())->format(DATE_ATOM),
            'userId'      => $transaction->getUserId(),
        ]);

        return $this->getLastInsertValue();
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
