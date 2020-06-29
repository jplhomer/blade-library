<?php

namespace Woodblock;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Woodblock\Woodblock
 */
class WoodblockFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'woodblock';
    }
}
