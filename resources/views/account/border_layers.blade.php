<div id="layers">
    <div class="form-group row">
        <label class="col-md-2 col-form-label">Top Border</label>
        <div class="col-md-10">
            {!! Form::select('top_border_id', $top_layers, Auth::user()->top_border_id, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-2 col-form-label">Bottom Border</label>
        <div class="col-md-10">
            {!! Form::select('bottom_border_id', $bottom_layers, Auth::user()->bottom_border_id, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>
