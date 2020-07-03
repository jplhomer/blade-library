<?php

namespace BladeLibrary;

class BladeLibraryBladeDirectives
{
    const STORY_TAG = 'story';

    public static function story()
    {
        return "<?php if (false) : ?>";
    }

    public static function endstory()
    {
        return "<?php endif; ?>";
    }
}
