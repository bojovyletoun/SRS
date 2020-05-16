<?php

declare(strict_types=1);

namespace App\Model\Mailing;

use Doctrine\ORM\Mapping as ORM;
use Nettrine\ORM\Entity\Attributes\Id;

/**
 * Entita proměnná v automatickém e-mailu.
 *
 * @ORM\Entity
 * @ORM\Table(name="mail_template_variable")
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class TemplateVariable
{
    /**
     * Název semináře.
     */
    public const SEMINAR_NAME = 'seminar_name';

    /**
     * Role uživatele.
     */
    public const USERS_ROLES = 'users_roles';

    /**
     * Podakce uživatele.
     */
    public const USERS_SUBEVENTS = 'users_subevents';

    /**
     * Název programu.
     */
    public const PROGRAM_NAME = 'program_name';

    /**
     * Podakce přihlášky.
     */
    public const APPLICATION_SUBEVENTS = 'application_subevents';

    /**
     * Splatnost přihlášky.
     */
    public const APPLICATION_MATURITY = 'application_maturity';

    /**
     * Poplatek přihlášky.
     */
    public const APPLICATION_FEE = 'application_fee';

    /**
     * Variabilní symbol přihlášky.
     */
    public const APPLICATION_VARIABLE_SYMBOL = 'application_variable_symbol';

    /**
     * Odhlášení ze semináře a změna rolí povolena do.
     */
    public const EDIT_REGISTRATION_TO = 'edit_registration_to';

    /**
     * Bankovní účet pro platbu.
     */
    public const BANK_ACCOUNT = 'bank_account';

    /**
     * Odkaz pro potvrzení změny e-mailu.
     */
    public const EMAIL_VERIFICATION_LINK = 'email_verification_link';

    /**
     * Jméno uživatele.
     */
    public const USER = 'user';
    use Id;

    /**
     * Název proměnné.
     *
     * @ORM\Column(type="string")
     */
    protected string $name;

    public function getId() : int
    {
        return $this->id;
    }

    public function getName() : string
    {
        return $this->name;
    }
}
