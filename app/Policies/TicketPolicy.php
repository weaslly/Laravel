<?php

namespace App\Policies;

use App\Status;
use App\User;
use App\Ticket;
use App\Role;



class TicketPolicy
{


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function show(User $user, Ticket $ticket)
    {

        return
            (
                $user->id == $ticket->user_id
            )
            ||
            (
                $user->role->name == Role::EERSTELIJNS_MEDEWERKER
            )
            ||
            (
                $user->role->name == Role::TWEEDELIJNS_MEDEWERKER
            );
    }


    public function create(User $user)
    {

        return $user->role->name == Role::KLANT;
    }

    public function assign(User $user)
    {
        return
            (
                $user->role->name == Role::EERSTELIJNS_MEDEWERKER
            )
            ||
            (
                $user->role->name == Role::TWEEDELIJNS_MEDEWERKER
            );

    }

    public function comment(User $user, $ticket){
        return
            (
                (
                    $user->id == $ticket->user_id
                )
                ||
                (
                    $user->assigned_tickets->contains($ticket)
                )
            )
            &&
            $ticket->isOpen();
    }


    public function close(User $user, $ticket){
        return
            (
                (
                    $user->id == $ticket->user_id
                )
                ||
                (
                    $user->assigned_tickets->contains($ticket)
                )
            )
            && $ticket->isOpen();
    }

    public function claim(User $user, $ticket){
        return
            (
                $user->role->name == Role::EERSTELIJNS_MEDEWERKER
                &&
                $ticket->status->name == Status::EERSTELIJN
            )
            ||
            (
                $user->role->name == Role::TWEEDELIJNS_MEDEWERKER
                &&
                $ticket->status->name == Status::TWEEDELIJN
            );
    }

    public function unclaim(User $user, $ticket){
        return
            $user->assigned_tickets->contains($ticket)
            &&
            (
                (
                    $user->role->name == Role::EERSTELIJNS_MEDEWERKER
                    &&
                    $ticket->status->name == Status::EERSTELIJN_TOEGEWEZEN
                )
                ||
                (
                    $user->role->name == Role::TWEEDELIJNS_MEDEWERKER
                    &&
                    $ticket->status->name == Status::TWEEDELIJN_TOEGEWEZEN
                )
            );
    }

    public function escalate(User $user, $ticket){
        return

                $user->role->name == Role::EERSTELIJNS_MEDEWERKER
                &&
                $ticket->status->name == Status::EERSTELIJN_TOEGEWEZEN;

    }

    public function de_escalate(User $user, $ticket){
        return
            $user->assigned_tickets->contains($ticket)
            &&
            $user->role->name == Role::TWEEDELIJNS_MEDEWERKER
            &&
            $ticket->status->name == Status::TWEEDELIJN_TOEGEWEZEN;
    }
}

