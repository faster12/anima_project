<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnimaProgramRepository")
 */
class AnimaProgram
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $program_id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $program_name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramId(): ?int
    {
        return $this->program_id;
    }

    public function setProgramId(int $program_id): self
    {
        $this->program_id = $program_id;

        return $this;
    }

    public function getProgramName(): ?string
    {
        return $this->program_name;
    }

    public function setProgramName(string $program_name): self
    {
        $this->program_name = $program_name;

        return $this;
    }
}
