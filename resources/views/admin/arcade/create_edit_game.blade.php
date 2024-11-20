@extends('admin.layout')

@section('admin-title') {{ $game->id ? 'Edit Game: ' . $game->name : 'Create Game' }}  @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Games' => 'admin/data/arcade', ($game->id ? 'Edit' : 'Create').' Game' => $game->id ? 'admin/data/arcade/edit/'.$game->id : 'admin/data/arcade/create']) !!}

<h1>{{ $game->id ? 'Edit ' . $game->name : 'Create Theme' }}
    @if($game->id)
        <a href="#" class="btn btn-danger float-right delete-game-button">Delete Theme</a>
    @endif
</h1>game
@if($game->creators) <h5>by {!! $game->creatorDisplayName !!}</h5> @endif

{!! Form::open(['url' => $game->id ? 'admin/games/edit/'.$game->id : 'admin/games/create', 'files' => true]) !!}

<h5>Basic Information</h5>

<div class="form-group row">
    <div class="col-md-8">
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', $game->name, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>



<div class="text-right">
    {!! Form::submit($game->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary px-5']) !!}
</div>

{!! Form::close() !!}

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {

    $('.delete-game-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/games/delete') }}/{{ $game->id }}", 'Delete Game');
    });

});
</script>
@endsection
