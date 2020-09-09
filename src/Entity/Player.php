<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\InvalidArgumentException;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
{
    const POSITION_GOALKEEPER = 'goalkeeper';
    const POSITION_DEFENDER = 'defender';
    const POSITION_MIDFIELDER = 'midfielder';
    const POSITION_FORWARD = 'forward';

    const VALID_POSITIONS = [
        self::POSITION_GOALKEEPER,
        self::POSITION_DEFENDER,
        self::POSITION_MIDFIELDER,
        self::POSITION_FORWARD,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Team")
     * @ORM\JoinColumn(name="team", nullable=false)
     * @var Team
     */
    private $team;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @var string
     */
    private $position;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @var int
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(Team $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        if (!in_array($position, self::VALID_POSITIONS)) {
            throw new InvalidArgumentException('Esta posición no es válida');
        }

        $this->position = $position;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
}
