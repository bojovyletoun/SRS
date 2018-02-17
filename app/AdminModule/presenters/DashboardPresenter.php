<?php

namespace App\AdminModule\Presenters;

use App\Model\Structure\SubeventRepository;


/**
 * Presenter obsluhující úvodní stránku.
 *
 * @author Michal Májský
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class DashboardPresenter extends AdminBasePresenter
{
    /**
     * @var SubeventRepository
     * @inject
     */
    public $subeventRepository;


    /**
     * @throws \App\Model\Settings\SettingsException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function beforeRender()
    {
        parent::beforeRender();

        $this->template->explicitSubeventsExists = $this->subeventRepository->explicitSubeventsExists();
    }
}
