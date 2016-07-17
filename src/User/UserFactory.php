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

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class UserFactory
{
    public function create($data): User
    {
        $user = new User($data['username'], $data['password'], $data['name']);
        $user->setId($data['id']);

        return $user;
    }
}