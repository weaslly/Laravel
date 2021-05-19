<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function save(Request $request, $ticket_id)
    {

        $ticket = Ticket::findOrFail($ticket_id);

        $this->authorize('comment', $ticket);

        $validator = Validator::make(
            $request->all(),
            [
                'contents' => 'required'
            ]
        );
        if ($validator->fails()) {

            return redirect()
                ->route('ticket_show', ['id' => $ticket, '#form'])
                ->withErrors($validator)
                ->withInput();
        }

        $comment = new Comment();
        $comment->contents = $request->contents;
        $comment->ticket()->associate($ticket);
        $request->user()->comments()->save($comment);


        return redirect()
            ->route('ticket_show', ['id' => $ticket, '#comments'])
            ->with('success', __('Your comment has been saved'));
    }

}
