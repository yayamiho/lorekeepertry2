@extends('home.layout')

@section('home-title')
Pets
@endsection

@section('home-content')
{!! breadcrumbs(['Pets' => 'pets']) !!}

<h1>
    Pets
</h1>

<p>These are your pets. Click on a pet to view more details and actions you can perform on it.</p>

<div class="d-flex justify-content-center">
    <!--{!! Form::open(['url' => 'pets/collect-all']) !!}
        {!! Form::submit('Collect All Pet Drops', ['class' => 'btn btn-success my-3 mx-1']) !!}
        {!! Form::close() !!}-->
    @php
        $petCount = 0;
    @endphp
    @foreach ($pets as $categoryId => $categoryPets)
        @foreach ($categoryPets->chunk(4) as $chunk)
            @foreach ($chunk as $pet)
                @php
                    $petCount++;
                @endphp
            @endforeach
        @endforeach
    @endforeach

    @if ($petCount >= Settings::get('bondAll_pets'))
        {!! Form::open(['url' => 'pets/bond-all']) !!}
        {!! Form::submit('Bond With All Pets', ['class' => 'btn btn-success my-3 mx-1 bond-all-button']) !!}
        {!! Form::close() !!}
    @endif

</div>

@foreach ($pets as $categoryId => $categoryPets)
    <div class="card mb-3 inventory-category">
        <h5 class="card-header inventory-header">
            {!! isset($categories[$categoryId]) ? '<a href="' . $categories[$categoryId]->searchUrl . '">' . $categories[$categoryId]->name . '</a>' : 'Miscellaneous' !!}
        </h5>
        <div class="card-body inventory-body">
            @foreach ($categoryPets->chunk(4) as $chunk)
                <div class="row mb-3">
                    @foreach ($chunk as $pet)
                        <div class="col-sm-3 col-6 text-center inventory-pet" data-id="{{ $pet->pivot->id }}"
                            data-name="{{ $user->name }}'s {{ $pet->name }}">
                            <div class="mb-1">
                                <a href="#" class="inventory-stack"><img src="{{ $pet->VariantImage($pet->pivot->id) }}"
                                        class="img-fluid" /></a>
                            </div>
                            <div>
                                <a href="{{ url('pets/view/' . $pet->pivot->id) }}"
                                    class="{{ $pet->pivot->pet_name ? 'btn-dark' : 'btn-primary' }} btn btn-sm my-1">
                                    {!! $pet->pivot->pet_name ?? ($pet->pivot->evolution_id ? $pet->evolutions->where('id', $pet->pivot->evolution_id)->first()->evolution_name : $pet->name) !!}
                                    @if ($pet->pivot->has_image)
                                        <i class="fas fa-brush ml-1" data-toggle="tooltip" title="This pet has custom art."></i>
                                    @endif
                                    @if ($pet->pivot->character_id)
                                        <span data-toggle="tooltip" title="Attached to a character."><i
                                                class="fas fa-link ml-1"></i></span>
                                    @endif
                                    @if ($pet->pivot->evolution_id)
                                        <span data-toggle="tooltip"
                                            title="This pet has evolved. Stage
                                                                                                                                                                                                                                                                            {{ $pet->evolutions->where('id', $pet->pivot->evolution_id)->first()->evolution_stage }}."><i
                                                class="fas fa-angle-double-up ml-1"></i>
                                        </span>
                                    @endif
                                </a>
                            </div>

                            @if ($pet->pivot->character_id)
                                @if (config('lorekeeper.pets.pet_bonding_enabled'))

                                    @php
  $petData = \App\Models\User\UserPet::where('id', $pet->pivot->id)->first();
  $level = \App\Models\Pet\PetLevel::where('level', $petData->level->bonding_level)->first();
@endphp
<div class="progress mb-2">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
      style="width: {{ ($petData->level?->nextLevel?->bonding_required ? ($petData->level?->bonding / $petData->level?->nextLevel?->bonding_required) * 100 : 1 * 100) . '%' }}"
      aria-valuenow="{{ $petData->level?->bonding }}" aria-valuemin="0" aria-valuemax="{{ $petData->level?->nextLevel?->bonding_required ?? 100 }}">
      {{ $petData->level?->nextLevel?->bonding_required ? ($petData->level?->bonding .'/'. $petData->level?->nextLevel?->bonding_required) : $petData->level?->levelName }}
  </div>
</div>
<div style="margin-top:-5px; margin-bottom:5px; font-style:italic">
  {{ !isset($level) ? config('lorekeeper.pets.initial_level_name') : $level->name }}
</div>


                                    @if ($pet->pivot->bonded_at && Carbon\Carbon::parse($pet->pivot->bonded_at)->isToday())
                                        <span class="alert alert-warning mb-0" style="padding:0.25rem .5rem">Bonded Today</span>
                                    @else
                                        <div class="form-group mb-0" id="bondForm">
                                            {!! Form::open(['url' => 'pets/bond/' . $pet->pivot->id]) !!}
                                            {!! Form::submit('Bond', ['class' => 'btn btn-primary', 'id' => 'bond']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    @endif
                                @endif

                            @endif

                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endforeach
<div class="text-right mb-4">
    <a href="{{ url(Auth::user()->url . '/pet-logs') }}">View logs...</a>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('.inventory-stack').on('click', function (e) {
            e.preventDefault();
            var $parent = $(this).parent().parent();
            loadModal("{{ url('pets') }}/" + $parent.data('id'), $parent.data('name'));
        });
    });
</script>
@endsection