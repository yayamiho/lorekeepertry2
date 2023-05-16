@extends('world.layout')

@section('title') {{ trans_choice('lorekeeper.subtypes', 2) }} @endsection

@section('content')
{!! breadcrumbs(['World' => 'world', trans_choice('lorekeeper.subtypes', 2) => 'world/subtypes']) !!}
<h1>{{ trans_choice('lorekeeper.subtypes', 2) }}</h1>

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

{!! $subtypes->render() !!}
@foreach($subtypes as $subtype)
    <div class="card mb-3">
        <div class="card-body">
            @include('world._subtype_entry', ['subtype' => $subtype])
        </div>
    </div>
@endforeach
{!! $subtypes->render() !!}

<div class="text-center mt-4 small text-muted">{{ $subtypes->total() }} {{ trans_choice('lorekeeper.subtypes', $subtypes->total()) }} found.</div>

@endsection
