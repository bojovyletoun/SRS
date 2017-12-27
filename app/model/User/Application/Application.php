<?php

namespace App\Model\User;

use App\Model\Enums\ApplicationState;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Kdyby\Doctrine\Entities\Attributes\Identifier;


/**
 * Abstraktní entita přihláška.
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 * @ORM\Entity(repositoryClass="ApplicationRepository")
 * @ORM\Table(name="application")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "roles_application" = "RolesApplication",
 *     "subevents_application" = "SubeventsApplication"
 * })
 */
abstract class Application
{
    /**
     * Přihláška rolí.
     */
    const ROLES = "roles";

    /**
     * Přihláška na podakce.
     */
    const SUBEVENTS = "subevents";

    /**
     * Typ přihlášky.
     */
    protected $type;

    use Identifier;

    /**
     * Id přihlášky.
     * @ORM\Column(type="integer", nullable=true)
     * @var int
     */
    protected $applicationId;

    /**
     * Uživatel.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="applications", cascade={"persist"})
     * @var User
     */
    protected $user;

    /**
     * Poplatek.
     * @ORM\Column(type="integer")
     * @var int
     */
    protected $fee;

    /**
     * Variabilní symbol.
     * @ORM\ManyToOne(targetEntity="VariableSymbol", cascade={"persist"})
     * @var VariableSymbol
     */
    protected $variableSymbol;

    /**
     * Datum podání přihlášky.
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $applicationDate;

    /**
     * Datum splatnosti.
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $maturityDate;

    /**
     * Platební metoda.
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    protected $paymentMethod;

    /**
     * Datum zaplacení.
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $paymentDate;

    /**
     * Datum vytištění dokladu o zaplacení.
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     */
    protected $incomeProofPrintedDate;

    /**
     * Stav přihlášky.
     * @ORM\Column(type="string")
     * @var string
     */
    protected $state;

    /**
     * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
     * @var User
     */
    protected $createdBy;

    /**
     * Platnost záznamu od.
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $validFrom;

    /**
     * Platnost záznamu do.
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $validTo;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getApplicationId(): int
    {
        return $this->applicationId;
    }

    /**
     * @param int $applicationId
     */
    public function setApplicationId(int $applicationId): void
    {
        $this->applicationId = $applicationId;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getRoles(): Collection
    {
        return new ArrayCollection();
    }

    public function getRolesText(): ?string
    {
        return NULL;
    }

    public function getSubevents(): Collection
    {
        return new ArrayCollection();
    }

    public function getSubeventsText(): ?string
    {
        return NULL;
    }

    /**
     * @return int
     */
    public function getFee()
    {
        return $this->fee;
    }

    /**
     * Vrací poplatek slovy.
     * @return mixed|string
     */
    public function getFeeWords()
    {
        $numbersWords = new \Numbers_Words();
        $feeWord = $numbersWords->toWords($this->getFee(), 'cs');
        $feeWord = iconv('windows-1250', 'UTF-8', $feeWord);
        $feeWord = str_replace(" ", "", $feeWord);
        return $feeWord;
    }

    /**
     * @param int $fee
     */
    public function setFee($fee)
    {
        $this->fee = $fee;
    }

    /**
     * @return VariableSymbol
     */
    public function getVariableSymbol(): VariableSymbol
    {
        return $this->variableSymbol;
    }

    /**
     * Vrací text variabilního symbolu.
     * @return string
     */
    public function getVariableSymbolText(): string
    {
        return $this->variableSymbol->getVariableSymbol();
    }

    /**
     * @param VariableSymbol $variableSymbol
     */
    public function setVariableSymbol(VariableSymbol $variableSymbol)
    {
        $this->variableSymbol = $variableSymbol;
    }

    /**
     * @return \DateTime
     */
    public function getApplicationDate()
    {
        return $this->applicationDate;
    }

    /**
     * @param \DateTime $applicationDate
     */
    public function setApplicationDate($applicationDate)
    {
        $this->applicationDate = $applicationDate;
    }

    /**
     * @return \DateTime
     */
    public function getMaturityDate()
    {
        return $this->maturityDate;
    }

    /**
     * Vrací datum splastnosti jako text.
     * @return string|null
     */
    public function getMaturityDateText(): ?string
    {
        return $this->maturityDate !== NULL ? $this->maturityDate->format('j. n. Y') : NULL;
    }

    /**
     * @param \DateTime $maturityDate
     */
    public function setMaturityDate($maturityDate)
    {
        $this->maturityDate = $maturityDate;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @param string $paymentMethod
     */
    public function setPaymentMethod($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @return \DateTime
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param \DateTime $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return \DateTime
     */
    public function getIncomeProofPrintedDate()
    {
        return $this->incomeProofPrintedDate;
    }

    /**
     * @param \DateTime $incomeProofPrintedDate
     */
    public function setIncomeProofPrintedDate($incomeProofPrintedDate)
    {
        $this->incomeProofPrintedDate = $incomeProofPrintedDate;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return User
     */
    public function getCreatedBy(): User
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy(User $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return \DateTime
     */
    public function getValidFrom(): \DateTime
    {
        return $this->validFrom;
    }

    /**
     * @param \DateTime $validFrom
     */
    public function setValidFrom(\DateTime $validFrom)
    {
        $this->validFrom = $validFrom;
    }

    /**
     * @return \DateTime
     */
    public function getValidTo(): ?\DateTime
    {
        return $this->validTo;
    }

    /**
     * @param \DateTime $validTo
     */
    public function setValidTo(?\DateTime $validTo)
    {
        $this->validTo = $validTo;
    }

    /**
     * @return bool
     */
    public function isCanceled(): bool
    {
        return $this->state == ApplicationState::CANCELED || $this->state == ApplicationState::CANCELED_NOT_PAID;
    }
}
