@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="card mb-3">

                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('ticket_show', ['id' => $ticket]) }}">{{ $ticket->title }}</a>
                        </h5>

                        <p class="card-text">
                            creator of ticket: {{ $ticket->submitting_user->name }}
                        </p>
                        <p class="card-text">
                            description: {!! nl2br(e($ticket->description)) !!}
                        </p>
                        <p class="card-text">
                            date of creation: {{ $ticket->created_at->toFormattedDateString() }}
                        </p>
                        <p class="card-text">
                            status: {{$ticket->status->description }}
                        </p>
                    </div>
                    <div class="card-footer">
                        @can('close', $ticket)

                            <form id="form" class="d-inline-block " action="{{ route('ticket_close', ['id' => $ticket]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    {{__('ticket_close') }}
                                </button>
                            </form>
                        @endcan
                        @can('claim', $ticket)
                            <form id="form" class="d-inline-block " action="{{ route('ticket_claim', ['id' => $ticket]) }}" method="POST">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="d-inline-block btn btn-primary">
                                    {{__('ticket_claim') }}
                                </button>
                            </form>
                        @endcan
                        @can('unclaim', $ticket)
                            <form id="form" class="d-inline-block " action="{{ route('ticket_unclaim', ['id' => $ticket]) }}" METHOD="post">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="d-inline-block btn btn-primary">
                                    {{__('ticket_unclaim')}}
                                </button>
                            </form>
                        @endcan
                        @can('escalate', $ticket)
                            <form id="form" class="d-inline-block " action="{{ route('ticket_escalate', ['id' => $ticket]) }}" METHOD="post">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="d-inline-block btn btn-primary">
                                    {{__('ticket_escalate')}}
                                </button>
                            </form>
                        @endcan
                        @can('de_escalate', $ticket)
                            <form id="form" class="d-inline-block " action="{{ route('ticket_de_escalate', ['id' => $ticket]) }}" METHOD="post">
                                @method('PUT')
                                @csrf
                                <button type="submit" class="d-inline-block btn btn-primary">
                                    {{__('ticket_de_escalate')}}
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h6 class="card-title" id="comments">
                            <b>
                                {{ __('Comments:') }}
                            </b>
                        </h6>
                    </div>

                    @forelse($ticket->comments as $comment)

                        <div class="card-body">
                            <p class="card-text">
                                <b>Created-at:</b> {{ $comment->created_at->toFormattedDateString() }}
                            </p>
                            <p class="card-text">

                                <b>Content:</b> {!! nl2br(e($comment->contents))  !!}

                            </p>
                            <p class="card-text">
                                <b>Maker of comment:</b> {{ $comment->user->name }}
                            </p>
                        </div>

                        @empty
                            <div class="card-body">
                                <p class="card-text">{{ __('No Comments on this ticket...') }}</p>
                            </div>
                        @endforelse

                @can('comment', $ticket)
                    <div class="card-footer">
                        <form id="form" method="POST" action="{{ route('comment_save', ['id' => $ticket]) }}">
                            @csrf

                            <div class="form-group row">
                                <label for="contents" class="col-md-4 col-form-label text-md-right">
                                    {{ __('New comment') }}
                                </label>
                                <div class="col-md-6">
                                    <textarea name="contents" id="contents"
                                        class="form-control @error('contents') is-invalid @enderror" cols="15" rows="5" autocomplete="contents">{{ old('contents') }}</textarea>
                                    @error('contents')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('save comment') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>


@endsection
