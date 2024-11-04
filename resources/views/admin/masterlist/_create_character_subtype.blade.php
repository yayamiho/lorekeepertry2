<<<<<<< HEAD
{!! Form::label('Subtype (Optional)') !!} @if ($isMyo)
    {!! add_help(
        'This will lock the slot into a particular subtype. Leave it blank if you would like to give the user a choice, or not select a subtype. The subtype must match the species selected above, and if no species is specified, the subtype will not be applied.',
    ) !!}
@endif
=======
{!! Form::label(ucfirst(__('lorekeeper.subtype')).' (Optional)') !!} @if($isMyo) {!! add_help('This will lock the slot into a particular '.__('lorekeeper.subtype').'. Leave it blank if you would like to give the user a choice, or not select a '.__('lorekeeper.subtype').'. The '.__('lorekeeper.subtype').' must match the '.__('lorekeeper.species').' selected above, and if no '.__('lorekeeper.species').' is specified, the '.__('lorekeeper.subtype').' will not be applied.') !!} @endif
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec
{!! Form::select('subtype_id', $subtypes, old('subtype_id'), ['class' => 'form-control', 'id' => 'subtype']) !!}
