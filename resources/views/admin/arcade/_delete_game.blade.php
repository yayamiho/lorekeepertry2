@if ($game)
    {!! Form::open(['url' => 'admin/data/arcade/delete/' . $game->id]) !!}

    <p>You are about to delete the game <strong>{{ $game->name }}</strong>. This is not reversible. If this game exists in at least one user's possession, you will not be able to delete this game.</p>
    <p>Are you sure you want to delete <strong>{{ $game->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete Game', ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid game selected.
@endif
