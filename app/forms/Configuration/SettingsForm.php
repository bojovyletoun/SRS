<?php
/**
 * Date: 1.12.12
 * Time: 18:58
 * Author: Michal Májský
 */


namespace SRS\Form\Configuration;

use Nette\Application\UI,
    Nette\Application\UI\Form,
    Nette\ComponentModel\IContainer;

/**
 * formular pro konfiguraci
 */
class SettingsForm extends UI\Form
{

    protected $dbsettings;

    public function __construct(IContainer $parent = NULL, $name = NULL, $dbsettings, $configParameters)
    {
        parent::__construct($parent, $name);
        $this->dbsettings = $dbsettings;


        $basicBlockDurationChoices = array('5' => '5 minut', '10' => '10 minut', '15' => '15 minut', '30' => '30 minut', '45' => '45 minut', '60' => '60 minut', '75' => '75 minut', '90' => '90 minut', '105' => '105 minut', '120' => '120 minut');

        $this->addText('seminar_name', 'Jméno semináře')->setDefaultValue($this->dbsettings->get('seminar_name'))
            ->addRule(Form::FILLED, 'Zadejte Jméno semináře');

        $this->addText('seminar_from_date', 'Začátek semináře')->setDefaultValue($this->dbsettings->get('seminar_from_date'))
            ->addRule(Form::PATTERN, 'Datum začátku semináře není ve správném tvaru', \SRS\Helpers::DATE_PATTERN)
            ->addRule(Form::FILLED, 'Zadejte začátek semináře')->getControlPrototype()->class('datepicker');

        $this->addText('seminar_to_date', 'Konec semináře')->setDefaultValue($this->dbsettings->get('seminar_to_date'))
            ->addRule(Form::PATTERN, 'Datum konce semináře není ve správném tvaru', \SRS\Helpers::DATE_PATTERN)
            ->addRule(Form::FILLED, 'Zadejte konec semináře')->getControlPrototype()->class('datepicker');

        $this->addText('cancel_registration_to_date', 'Odhlašování povoleno do')->setDefaultValue($this->dbsettings->get('cancel_registration_to_date'))
            ->addRule(Form::PATTERN, 'Datum, do kdy je možné se ze semináře odhlásit, není ve správném tvaru', \SRS\Helpers::DATE_PATTERN)
            ->addRule(Form::FILLED, 'Zadejte datum, do kdy je možné se ze semináře odhlásit')->getControlPrototype()->class('datepicker');

        $this->addText('seminar_email', 'Email pro mailing')->setDefaultValue($this->dbsettings->get('seminar_email'))
            ->addRule(Form::FILLED, 'Zadejte Email pro mailing')
            ->addRule(Form::EMAIL, 'Email není ve správném tvaru');

        $this->addText('variable_symbol_code', 'Předvolba variabilního symbolu (neovlivní již vygenerované)', 2)->setDefaultValue($this->dbsettings->get('variable_symbol_code'))
            ->addRule(Form::FILLED, 'Zadejte předvolbu variabilního symbolu')
            ->addRule(Form::INTEGER, 'Zadejte 2 číslice')
            ->addRule(Form::COUNT, 'Zadejte 2 číslice', 2);

        $this->addSubmit('submit_seminar', 'Uložit')->getControlPrototype()->class('btn btn-primary pull-right');


        $this->addSelect('basic_block_duration', 'Základní délka trvání programového bloku semináře')
            ->setItems($basicBlockDurationChoices)->setDefaultValue($this->dbsettings->get('basic_block_duration'));

        $this->addCheckbox('is_allowed_add_block', 'Je povoleno vytvářet programové bloky?')
            ->setDefaultValue($this->dbsettings->get('is_allowed_add_block'));

        $this->addCheckbox('is_allowed_modify_schedule', 'Je povoleno upravovat harmonogram semináře?')
            ->setDefaultValue($this->dbsettings->get('is_allowed_modify_schedule'));

        $this->addCheckbox('is_allowed_log_in_programs', 'Je povoleno přihlašovat se na programové bloky?')
            ->setDefaultValue($this->dbsettings->get('is_allowed_log_in_programs'));

        $this->addText('log_in_programs_from', 'Přihlašování programů otevřeno od')->setDefaultValue($this->dbsettings->get('log_in_programs_from'))
            ->addRule(FORM::PATTERN, 'Datum a čas, od kdy je možné se přihlašovat na programy, není ve správném tvaru', \SRS\Helpers::DATETIME_PATTERN)
            ->addRule(Form::FILLED, 'Zadejte datum a čas, od kdy je možné se přihlašovat na programy')->getControlPrototype()->class('datetimepicker');

        $this->addText('log_in_programs_to', 'Přihlašování programů otevřeno do')->setDefaultValue($this->dbsettings->get('log_in_programs_to'))
            ->addRule(FORM::PATTERN, 'Datum a čas, do kdy je možné se přihlašovat na programy, není ve správném tvaru', \SRS\Helpers::DATETIME_PATTERN)
            ->addRule(Form::FILLED, 'Zadejte datum a čas, do kdy je možné se přihlašovat na programy')->getControlPrototype()->class('datetimepicker');

        $this->addSubmit('submit_program', 'Uložit')->getControlPrototype()->class('btn btn-primary pull-right');


        $this->addTextArea('company', 'Firma')->setDefaultValue($this->dbsettings->get('company'));
        $this->addText('ico', 'IČO')->setDefaultValue($this->dbsettings->get('ico'));
        $this->addText('accountant', 'Pokladník')->setDefaultValue($this->dbsettings->get('accountant'));
        $this->addText('account_number', 'Číslo účtu')->setDefaultValue($this->dbsettings->get('account_number'));
        $this->addText('print_location', 'Lokalita')->setDefaultValue($this->dbsettings->get('print_location'));
        $this->addSubmit('submit_print', 'Uložit')->getControlPrototype()->class('btn btn-primary pull-right');


        $CUSTOM_BOOLEAN_COUNT = $configParameters['user_custom_boolean_count'];
        for ($i = 0; $i < $CUSTOM_BOOLEAN_COUNT; $i++) {
            $column = 'user_custom_boolean_' . $i;
            $this->addText($column, 'Vlastní checkbox pro přihlášku č.' . $i)->setDefaultValue($this->dbsettings->get($column));
        }

        $CUSTOM_TEXT_COUNT = $configParameters['user_custom_text_count'];
        for ($i = 0; $i < $CUSTOM_TEXT_COUNT; $i++) {
            $column = 'user_custom_text_' . $i;
            $this->addText($column, 'Vlastní textové pole pro přihlášku č.' . $i)->setDefaultValue($this->dbsettings->get($column));
        }

        $this->addSubmit('submit', 'Uložit')->getControlPrototype()->class('btn btn-primary pull-right');
        $this->onSuccess[] = callback($this, 'formSubmitted');
    }

    public function formSubmitted()
    {
        $values = $this->getValues();

        if (\DateTime::createFromFormat("d.m.Y", $values['seminar_to_date']) < \DateTime::createFromFormat("d.m.Y", $values['seminar_from_date'])) {
            $this->presenter->flashMessage('Datum konce semináře nemůže být menší než začátku', 'error');
        }
        else if (\DateTime::createFromFormat("d.m.Y", $values['seminar_from_date']) < \DateTime::createFromFormat("d.m.Y", $values['cancel_registration_to_date'])) {
            $this->presenter->flashMessage('Datum konce odhlašování nemůže být větší než začátku', 'error');
        }
        else if (\DateTime::createFromFormat("d.m.Y H:i", $values['log_in_programs_to']) < \DateTime::createFromFormat("d.m.Y H:i", $values['log_in_programs_from'])) {
            $this->presenter->flashMessage('Datum a čas konce přihlašování na programové bloky musí být větší než začátku přihlašování', 'error');
        }
        else {
            foreach ($values as $key => $value) {
                $this->dbsettings->set($key, $value);
            }
            $this->presenter->flashMessage('Konfigurace uložena', 'success');
            $this->presenter->redirect('this');
        }

    }

}