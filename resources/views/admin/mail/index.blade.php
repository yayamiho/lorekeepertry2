@extends('admin.layout')

@section('admin-title')
    Mod Mail
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'Mod Mail' => 'admin/mail']) !!}

    <div class="float-right">
        <a href="{{ url('admin/mail/create') }}" class="btn btn-primary">Send Mail</a>
    </div>

    <h1>Mod Mail</h1>

    <p>
        Mod Mail can be sent to a user anonymously by staff in order to issue strikes, warnings, information etc.
        <br> Mail can be used to automatically ban users after a set number of strikes
        (see the setting "max_strike_count" in <a href="{{ url('admin/settings') }}">Site Settings</a>).
    </p>

    <div>
        {!! Form::open(['method' => 'GET', 'class' => 'form-inline justify-content-end']) !!}
        <div class="form-group mr-3 mb-3">
            {!! Form::select('recipient_id', $users, Request::get('recipient_id'), ['class' => 'form-control', 'placeholder' => 'Select User']) !!}
        </div>
        <div class="form-group mb-3">
            {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    @if (!count($mails))
        <p>No mail found.</p>
    @else
        {!! $mails->render() !!}
        @include('home.mail._mail', ['mails' => $mails])
        {!! $mails->render() !!}
    @endif
@endsection
