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

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @author Manuel Aguirre <programador.manuel@gmail.com>
 */
class Post
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $title;
    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    private $content;
    /**
     * @var Author
     *
     * @Assert\NotBlank()
     */
    private $author;
    /**
     * @var DateTime
     */
    private $created;
    /**
     * @var DateTime
     */
    private $updated;

    /**
     * Post constructor.
     * @param string $title
     * @param string $content
     * @param Author $author
     */
    public function __construct(string $title, string $content, Author $author)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Author
     */
    public function getAuthor(): Author
    {
        return $this->author;
    }

    /**
     * @return DateTime
     */
    public function getCreated(): DateTime
    {
        return $this->created;
    }

    /**
     * @return DateTime
     */
    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }
}