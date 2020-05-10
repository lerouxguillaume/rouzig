<?php


namespace App\Dto;


class UserOutput
{
    /** @var string */
    private $username;

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): UserOutput
    {
        $this->username = $username;
        return $this;
    }
}