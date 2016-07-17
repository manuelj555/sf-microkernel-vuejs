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
use Blog\PostRepository;
use Doctrine\DBAL\Driver\Connection;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class DbPostRepository implements PostRepository
{
    /** @var Connection */
    private $conn;

    /**
     * DbPostRepository constructor.
     * @param Connection $conn
     */
    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Post $post)
    {
        $sql = <<<SQL
INSERT INTO posts 
    (title, content, author_id, created, updated)
VALUES (?,?,?,?,?)
SQL;

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            $post->getTitle(),
            $post->getContent(),
            $post->getContent(),
            $post->getCreated()->format(\DateTime::ISO8601),
            $post->getUpdated()->format(\DateTime::ISO8601),
        ]);

        $post->setId($this->conn->lastInsertId());
    }
}