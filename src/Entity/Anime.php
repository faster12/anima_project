<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimeRepository")
 */
class Anime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $score;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mal_id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $season;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $year;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $aired;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $episodes;

    /**
     * @ORM\Column(type="string", type="string", length=50)
     */
    private $source;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mal_members;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMalId(): ?string
    {
        return $this->mal_id;
    }

    public function setMalId(?int $mal_id): self
    {
        $this->mal_id = $mal_id;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(string $season): self
    {
        $this->season = $season;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getAired(): ?\DateTimeInterface
    {
        return $this->aired;
    }

    public function setAired(\DateTimeInterface $aired): self
    {
        $this->aired = $aired;

        return $this;
    }

    public function getEpisodes(): ?int
    {
        return $this->episodes;
    }

    public function setEpisodes(?int $episodes): self
    {
        $this->episodes = $episodes;

        return $this;
    }

    public function getSource(): ?String
    {
        return $this->source;
    }

    public function setSource(?String $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getMalMembers(): ?int
    {
        return $this->mal_members;
    }

    public function setMalMembers(?int $mal_members): self
    {
        $this->mal_members = $mal_members;

        return $this;
    }
}
