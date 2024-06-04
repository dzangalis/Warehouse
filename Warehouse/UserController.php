<?php

namespace Warehouse;

use Warehouse\User;

class UserController
{
    private array $users = [];
    private string $usersFile = 'users.json';

    public function __construct()
    {
        $this->loadUsers();
    }

    private function loadUsers(): void
    {
        $userData = file_get_contents($this->usersFile);
        $this->users = json_decode($userData, true)['users'];
    }

    private function saveUsers(): void
    {
        $data = ['users' => $this->users];
        file_put_contents($this->usersFile, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function addUser(int $accessCode): void
    {
        $this->users[] = ['access_code' => $accessCode];
        $this->saveUsers();
    }

    public function validateUser(string $accessCode): bool
    {
        foreach ($this->users as $user) {
            if ($user['access_code'] === $accessCode) {
                return true;
            }
        }
        return false;
    }
}