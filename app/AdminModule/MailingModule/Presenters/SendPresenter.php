<?php

declare(strict_types=1);

namespace App\AdminModule\MailingModule\Presenters;

use App\AdminModule\MailingModule\Forms\SendFormFactory;
use Nette\Application\UI\Form;
use stdClass;

/**
 * Presenter obsluhující rozesílání e-mailu vytvořeného ve formuláři.
 *
 * @author Michal Májský
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class SendPresenter extends MailingBasePresenter
{
    /** @inject */
    public SendFormFactory $sendFormFactory;

    protected function createComponentSendForm() : Form
    {
        $form = $this->sendFormFactory->create();

        $form->onSuccess[] = function (Form $form, stdClass $values) : void {
            if ($this->sendFormFactory->mailSuccess) {
                $this->flashMessage('admin.mailing.send.sent', 'success');
            } else {
                $this->flashMessage('admin.mailing.send.error', 'danger');
            }

            $this->redirect('this');
        };

        return $form;
    }
}
