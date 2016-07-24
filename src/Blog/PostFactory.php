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

use User\UserRepository;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class PostFactory
{
    /** @var UserRepository */
    private $userRepository;

    /**
     * PostFactory constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create($data):Post
    {
        $author = $this->userRepository->find($data['author_id']);
        
        $post = new Post($author);
        $post->setId($data['id']);
        $post->setTitle($data['title']);
        $post->setContent($data['content']);

        return $post;
    }
}