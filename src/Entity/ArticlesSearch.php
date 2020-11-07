<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class ArticlesSearch
{

    /**
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $minPublished;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMinPublished(): ?string
    {
        return $this->minPublished;
    }

    public function setMinPublished(?string $minPublished): self
    {
        $this->minPublished = $minPublished;

        return $this;
    }
}
