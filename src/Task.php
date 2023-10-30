<?php

namespace Nikitabadin\UsersInformationService;

use Nikitabadin\UsersInformationService\Exeption\TaskException;

class Task
{
    const ENTITY = 'todos';
    const EXCEPTION = TaskException::class;

    private int $id;
    private int $userId;
    private string $title;
    private bool $completed;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->userId = $data->userId;
        $this->title = $data->title;
        $this->completed = $data->completed;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getCompleted()
    {
        return $this->completed;
    }
}