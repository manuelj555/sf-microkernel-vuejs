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
interface UserRepository
{
    /**
     * Retorna un Objeto User consultado por su id
     * @param $id
     * @return User
     */
    public function find($id): User;
}