@extends('account.layout')

@section('account-title')
    Settings
@endsection

@section('account-content')
    {!! breadcrumbs(['My Account' => Auth::user()->url, 'Settings' => 'account/settings']) !!}

    <h1>Settings</h1>


    <div class="card p-3 mb-2">
        <h3>Avatar</h3>
        <div class="text-left">
            <div class="alert alert-warning">Please note a hard refresh may be required to see your updated avatar. Also please note that uploading a .gif will display a 500 error after; the upload should still work, however.</div>
        </div>
        @if (Auth::user()->isStaff)
            <div class="alert alert-danger">For admins - note that .GIF avatars leave a tmp file in the directory (e.g php2471.tmp). There is an automatic schedule to delete these files.
            </div>
        @endif
        <form enctype="multipart/form-data" action="avatar" method="POST">
            <label>Update Profile Image</label><br>
            <input type="file" name="avatar">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="pull-right btn btn-sm btn-primary">
        </form>
    </div>


    <div class="card p-3 mb-2">
        <h3>Profile</h3>
        {!! Form::open(['url' => 'account/profile']) !!}
        <div class="form-group">
            {!! Form::label('text', 'Profile Text') !!}
            {!! Form::textarea('text', Auth::user()->profile->text, ['class' => 'form-control wysiwyg']) !!}
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>Birthday Publicity</h3>
        {!! Form::open(['url' => 'account/dob']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Setting</label>
            <div class="col-md-10">
                {!! Form::select(
                    'birthday_setting',
                    ['0' => '0: No one can see your birthday.', '1' => '1: Members can see your day and month.', '2' => '2: Anyone can see your day and month.', '3' => '3: Full date public.'],
                    Auth::user()->settings->birthday_setting,
                    ['class' => 'form-control'],
                ) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>Email Address</h3>
        <p>Changing your email address will require you to re-verify your email address.</p>
        {!! Form::open(['url' => 'account/email']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Email Address</label>
            <div class="col-md-10">
                {!! Form::text('email', Auth::user()->email, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>Change Password</h3>
        {!! Form::open(['url' => 'account/password']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Old Password</label>
            <div class="col-md-10">
                {!! Form::password('old_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">New Password</label>
            <div class="col-md-10">
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Confirm New Password</label>
            <div class="col-md-10">
                {!! Form::password('new_password_confirmation', ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}
    </div>

    <div class="card p-3 mb-2">
        <h3>Border</h3>
        <p>Change your onsite border.</p>
        <p>Standard borders behave as normal. Variants may be different colors or even border styles than the main border. If your chosen main border has a "layer" associated with it, you can layer that image with one of its variant's borders.</p>
        <p>Variants supersede standard borders, and layers supersede variants.</p>
        {!! Form::open(['url' => 'account/border']) !!}
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Border</label>
            <div class="col-md-10">
                {!! Form::select('border', $borders, Auth::user()->border_id, ['class' => 'form-control', 'id' => 'border']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">Border Variant</label>
            <div class="col-md-10">
                {!! Form::select('border_variant_id', $border_variants, Auth::user()->border_variant_id, ['class' => 'form-control', 'id' => 'bordervariant']) !!}
            </div>
        </div>
        <div id="layers">
        </div>
        <div class="text-right">
            {!! Form::submit('Edit', ['class' => 'btn btn-primary']) !!}
        </div>
        {!! Form::close() !!}

        <h3 class="text-center">Your Borders</h3>
        <div class="card p-3 mb-2 image-info-box">
            @if ($default->count())
                <h4 class="mb-0">Default</h4>
                <hr class="mt-0">
                <div class="row">
                    @foreach ($default as $border)
                        <div class="col-md-3 col-6 text-center">
                            <div class="shop-image">
                                {!! $border->preview() !!}
                            </div>
                            <div class="shop-name mt-1 text-center">
                                <h5>{!! $border->displayName !!}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (Auth::user()->borders->count())
                <h4 class="mb-0">Unlocked</h4>
                <hr class="mt-0">
                <div class="row">
                    @foreach (Auth::user()->borders as $border)
                        <div class="col-md-3 col-6 text-center">
                            <div class="shop-image">
                                {!! $border->preview() !!}
                            </div>
                            <div class="shop-name mt-1 text-center">
                                <h5>{!! $border->displayName !!}</h5>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if (Auth::user()->isStaff)
                @if ($admin->count())
                    <h4 class="mb-0">Staff-Only</h4>
                    <hr class="mt-0">
                    <small>You can see these as a member of staff</small>
                    <div class="row">
                        @foreach ($admin as $border)
                            <div class="col-md-3 col-6 text-center">
                                <div class="shop-image">
                                    {!! $border->preview() !!}
                                </div>
                                <div class="shop-name mt-1 text-center">
                                    <h5>{!! $border->displayName !!}</h5>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
        <div class="text-right mb-4">
            <a href="{{ url(Auth::user()->url . '/border-logs') }}">View logs...</a>
        </div>
    </div>


@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            refreshBorder();
        });

        $("#border").change(function() {
            refreshBorder();
        });

        function refreshBorder() {
            var border = $('#border').val();
            $.ajax({
                type: "GET",
                url: "{{ url('account/check-border') }}?border=" + border,
                dataType: "text"
            }).done(function(res) {
                $("#bordervariant").html(res);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });
            $.ajax({
                type: "GET",
                url: "{{ url('account/check-layers') }}?border=" + border,
                dataType: "text"
            }).done(function(res) {
                $("#layers").html(res);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("AJAX call failed: " + textStatus + ", " + errorThrown);
            });
        };
    </script>
@endsection
