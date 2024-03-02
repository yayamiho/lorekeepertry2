@extends('world.layout')

@section('title')
    {{ $volume->name }}
@endsection

@section('meta-img')
    {{ $volume->imageUrl ? $volume->imageUrl : null }}
@endsection

@section('content')
    {!! breadcrumbs([
        'World' => 'world',
        __('volumes.library') => 'world/' . __('volumes.library'),
        Auth::check() && Auth::user()->hasVolume($volume->id) ? $volume->name : '???' => $volume->idUrl,
    ]) !!}

    @include('world.volumes._volume_page_entry', ['volume' => $volume, 'isAdmin' => false])

@endsection
