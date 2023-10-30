<?php

namespace Nikitabadin\UsersInformationService;

use Nikitabadin\UsersInformationService\Exeption\UserException;

class User
{
    const ENTITY = 'users';
    const EXCEPTION = UserException::class;

    private int $id;
    private string $name;
    private string $username;
    private string $email;
    private \stdClass $address;
    private string $phone;
    private string $website;
    private \stdClass $company;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->address = $data->address;
        $this->phone = $data->phone;
        $this->website = $data->website;
        $this->company = $data->company;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function getCompany()
    {
        return $this->id;
    }
}