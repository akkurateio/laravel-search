<?php

namespace Akkurate\LaravelSearch\Observers\Documentation;

use Akkurate\LaravelDocumentation\Models\Section;

class SectionObserver
{
    /**
     * Handle the Section "created" event.
     *
     * @param  Section  $section
     * @return void
     */
    public function created(Section  $section)
    {
        //
    }

    /**
     * Handle the Section "updated" event.
     *
     * @param  Section  $section
     * @return void
     */
    public function updated(Section  $section)
    {
        //
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  Section  $section
     * @return void
     */
    public function deleted(Section  $section)
    {
        //
    }

    /**
     * Handle the Section "forceDeleted" event.
     *
     * @param  Section  $section
     * @return void
     */
    public function forceDeleted(Section  $section)
    {
        //
    }
}
