@extends('home.layout')

@section('home-title')
    Message (#{{ $mail->id }})
@endsection

@section('home-content')

    {!! breadcrumbs(['Mail' => 'mail', ($mail->recipient_id == Auth::user()->id ? '(Inbox) ' : '(Outbox) ') . $mail->displayName . ' from ' . $mail->sender->displayName => $mail->viewUrl]) !!}

    <div class="card mb-3">
        <div class="card-header">
            <h3>{!! $mail->displayName !!}</h3>
        </div>
        <div class="card-body">
            @if ($mail->parent)
                @php
                    // Get all ancestors in reverse order (oldest first)
                    $parents = [];
                    $parent = $mail->parent;
                    while ($parent) {
                        array_unshift($parents, $parent);
                        $parent = $parent->parent;
                    }
                @endphp

                @foreach ($parents as $index => $parent)
                    <div class="card">
                        <div class="card-header" data-toggle="collapse" data-target="#message-{{ $index }}" aria-expanded="false" aria-controls="message-{{ $index }}">
                            <h5>"{{ $parent->subject }}" Message from {!! pretty_date($parent->created_at) !!} - {!! $parent->sender->displayName !!}</h5>
                        </div>
                        <div id="message-{{ $index }}" class="collapse">
                            <div class="card-body">
                                {!! $parent->message !!}
                                <div class="text-right">
                                    <a href="{{ $parent->viewUrl }}"><u>View Message</u></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            <div class="card my-2">
                <div class="card-body">
                    <h5>"{{ $mail->subject }}" Sent {!! pretty_date($mail->created_at) !!} - {!! $mail->sender->displayName !!}</h5>
                    {!! $mail->message !!}
                </div>
            </div>

            @if ($mail->children->count() > 0)
                @php $child = $mail->children->first(); @endphp
                <div class="card my-2">
                    <div class="card-header" type="button" data-toggle="collapse" data-target="#child-message" aria-expanded="false" aria-controls="child-message">
                        <h5>"{{ $child->subject }}" Reply from {!! pretty_date($child->created_at) !!} - {!! $child->sender->displayName !!}</h5>
                    </div>
                    <div id="child-message" class="collapse">
                        <div class="card-body">
                            {!! $child->message !!}

                            <div class="text-right">
                                <a href="{{ $child->viewUrl }}"><u>...View Reply</u></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

    @if (Auth::user()->id != $mail->sender_id)
        {!! Form::open(['url' => 'mail/new/' . $mail->id]) !!}

        <div class="card">
            <div class="card-header">
                <h3>Reply</h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    @if ($mail->children->count() > 0)
                        {!! Form::label('message', 'Send New Reply') !!}
                    @else
                        {!! Form::label('message', 'Send Reply') !!}
                    @endif
                    {!! Form::textarea('message', null, ['class' => 'form-control wysiwyg']) !!}
                </div>

                <div class="text-right">
                    {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>
        </div>

        {!! Form::close() !!}
    @endif

@endsection
