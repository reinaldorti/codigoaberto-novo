<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;
use Exception;

/**
 * Class User
 * @package Source\Models
 */
class User extends DataLayer
{
    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct("users", ["first_name", "last_name", "email", "password", "status"]);
    }

    /**
     * @return string
     */
    public function fullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        if (
            !$this->validateEmail()
            || !$this->validatePassword()
            || !$this->validateCpf()
            || !parent::save()
        ) {
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validateEmail(): bool
    {
        if (!is_email($this->email)) {
            $this->fail = new Exception("<i class='icon fas fa-ban'></i> Oops! O e-email informado não parece ter um formato válido!");
            return false;
        }

        $userByEmail = null;
        if (!$this->id) {
            $userByEmail = $this->find("email = :email", "email={$this->email}")->count();
        } else {
            $userByEmail = $this->find("email = :email AND id != :id", "email={$this->email}&id={$this->id}")->count();
        }

        if ($userByEmail) {
            $this->fail = new Exception("<i class='icon fas fa-ban'></i> Oops! O e-mail informado já está em uso");
            return false;
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function validatePassword(): bool
    {
        if (!is_passwd($this->password)){
            $this->fail = new Exception("<i class='icon fas fa-ban'></i> Oops! Sua senha deve ter entre " . CONF_PASSWD['MIN'] . " e " . CONF_PASSWD['MAX'] . " caracteres!");
            return false;
        }

        $this->password = passwd($this->password);
        return true;
    }

    /**
     * @return bool
     */
    protected function validateCpf(): bool
    {
        if (!is_cpf($this->document)) {
            $this->fail = new Exception("<i class='icon fas fa-ban'></i> Oops! O CPF informado não é válido!");
            return false;
        }

        $this->password = passwd($this->password);
        return true;
    }

    /**
     * @return null|User
     */
    public static function user(): ?User
    {
        if (!empty($_SESSION["user"])) {
            return (new User())->find("id = :id","id={$_SESSION["user"]}")->fetch();
        }
    }

    /**
     * @return null|Address
     */
    public function addr(): ?Address
    {
        if ($this->id) {
            return (new Address())->find("user_id = :id", "id={$this->id}")->fetch();
        }
        return null;
    }

    /**
     * @return null|Post
     */
    public function posts(): ?Post
    {
        if ($this->id) {
            return (new Post())->find("user_id = :id", "id={$this->id}")->fetch();
        }
        return null;
    }
}