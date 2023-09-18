<?php

declare(strict_types=1);

namespace FinalcialManagement\V1\Rest\Transactions;

use Application\Exception\BudgetExceededException;
use Application\Exception\InvalidContentException;
use Application\Exception\ParametersException;
use Application\Exception\UserNotFoundException;
use Application\Manager\TransactionManager;
use Application\Model\Transaction;
use Application\Model\User;
use Application\TableGateway\TransactionGateway;
use Application\TableGateway\UserGateway;
use FinalcialManagement\V1\Rest\Transactions\InputFilter\TransactionsParamsInputFilter;
use FinalcialManagement\V1\Rest\Transactions\InputFilter\TransactionsPostInputFilter;
use Laminas\ApiTools\ApiProblem\ApiProblem;
use Laminas\ApiTools\Rest\AbstractResourceListener;
use Laminas\Http\Response;
use function json_encode;

class TransactionsResource extends AbstractResourceListener
{

    private TransactionManager $transactionManager;

    public function __construct(
        private UserGateway        $userGateway,
        private TransactionGateway $transactionGateway,
    )
    {
        $this->transactionManager = new TransactionManager($this->transactionGateway);
    }

    /**
     * @param $params
     * @return TransactionsCollection|ApiProblem
     * @throws UserNotFoundException
     */
    public function fetchAll($params = []): ApiProblem|TransactionsCollection
    {


        try {
            $this->inputFilter = new TransactionsParamsInputFilter();
            $this->inputFilter->setData($params);

            if (!$this->inputFilter->isValid()) {
                throw new ParametersException(json_encode($this->inputFilter->getMessages()));
            }

            $user = $this->getAuthenticatedUser();

            $filters = $this->inputFilter->getValues();
            $filters['userId'] = $user->getId();

            return new TransactionsCollection(
                $this->transactionGateway->getAllPaginated(
                    $filters,
                    TransactionsPaginatorAdapter::class
                )
            );
        } catch (UserNotFoundException $exception) {
            return new ApiProblem(Response::STATUS_CODE_404, $exception->getMessage());
        } catch (ParametersException $exception) {
            return new ApiProblem(Response::STATUS_CODE_400, $exception->getMessage());
        }


    }

    public function create($data)
    {
        try {
            $user = $this->getAuthenticatedUser();

            $this->inputFilter = new TransactionsPostInputFilter();
            $this->inputFilter->setData((array)$data);

            if (!$this->inputFilter->isValid()) {
                throw new InvalidContentException(json_encode($this->inputFilter->getMessages()));
            }

            $transaction = new Transaction();

            $transaction->setAmount($data->amount);
            $transaction->setDate(new \DateTime($data->date));
            $transaction->setCategoryId($data->category);
            $transaction->setUserId($user->getId());

            $this->transactionManager->validateTransaction($user, $transaction);

            $generated = $this->transactionGateway->addTransaction($transaction);

            return [
                'message' => 'Transaction added',
                'details' => [
                    'id' => (int) $generated
                ]
            ];

        } catch (UserNotFoundException $exception) {
            return new ApiProblem(Response::STATUS_CODE_404, $exception->getMessage());
        } catch (InvalidContentException $exception) {
            return new ApiProblem(Response::STATUS_CODE_400, $exception->getMessage());
        }
        catch (BudgetExceededException $exception) {
            return new ApiProblem(Response::STATUS_CODE_402, $exception->getMessage());
        }
        catch (\Exception $exception) {
            return new ApiProblem(Response::STATUS_CODE_500, 'Internal server error');
        }
    }

    /**
     * @throws UserNotFoundException
     */
    private function getAuthenticatedUser(): User
    {
        $authIdentity = $this->getIdentity()->getAuthenticationIdentity();

        /** @var User $user */
        $user = $this->userGateway->select([
            'id' => (int)$authIdentity['user_id']
        ])->current();

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;

    }
}
