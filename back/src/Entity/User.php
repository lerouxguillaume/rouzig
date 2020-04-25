<?php


namespace App\Entity;

use DateTime;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class User
{
    use TimestampableEntity;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * Random string sent to the user email address in order to verify it.
     *
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    protected $confirmationToken;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    protected $passwordRequestedAt;



}