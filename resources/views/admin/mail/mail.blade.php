@extends('admin.layout')

@section('admin-title')
    Mod Mail (#{{ $mail->id }})
@endsection

@section('admin-content')
    {!! breadcrumbs(['Admin Panel' => 'admin', 'Mod Mail' => 'admin/mail', 'Mail #' . $mail->id => 'admin/mail/' . $mail->id]) !!}

    <h1>Mod Mail (#{{ $mail->id }})</h1>

    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h3>Subject: {{ $mail->subject }}</h3>
                </div>
                <div class="col-6 text-right">
                    <h5>Sent {!! pretty_date($mail->created_at) !!}</h5>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if (Auth::check() && Auth::user()->isStaff)
                <p class="float-right ml-5">From: {!! $mail->staff->displayName !!} {!! add_help('Not viewable by users.') !!}</p>
            @endif
            <p>To: {!! $mail->user->displayName !!} {!! $mail->seen ? '<i class="fas fa-eye text-success"></i>' : '<i class="fas fa-eye-slash text-danger"></i>' !!}</p>
            <hr>
            <p>{!! $mail->message !!}</p>
            <hr>
            <div class="alert {!! $mail->issue_strike ? 'alert-danger' : 'alert-secondary' !!} w-100 text-right m-0">
                @if (!$mail->issue_strike)
                    <h5>No Strike Issued</h5>
                @else
                    <h5>Strike{{ $mail->strike_count > 1 ? 's' : '' }} Issued</h5>
                    <strong>Amount:</strong> {{ $mail->strike_count }}
                    @if ($mail->strike_expiry)
                        <br>
                        <strong>Expires:</strong> {!! pretty_date($mail->strike_expiry) !!}
                    @endif
                @endif
            </div>
        </div>
    </div>

    @if (config('lorekeeper.mod_mail.allow_replies_to_staff'))
        @comments(['type' => 'Staff-User', 'model' => $mail, 'perPage' => 5])
    @endif
@endsection
