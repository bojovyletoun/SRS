<?php

declare(strict_types=1);

namespace App\Model\Settings\CustomInput;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entita vlastní pole přihlášky typu datum.
 *
 * @ORM\Entity
 * @ORM\Table(name="custom_date")
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class CustomDate extends CustomInput
{
    protected string $type = CustomInput::DATE;
}
