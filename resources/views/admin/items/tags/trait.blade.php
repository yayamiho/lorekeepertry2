<h3>Trait</h3>

<p>This item grants a trait to a design when added to the myo/design update submission.</p>

<div class="row">
    <div class="col">
        {!! Form::label('Grants Trait') !!} {!! add_help('Choose a trait that this item grants.') !!}
    </div>
    <div class="col">
        {!! Form::select('feature_id', $features, $tag->getData() ?? null, ['class' => 'form-control mr-2
        feature-select', 'placeholder' => 'Select Trait']) !!}
    </div>
</div>