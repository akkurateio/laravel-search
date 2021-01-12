<?php

namespace Akkurate\LaravelSearch\Observers\Helpdesk;

use Akkurate\LaravelHelpdesk\Models\Ticket;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function created(Ticket  $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function updated(Ticket  $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket  $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "forceDeleted" event.
     *
     * @param  Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket  $ticket)
    {
        //
    }
}
