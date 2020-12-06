@extends('layouts.app')

@section('title') Advent Calendar :: {{ $advent->displayName }} @endsection

@section('content')
{!! breadcrumbs(['Advent Calendar' => $advent->url, $advent->displayName => $advent->url]) !!}

<div class="row">
    <div class="col-sm">
    </div>
    <div class="col-lg-8 col-md-12">
        <div class="mb-3">

            <h2>{{ $advent->displayName }}</h2>

            @if($advent->isActive)
                <div class="mb-3 pt-3 text-center card">
                    <div class="card-body">
                        @if($advent->item($advent->day))
                            <h5>It's day {{ $advent->day }}! Today's prize is:</h5>
                            <p>
                                {!! $advent->displayItemLong($advent->day) !!}
                            </p>

                            <p>
                                Congratulations! Click the button below to claim today's prize.
                            </p>

                            <div class="mb-4">
                                @if($advent->isActive)
                                    @if(!isset($dayLog))
                                        {!! Form::open(['url' => 'advent-calendars/'.$advent->id]) !!}
                                            {!! Form::submit('Claim', ['class' => 'btn btn-primary']) !!}
                                        {!! Form::close() !!}
                                    @else
                                        <p><strong>You've already claimed this!</strong></p>
                                    @endif
                                @else
                                    <p>This advent calendar isn't active.</p>
                                @endif
                            </div>
                        @elseif($advent->isActive)
                            <p>There doesn't seem to be a prize for today!</p>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h4>Information</h4>
                </div>
                <div class="card-body">
                <div><strong>Start Time: </strong>{!! pretty_date($advent->start_at) !!}</div>
                <div class="mb-2"><strong>End Time: </strong>{!! pretty_date($advent->end_at) !!}</div>

                @if($advent->summary)
                    <i>{{ $advent->summary }}</i>
                @endif

                @if($participantLog->count())
                    <hr/>
                    <p>You've claimed these prizes{{ $advent->isActive ? ' thus far' : '' }}:</p>
                    <div class="d-flex">
                        @foreach($participantLog as $log)
                            {!! $advent->displayItemShort($log->day) !!}
                        @endforeach
                    </div>
                @endif
                </div>
            </div>

        </div>
    </div>
    <div class="col-sm">
    </div>
</div>

@endsection
