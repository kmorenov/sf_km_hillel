<?php
// src/Entity/User.php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Paladin\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author")
     */
    private $authorArticles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="author")
     */
    private $comments;

    public function __construct()
    {
        parent::__construct();
        $this->authorArticles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        // your own logic
    }

    /**
     * @return Collection|Article[]
     */
    public function getAuthorArticles(): Collection
    {
        return $this->authorArticles;
    }

    public function addAuthorArticle(Article $authorArticle): self
    {
        if (!$this->authorArticles->contains($authorArticle)) {
            $this->authorArticles[] = $authorArticle;
            $authorArticle->setAuthor($this);
        }

        return $this;
    }

    public function removeAuthorArticle(Article $authorArticle): self
    {
        if ($this->authorArticles->contains($authorArticle)) {
            $this->authorArticles->removeElement($authorArticle);
            // set the owning side to null (unless already changed)
            if ($authorArticle->getAuthor() === $this) {
                $authorArticle->setAuthor(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getUsername() ? $this->getUsername() : 'New';
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }
}