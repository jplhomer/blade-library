<?php

namespace BladeLibrary;

class BladeLibraryBladeDirectives
{
    const STORY_TAG = 'story';

    public static function story($expression)
    {
        return "<!-- #library-component-$expression --><?php if (false) : ?>";
    }

    public static function endstory()
    {
        return "<?php endif; ?>";
    }
}
