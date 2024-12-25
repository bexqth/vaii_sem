<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected int $id;
    protected ?string $username;
    protected ?string $password;
    protected ?string $email;
    protected ?int $role_id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function setRoleId(?int $role_id): void
    {
        $this->role_id = $role_id;
    }

    public function getRole () {
        $role = Role::getOne($this->role_id);
        return $role;
    }

    public function hasPermission($name): bool {
        $permissions = Permission::getAll("name = ? ", [$name]);
        $permission = $permissions[0];
        $rolePermission = Rolepermission::getAll("role_id = ? AND permission_id = ?", [$this->role_id, $permission->getId()]);
        if ($rolePermission != null) {
            return true;
        }
        return false;
    }

    public function isAdmin(): bool {
        return $this->role_id === 2;
    }

    public function isUser(): bool {
        return $this->role_id === 1;
    }

}