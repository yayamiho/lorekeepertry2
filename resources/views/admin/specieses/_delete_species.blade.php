@if ($species)
    {!! Form::open(['url' => 'admin/data/species/delete/' . $species->id]) !!}

    <p>You are about to delete the {{ __('lorekeeper.species') }} <strong>{{ $species->name }}</strong>. This is not reversible. If traits and/or characters that have this {{ __('lorekeeper.species') }} exist, you will not be able to delete this {{ __('lorekeeper.species') }}.</p>
    <p>Are you sure you want to delete <strong>{{ $species->name }}</strong>?</p>

    <div class="text-right">
        {!! Form::submit('Delete '.ucfirst(__('lorekeeper.species')), ['class' => 'btn btn-danger']) !!}
    </div>

    {!! Form::close() !!}
@else
<<<<<<< HEAD
    Invalid species selected.
=======
    Invalid {{ __('lorekeeper.species') }} selected.
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec
@endif
