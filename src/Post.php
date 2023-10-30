<?php

namespace Nikitabadin\UsersInformationService;


use Nikitabadin\UsersInformationService\Exeption\PostException;

class Post
{
    const ENTITY = 'posts';
    const EXCEPTION = PostException::class;


    private int $id;
    private int $userId;
    private string $title;
    private bool $body;

    public function __construct($data)
    {
        $this->id = $data->id;
        $this->userId = $data->userId;
        $this->title = $data->title;
        $this->body = $data->body;
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

    public function getBody()
    {
        return $this->body;
    }
}