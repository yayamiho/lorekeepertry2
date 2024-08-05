@if ($carousel)
    {!! Form::open(['url' => 'admin/data/carousel/edit/' . $carousel->id, 'files' => true, 'method' => 'post']) !!}

    <div class="form-group">
            {!! Form::label('link') !!}
            {!! Form::text('link', $carousel->link, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('alt text') !!} {!! add_help('This is for accessibility purposes.') !!}
            {!! Form::text('alt_text', $carousel->alt_text, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Image') !!}
            <div>{!! Form::file('image') !!}</div>
        </div>

        <div class="form-group">
            {!! Form::checkbox('is_visible', 1, $carousel->is_visible, ['class' => 'form-check-input mr-2', 'data-toggle' => 'toggle']) !!}
            {!! Form::label('is visible', 'Set Visible', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If turned off, this carousel image will not be visible.') !!}
        </div>

    <div class="text-right">
        {!! Form::submit('Edit Carousel', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@else
    Invalid carousel selected.
@endif
