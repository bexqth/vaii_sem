<?php

namespace App\Models;

use App\Core\Model;

class Rolepermission extends Model
{
    protected $id;
    protected $role_id;
    protected $permission_id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getPermissionId()
    {
        return $this->permission_id;
    }

    /**
     * @param mixed $permission_id
     */
    public function setPermissionId($permission_id): void
    {
        $this->permission_id = $permission_id;
    }


}