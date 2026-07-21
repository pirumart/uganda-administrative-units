<?php

namespace Pirumart\Uganda\Locale;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Pirumart\Uganda\Locale\AdministrativeUnits
 */
class AdministrativeUnitsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'administrative-units';
    }
}
