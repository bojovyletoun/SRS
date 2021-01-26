<?php

declare(strict_types=1);

namespace App\Model\Program;

use DateInterval;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Nettrine\ORM\Entity\Attributes\Id;

/**
 * Entita program.
 *
 * @ORM\Entity
 * @ORM\Table(name="program")
 *
 * @author Michal Májský
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class Program
{
    use Id;

    /**
     * Programový blok.
     *
     * @ORM\ManyToOne(targetEntity="Block", inversedBy="programs", cascade={"persist"})
     */
    protected Block $block;

    /**
     * Přihlášky na program.
     *
     * @ORM\OneToMany(targetEntity="ProgramApplication", mappedBy="program", cascade={"persist"})
     *
     * @var Collection<ProgramApplication>
     */
    protected Collection $programApplications;

    /**
     * Počet účastníků.
     *
     * @ORM\Column(type="integer")
     */
    protected int $attendeesCount = 0;

    /**
     * Místnost.
     *
     * @ORM\ManyToOne(targetEntity="Room", inversedBy="programs", cascade={"persist"})
     */
    protected ?Room $room = null;

    /**
     * Začátek programu.
     *
     * @ORM\Column(type="datetime_immutable")
     */
    protected DateTimeImmutable $start;

    public function __construct(Block $block, ?Room $room, DateTimeImmutable $start)
    {
        $this->block               = $block;
        $this->room                = $room;
        $this->start               = $start;
        $this->programApplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlock(): Block
    {
        return $this->block;
    }

    public function getAttendeesCount(): int
    {
        return $this->attendeesCount;
    }

    public function setAttendeesCount(int $attendeesCount): void
    {
        $this->attendeesCount = $attendeesCount;
    }

    public function getAlternatesCount(): int
    {
        return $this->programApplications->matching(
            Criteria::create()->where(
                Criteria::expr()->eq('alternate', true)
            )
        )->count();
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): void
    {
        if ($this->room != null) {
            $this->room->removeProgram($this);
        }

        if ($room !== null) {
            $room->addProgram($this);
        }

        $this->room = $room;
    }

    public function getStart(): DateTimeImmutable
    {
        return $this->start;
    }

    public function setStart(DateTimeImmutable $start): void
    {
        $this->start = $start;
    }

    /**
     * Vrací kapacitu programového bloku.
     */
    public function getBlockCapacity(): ?int
    {
        return $this->block->getCapacity();
    }

    /**
     * Vrací konec programu vypočtený podle délky bloku.
     *
     * @throws Exception
     */
    public function getEnd(): DateTimeImmutable
    {
        return $this->start->add(new DateInterval('PT' . $this->block->getDuration() . 'M'));
    }
}
