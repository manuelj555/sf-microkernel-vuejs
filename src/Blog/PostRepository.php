<?php
/*
 * This file is part of the Manuel Aguirre Project.
 *
 * (c) Manuel Aguirre <programador.manuel@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Blog;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
interface PostRepository
{
    /**
     * Agrega un post al repositorio
     *
     * @param Post $post
     */
    public function add(Post $post);

    /** 
     * Edita un post en el repositorio
     *
     * @param Post $post
     */
    public function update(Post $post);

    /**
     * @param int $id
     * @return Post
     */
    public function find($id);

    /**
     * @param int $limit
     * @param int $offset
     * @return Post[]
     */
    public function findAll(int $limit = null,int $offset = null);

    public function countAll() : int;
}