<?php

namespace BladeLibrary;

class BladeLibrary
{
    public function storyFrame($story)
    {
        return sprintf(
            '<x-library-story-frame name="%s"><iframe src="/library/%s/%s" frameborder="0"></iframe></x-library-story-frame>',
            $story['name'],
            $story['chapter'],
            $story['alias']
        );
    }
}
