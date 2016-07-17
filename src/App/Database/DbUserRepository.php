<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Database;

use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use User\User;
use User\UserFactory;
use User\UserRepository;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class DbUserRepository implements UserRepository, UserProviderInterface
{
    /** @var Connection */
    private $conn;
    /** @var UserFactory */
    private $factory;

    /**
     * DbUserRepository constructor.
     * @param Connection $conn
     * @param UserFactory $factory
     */
    public function __construct(Connection $conn, UserFactory $factory)
    {
        $this->conn = $conn;
        $this->factory = $factory;
    }

    public function loadUserByUsername($username): User
    {
        $sql = 'SELECT * FROM users WHERE username = ?';
        $data = $this->conn->fetchAssoc($sql, [$username]);

        if ($data) {
            return $this->factory->create($data);
        }
    }

    /**
     * @param User $user
     * @return User
     */
    public function refreshUser(UserInterface $user): User
    {
        return $this->find($user->getId());
    }

    public function supportsClass($class): bool
    {
        return is_a($class, User::class, true);
    }

    /**
     * Retorna un Objeto User consultado por su id
     * @param $id
     * @return User
     */
    public function find($id): User
    {
        $sql = 'SELECT * FROM users WHERE id = ?';
        $data = $this->conn->fetchAssoc($sql, [$id]);

        if ($data) {
            return $this->factory->create($data);
        }
    }
}