<<<<<<< HEAD
{!! Form::open(['url' => 'admin/character/image/' . $image->id . '/active']) !!}
<p>This will set this image to be the character's thumbnail image and the first image a user sees when they view the character.</p>
<p>A non-visible image cannot be set as a character's active image. A non-valid image can, but this is not recommended. A character's active image cannot be deleted.</p>

<div class="text-right">
    {!! Form::submit('Set Active', ['class' => 'btn btn-primary']) !!}
</div>
=======
{!! Form::open(['url' => 'admin/character/image/'.$image->id.'/active']) !!}
    <p>This will set this image to be the {{__('lorekeeper.character')}}'s thumbnail image and the first image a user sees when they view the {{__('lorekeeper.character')}}.</p>
    <p>A non-visible image cannot be set as a {{__('lorekeeper.character')}}'s active image. A non-valid image can, but this is not recommended. A {{__('lorekeeper.character')}}'s active image cannot be deleted.</p>

    <div class="text-right">
        {!! Form::submit('Set Active', ['class' => 'btn btn-primary']) !!}
    </div>
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec
{!! Form::close() !!}
