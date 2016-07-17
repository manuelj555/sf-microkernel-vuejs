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

use Blog\Post;
use Blog\PostFactory;
use Blog\PostRepository;
use Doctrine\DBAL\Connection;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class DbPostRepository implements PostRepository
{
    /** @var Connection */
    private $conn;
    /** @var PostFactory */
    private $factory;

    /**
     * DbPostRepository constructor.
     * @param Connection $conn
     * @param PostFactory $factory
     */
    public function __construct(Connection $conn, PostFactory $factory)
    {
        $this->conn = $conn;
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Post $post)
    {
        $id = $this->conn->insert('posts', [
            'title' => $post->getTitle(),
            'content' => $post->getContent(),
            'author_id' => $post->getAuthor()->getId(),
            'created' => $post->getCreated()->format(\DateTime::ISO8601),
            'updated' => $post->getUpdated()->format(\DateTime::ISO8601),
        ]);

        $post->setId($id);
    }

    /**
     * @return \Generator
     */
    public function findAll(): \Generator
    {
        $sql = 'SELECT * FROM posts';

        foreach ($this->conn->fetchAll($sql) as $data) {
            yield $this->factory->create($data);
        }
    }
}