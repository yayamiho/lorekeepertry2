{!! Form::open(['url' => 'admin/data/borders/edit/' . $border->id . '/variants/' . ($variant->id ? 'edit/' . $variant->id : 'create'), 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="row">
    <div class="col-md-6 form-group">
        {!! Form::label('Name') !!}
        {!! Form::text('name', $variant->name, ['class' => 'form-control']) !!}
    </div>
    @if ($variant->id)
        <div class="col-md-6 form-group">
            {!! Form::checkbox('delete', 1, false, [
                'class' => 'form-check-input',
                'data-toggle' => 'toggle',
            ]) !!}
            {!! Form::label('delete', 'Delete Variant', ['class' => 'form-check-label ml-3']) !!}
        </div>
    @endif
    <div class="col-md-6 form-group">
        {!! Form::checkbox('is_active', 1, $variant->is_active, [
            'class' => 'form-check-input',
            'data-toggle' => 'toggle',
        ]) !!}
        {!! Form::label('is_active', 'Active?', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Users can\'t see or select this border if it isn\'t visible.') !!}
    </div>
</div>

<h3>Image</h3>
<p>An image is required. You can't have a border with no image!</p>

<div class="row">
    @if ($variant->id)
        <div class="col-md-2">
            <div class="form-group">
                <h5>Image</h5>
                <img src="{{ $variant->imageUrl }}" class="mw-100" style="width:125px; height:125px;" />
                <br>
            </div>
            <div class="form-group">
                <h5>In Action</h5>
                {!! $variant->preview() !!}
                <br>
            </div>
        </div>
    @endif
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Variant Image') !!}
            <div>{!! Form::file('image') !!}</div>
            <div class="text-muted">Supports .png and .gif</div>
        </div>
        <div class="form-group">
            {!! Form::label('Border Style (Required)') !!}{!! add_help('Choose how the border will display around an icon. It can display over or under the user\'s icon.') !!}
            {!! Form::select('border_style', ['0' => 'Under', '1' => 'Over'], $variant->border_style, [
                'class' => 'form-control',
                'placeholder' => 'Select a Type',
            ]) !!}
        </div>
    </div>
</div>
<h5>Second Layer</h5>
<p>You can layer a second image here.</p>
<div class="row">
    @if ($variant->has_layer)
        <div class="col-md-2">
            <div class="form-group">
                <h5>Image</h5>
                <img src="{{ $variant->layerUrl }}" class="mw-100" style="width:125px; height:125px;" />
                <br>
            </div>
        </div>
    @endif
    <div class="col-md-6">
        <div class="form-group">
            {!! Form::label('Layer Image') !!}
            <div>{!! Form::file('layer_image') !!}</div>
            <div class="text-muted">Supports .png and .gif</div>
        </div>
        <div class="form-group">
            {!! Form::label('Layer Style (Required)') !!}{!! add_help('Choose how the layer will display around an icon. It can display over or under the user\'s icon.') !!}
            {!! Form::select('layer_style', ['0' => 'Under', '1' => 'Over'], $variant->layer_style, [
                'class' => 'form-control',
                'placeholder' => 'Select a Type',
            ]) !!}
        </div>
    </div>
</div>
<div class="text-right">
    {!! Form::submit($variant->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}
