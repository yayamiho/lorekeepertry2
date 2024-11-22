@extends('character.layout', ['isMyo' => $character->is_myo_slot])
@extends('layouts.app')

@section('title')
Your Active Pets
@endsection

@section('meta-img')
{{ asset('/images/avatars/' . Auth::user()->avatar) }}
@endsection

@section('content')

{!! breadcrumbs([Auth::user()->name => Auth::user()->url . '/active-pets']) !!}

<div class="mb-3">
    Owned by {!! Auth::user()->name !!}
</div>

<h1>Pets</h1>

@if(Auth::check() && (Auth::user()->hasPower('manage_characters')))
    <p>
        Currently {{ config('lorekeeper.pets.display_pet_count') }}
        pet{{ config('lorekeeper.pets.display_pet_count') != 1 ? 's' : '' }} are displayed on the page.
        <br />You can determine which pets are displayed by dragging and dropping them in the order you want.
    </p>


    {!! Form::open(['url' => 'characters/' . $characters[0]->slug . '/pets/sort', 'class' => 'text-right']) !!}
    {!! Form::hidden('sort', null, ['id' => 'sortableOrder']) !!}
    {!! Form::submit('Save Order', ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
@endif

@include('user._user_pets', ['characters' => $characters])

@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        // when form is submitted disable button and hide form
        $('#bondForm').submit(function (e) {
            e.preventDefault();
            $('#bond').prop('disabled', true);
            $('#bondForm').hide();

            // submit form
            e.target.submit();
        });

        $("#sortable").sortable({
            characters: '.sort-item',
            placeholder: "sortable-placeholder col-md-3 col-6",
            stop: function (event, ui) {
                $('#sortableOrder').val($(this).sortable("toArray", {
                    attribute: "data-id"
                }));
            },
            create: function () {
                $('#sortableOrder').val($(this).sortable("toArray", {
                    attribute: "data-id"
                }));
            }
        });
        $("#sortable").disableSelection();
    });
</script>
@endsection