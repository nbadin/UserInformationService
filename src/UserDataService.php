<?php

namespace Nikitabadin\UsersInformationService;

use Nikitabadin\UsersInformationService\Exeption\TaskException;
use Psr\Http\Message\RequestInterface;

class UserDataService
{

    const CREATE= 'POST';
    const UPDATE= 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';

    private $client;
    private $basiuri;

    public function __construct($client, $basiuri)
    {
        $this->client = $client;
        $this->basiuri = $basiuri;
    }

    private function getResponce($entity, $params = [])
    {
        try {
            $filterParams = array_map(function ($key, $value) {
                return "{$key}={$value}";
            }, array_keys($params), $params);
            $filter = empty($filterParams) ? '' : '?' . implode('&', $filterParams);
            $entityName = $entity::ENTITY;
            $response = $this->client->get("{$this->basiuri}{$entityName}{$filter}");
            $data = json_decode($response->getBody());

            return array_map(function ($entityData) use ($entity) {
                return new $entity($entityData);
            }, $data);
        } catch (\Exception $e) {
            $exceptionClass = $entity::EXCEPTION;

            throw new $exceptionClass($e);
        }
    }

    private function sendRequest($entity, $method, $data = [], $id = null)
    {
        try {
            if (!empty($data)) {
                $params = [
                    'json' => $data,
                    'headers' => [
                        'Content-Type' => 'application/json; charset=UTF-8',
                    ]
                ];
            } else {
                $params = [];
            }

            $id = $id ?  "/{$id}" : '' ;

            $entityName = $entity::ENTITY;
            $response = $this->client->request(
                $method,
                "{$this->basiuri}{$entityName}{$id}",
                $params
            );
            $code = $response->getStatusCode();

            return 199 < $code && $code < 300;
        } catch (\Exception $e) {
            $exceptionClass = $entity::EXCEPTION;

            throw new $exceptionClass($e);
        }
    }

    public function getTasks()
    {
        return $this->getResponce(Task::class);
    }

    public function getUserTasks($userId)
    {
        return $this->getResponce(Task::class, ['userId' => $userId]);
    }

    public function getTaskById($id)
    {
        return $this->getResponce(Task::class, ['id' => $id]);
    }

    public function getUsers()
    {
        return $this->getResponce(User::class);
    }

    public function getUserById($id)
    {
        return $this->getResponce(User::class, ['id' => $id]);
    }

    public function getPosts()
    {
        return $this->getResponce(Post::class);
    }

    public function getPostById($id)
    {
        return $this->getResponce(Post::class, ['id' => $id]);
    }

    public function getPostsByUserId($userid)
    {
        return $this->getResponce(Post::class, ['userId' => $userid]);
    }

    public function createPost($userId, $title, $body)
    {
        $postData = [
            'userId' => $userId,
            'title' => $title,
            'body' => $body
        ];

        return $this->sendRequest(Post::class, static::CREATE,  $postData);
    }

    public function updatePost($postId, int $userId = null, string $title=null, string $body=null)
    {
        $method = ($userId && $title && $body) ? static::UPDATE : static::PATCH;

        switch (true) {
            case $userId:
                $postData['userId'] = $userId;
            case $title:
                $postData['title'] = $title;
            case $body:
                $postData['body'] = $body;
        }

        return $this->sendRequest(Post::class, $method, $postData, $postId);
    }

    public function deletePost($postid)
    {
        return $this->sendRequest(Post::class, static::DELETE, [], $postid);
    }
}
