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

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use User\User;

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
     * @var User
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
     * @param User $author
     */
    public function __construct(User $author)
    {
        $this->author = $author;
        $this->title = '';
        $this->content = '';

        $this->created = new DateTime();
        $this->updated = new DateTime();
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
     * @return User
     */
    public function getAuthor(): User
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

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Sets the value of title.
     *
     * @param string $title the title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}