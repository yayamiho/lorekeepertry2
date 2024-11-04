@extends('world.layout')

<<<<<<< HEAD
@section('world-title')
    Subtypes
@endsection

@section('content')
    {!! breadcrumbs(['World' => 'world', 'Subtypes' => 'world/subtypes']) !!}
    <h1>Subtypes</h1>
=======
@section('title') {{ __('lorekeeper.subtypes') }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', __('lorekeeper.subtypes') => 'world/subtypes']) !!}
<h1>{{ __('lorekeeper.subtypes') }}</h1>
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::text('name', Request::get('name'), ['class' => 'form-control']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

<<<<<<< HEAD
    {!! $subtypes->render() !!}
    @foreach ($subtypes as $subtype)
        <div class="card mb-3">
            <div class="card-body">
                @include('world._subtype_entry', ['subtype' => $subtype])
            </div>
        </div>
    @endforeach
    {!! $subtypes->render() !!}
=======
<div class="text-center mt-4 small text-muted">{{ $subtypes->total() }} {{ trans_choice('lorekeeper.subtypes_', $subtypes->total()) }} found.</div>
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec

    <div class="text-center mt-4 small text-muted">{{ $subtypes->total() }} result{{ $subtypes->total() == 1 ? '' : 's' }} found.</div>
@endsection
