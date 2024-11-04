@extends('world.layout')

@section('title') {{ __('lorekeeper.subtypes') }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', __('lorekeeper.subtypes') => 'world/subtypes']) !!}
<h1>{{ __('lorekeeper.subtypes') }}</h1>

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

<div class="text-center mt-4 small text-muted">{{ $subtypes->total() }} {{ trans_choice('lorekeeper.subtypes_', $subtypes->total()) }} found.</div>

    <div class="text-center mt-4 small text-muted">{{ $subtypes->total() }} result{{ $subtypes->total() == 1 ? '' : 's' }} found.</div>
@endsection
