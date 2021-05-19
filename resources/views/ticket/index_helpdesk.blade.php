@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1>Assigned Tickets</h1>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse($assigned_tickets as $ticket)


                    <div class="card mb-3">
                        <div class="card-header">
                            {{ $ticket->submitting_user->name }}
                            <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">
                                @can('show', $ticket)
                                    <a href="{{ route('ticket_show', ['id' => $ticket]) }}">{{ $ticket->title }}</a>
                                @elsecan
                                    {{ $ticket->title }}
                                @endcan
                            </h5>
                            <p class="card-text">
                                {!! nl2br(e($ticket->description)) !!}
                            </p>
                        </div>
                        <div class="card-footer">
                            {{$ticket->status->description }}
                        </div>
                    </div>
                @empty
                    {{__('No assigned tickets available...') }}
                @endforelse
            </div>
            <div class="col-md-6">
                <h1>Unassigned tickets</h1>
                @forelse($unassigned_tickets as $ticket)

                    <div class="card mb-3">

                        <div class="card-header">
                            {{ $ticket->submitting_user->name }}
                            <em>{{ $ticket->created_at->toFormattedDateString() }}</em>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">
                                @can('show', $ticket)
                                    <a href="{{ route('ticket_show', ['id' => $ticket]) }}">{{ $ticket->title }}</a>
                                @elsecan
                                    {{ $ticket->title }}
                                @endcan
                            </h5>
                            <p class="card-text">
                                {!! nl2br(e($ticket->description)) !!}
                            </p>
                        </div>

                        <div class="card-footer">
                            {{$ticket->status->description }}
                        </div>
                    </div>
                @empty
                    {{ __('No unassigned tickets available...') }}
                @endforelse
            </div>
        </div>
    </div>

@endsection
