<?php

namespace Identity;

use Laminas\ApiTools\MvcAuth\Identity\IdentityInterface;
use Laminas\Permissions\Rbac\Role as AbstractRbacRole;

final class UserIdentity extends AbstractRbacRole implements IdentityInterface
{

    private $user;

    /**
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }


    public function getAuthenticationIdentity()
    {
        return $this->user;
    }

    public function getRoleId()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

}