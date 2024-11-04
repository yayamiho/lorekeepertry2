<<<<<<< HEAD
{!! Form::label('Subtype (Optional)') !!}
{!! Form::select('subtype_id', $subtypes, old('subtype_id') ?: $subtype, ['class' => 'form-control', 'id' => 'subtype']) !!}
=======
{!! Form::label(ucfirst(__('lorekeeper.subtype')).' (Optional)') !!}
{!! Form::select('subtype_id', $subtypes, old('subtype_id') ? : $subtype, ['class' => 'form-control', 'id' => 'subtype']) !!}
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec
