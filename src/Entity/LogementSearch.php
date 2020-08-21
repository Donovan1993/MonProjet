<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class LogementSearch
{
    /**
     * @var int|null
     * @Assert\Range(min=1000, max=4000)
     */
    private $MaxPrice;

    /**
     * @var int|null 
     * @Assert\Range(min=20, max=400)
     */
    private $minSurface;

    /**
     * @return int|null 
     */
    public function getMinSurface(): ?int
    {
        return $this->minSurface;
    }

    /**
     * @return int|null 
     */
    public function getMaxPrice(): ?int
    {
        return $this->MaxPrice;
    }


    /**
     * @var int|null $MaxPrice
     * @return LogementSearch
     */
    public function setMaxPrice(int $MaxPrice): LogementSearch
    {
        $this->MaxPrice = $MaxPrice;
        return $this;
    }


    /**
     * @param int|null $minSurface
     * @return LogementSearch
     */
    public function setMinSurface(int $minSurface): LogementSearch
    {
        $this->minSurface = $minSurface;
        return $this;
    }
}
