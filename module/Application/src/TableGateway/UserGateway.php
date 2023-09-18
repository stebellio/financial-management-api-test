<?php

namespace Application\TableGateway;

use Application\Hydrator\DbHydrator;
use Application\Model\Transaction;
use Application\Model\User;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\HydratingResultSet;
use Laminas\Db\TableGateway\AbstractTableGateway;

class UserGateway extends AbstractTableGateway
{

    /** @var string */
    protected $table = 'user';

    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter            = $adapter;
        $this->resultSetPrototype = new HydratingResultSet(
            new DbHydrator(),
            new User()
        );
        $this->initialize();
    }


}