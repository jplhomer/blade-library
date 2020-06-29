<?php

namespace BladeLibrary;

class BladeLibraryBladeDirectives
{
    public static function chapter($expression)
    {
        return '<?php if (false) : ?>';
    }

    public static function endchapter($expression)
    {
        return '<?php endif; ?>';
    }
}
