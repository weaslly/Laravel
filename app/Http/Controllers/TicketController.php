<?php

namespace App\Http\Controllers;


use Illuminate\Auth\Access\AuthorizationException;


use App\Status;
use App\Ticket;
use App\User;
use App\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Switch_;


class TicketController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(){

        $this->authorize('create', Ticket::class);

        return view('ticket.create');

    }

    public function save(Request $request){

        $this->authorize('create', Ticket::class);

        $request->validate(
            [
                'title'         => 'required|max:191',
                'description'   => 'required'
            ]
        );

        $status = Status::where('name', Status::EERSTELIJN)->first();
        $ticket = new Ticket();

        $ticket->title = $request->title;
        $ticket->description = $request->description;

        $ticket->status()->associate($status);
        $request->user()->submitted_tickets()->save($ticket);

        return redirect()->route('ticket_index')->with('success', 'Your ticket has been saved...');

    }


    public function index(){

        $this->authorize('create', Ticket::class);

        $tickets = Auth::user()->submitted_tickets()->orderBy('created_at', 'DESC')->get();

        return view('ticket.index', ['tickets' => $tickets]);

    }

    public function show($id){

        $ticket = Ticket::findOrFail($id);

        $this->authorize('show', $ticket);

        return view('ticket.show', ['ticket' => $ticket]);

    }

    public function update($id){

        //retourneren met dat ticket en de comments. Naam voor de view bijv.: ticket/show.blade.php
        //TicketController@update($id)
        //Deze method moet de status van het ticket wijzigen en vervolgens een redirect doen naar ticket_index met succesmelding.

    }

    public function index_helpdesk(){
        $this->authorize('assign', Ticket::class);

        $assigned_tickets = Auth::user()->assigned_tickets()->orderBy('created_at', 'DESC')->get();


        if (Auth::user()->role->name == Role::EERSTELIJNS_MEDEWERKER) {

            $statusName = Status::EERSTELIJN;

        } elseif (Auth::user()->role->name == Role::TWEEDELIJNS_MEDEWERKER) {

            $statusName = Status::TWEEDELIJN;
        }
        $status = Status::where('name', $statusName)->first();
        $unassigned_tickets = $status->tickets;

        return view(
                'ticket.index_helpdesk',
                [
                    'assigned_tickets' => $assigned_tickets,
                    'unassigned_tickets' => $unassigned_tickets
                ]
            );
    }

    public function close($id){
        $ticket = Ticket::findOrFail($id);

        $this->authorize('close', $ticket);

        $status = Status::where('name', Status::AFGEHANDELD)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        return redirect()->back()->with('success', __('Ticket is closed'));
    }

    public function claim($id){

        $ticket = Ticket::findOrFail($id);

        $this->authorize('claim', $ticket);

        $ticketStatus = $ticket->status->name;

        if ($ticketStatus == Status::EERSTELIJN){

            $status = Status::where('name', Status::EERSTELIJN_TOEGEWEZEN)->first();

        }elseif ($ticketStatus == Status::TWEEDELIJN){

            $status = Status::where('name', Status::TWEEDELIJN_TOEGEWEZEN)->first();

        }

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::user()->assigned_tickets()->attach($id);

        return redirect()->back()->with('success', __('Ticket has been claimed'));


    }

    public function unclaim($id)
    {

        $ticket = Ticket::findOrFail($id);

        $this->authorize('unclaim', $ticket);

        $ticketStatus = $ticket->status->name;

        if ($ticketStatus == Status::EERSTELIJN_TOEGEWEZEN){

            $status = Status::where('name', Status::EERSTELIJN)->first();

        }elseif ($ticketStatus == Status::TWEEDELIJN_TOEGEWEZEN){

            $status = Status::where('name', Status::TWEEDELIJN)->first();

        }

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::user()->assigned_tickets()->detach($id);

        return redirect()->back()->with('success', __('Your ticket has been unassigned succesfully'));
    }

    public function escalate($id){
        $ticket = Ticket::findOrFail($id);

        $this->authorize('escalate', $ticket);

        $status = Status::where('name', Status::TWEEDELIJN)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        return redirect()->back()->with('success', __('Ticket has successfully escalated'));

    }

    public function de_escalate($id){
        $ticket = Ticket::findOrFail($id);

        $this->authorize('de_escalate', $ticket);

        $status = Status::where('name', Status::EERSTELIJN_TOEGEWEZEN)->first();

        $ticket->status()->associate($status);

        $ticket->save();

        Auth::user()->assigned_tickets()->detach($id);

        return redirect()->back()->with('success', __('Ticket has successfully de_escalated'));
    }



}
