<?php

namespace BladeLibrary;

use Illuminate\Support\Facades\Facade;

/**
 * @see \BladeLibrary\BladeLibrary
 */
class BladeLibraryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'blade-library';
    }
}
