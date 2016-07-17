<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace User;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class User implements UserInterface
{
    /** @var int */
    private $id;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $name;

    /**
     * User constructor.
     * @param string $username
     * @param string $password
     * @param string $name
     */
    public function __construct($username, $password, $name)
    {
        $this->username = $username;
        $this->password = $password;
        $this->name = $name;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getSalt()
    {
        return '_';
    }

    public function getUsername()
    {
        $this->username;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
}