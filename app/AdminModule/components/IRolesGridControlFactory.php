<?php

namespace App\AdminModule\Components;


/**
 * Rozhraní komponenty pro správu rolí.
 *
 * @author Jan Staněk <jan.stanek@skaut.cz>
 */
interface IRolesGridControlFactory
{
    /**
     * Vytvoří komponentu.
     * @return RolesGridControl
     */
    function create();
}