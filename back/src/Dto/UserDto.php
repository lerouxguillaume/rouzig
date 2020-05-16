<?php


namespace App\Dto;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\UniqueUsername;
use App\Validator\UniqueEmail;

/**
 * Class UserDto
 * @package App\Dto
 *
 * @ApiResource(
 *          denormalizationContext={AbstractObjectNormalizer::DISABLE_TYPE_ENFORCEMENT=true},
 *          shortName="User",
 *          collectionOperations={
 *              "POST" = {
 *                  "validation_groups"={"Default", "postValidation"}
 *              },
 *              "POST_ACTIVATE" = {
 *                  "method"="POST",
 *                  "path"="/users/activate",
 *              },
 *              "POST_RESET_PASSWORD" = {
 *                  "method"="POST",
 *                  "path"="/users/reset-password",
 *              },
 *              "POST_NEW_PASSWORD" = {
 *                  "method"="POST",
 *                  "path"="/users/new-password",
 *              },
 *          },
 *          itemOperations={
 *              "GET",
 *              "DELETE"
 *          },
 *      )
 * )
 */
class UserDto
{
    /**
     * @var int
     * @ApiProperty(identifier=true)
     */
    private $id;

    /**
     * @var string
     * @UniqueUsername(groups={"postValidation"})
     */
    private $username;

    /**
     * @var string
     * @UniqueEmail(groups={"postValidation"})
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return UserDto
     */
    public function setId(?int $id): UserDto
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return UserDto
     */
    public function setUsername(?string $username): UserDto
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserDto
     */
    public function setEmail(?string $email): UserDto
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserDto
     */
    public function setPassword(?string $password): UserDto
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     * @return UserDto
     */
    public function setToken(?string $token): UserDto
    {
        $this->token = $token;
        return $this;
    }
}