<?php

namespace Warehouse;

class User
{
    private string $accessCode;

    public function __construct(string $accessCode)
    {
        $this->accessCode = $accessCode;
    }

    public function getAccessCode(): string
    {
        return $this->accessCode;
    }
}


