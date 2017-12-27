<?php

namespace App\Model\User;

use App\Model\Enums\ApplicationState;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Kdyby\Doctrine\EntityRepository;


/**
 * Třída spravující přihlášky.
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
class ApplicationRepository extends EntityRepository
{
    /**
     * Vrací přihlášku podle id.
     * @param $id
     * @return Application|null
     */
    public function findById($id)
    {
        return $this->findOneBy(['id' => $id]);
    }

    /**
     * Uloží přihlášku.
     * @param Application $application
     */
    public function save(Application $application)
    {
        $this->_em->persist($application);
        $this->_em->flush();
    }

    /**
     * Odstraní přihlášku.
     * @param Application $application
     */
    public function remove(Application $application)
    {
        $this->_em->remove($application);
        $this->_em->flush();
    }
}
