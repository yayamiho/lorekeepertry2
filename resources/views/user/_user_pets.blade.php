@if ($characters->count())
    <div class="row">
        <div id="sortable" class="row sortable justify-content-center">
            @foreach ($characters as $character)
                @foreach($character->pets()->orderBy('sort', 'DESC')->get() as $pet)
                    <div class="col-md-3 col-6" data-id="{{ $pet->id }}">
                        <div class="card mb-3 inventory-category h-100" data-id="{{ $pet->id }}">
                            <div class="card-body inventory-body text-center">
                                <div class="mb-1">
                                    <a href="{{ $pet->pageUrl() }}" class="inventory-stack">
                                        <img src="{{ $pet->pet->variantImage($pet->id) }}" class="rounded img-fluid" />
                                    </a>
                                </div>
                                <div>
                                    @if ($pet->pet_name)
                                        <a href="{{ $pet->pageUrl() }}">
                                            <div class="text-light btn btn-dark">{!! $pet->pet_name !!}</div>
                                        </a>
                                    @endif
                                    <div>{!! $pet->pet->displayName !!}</div>
                                </div>
                                @if (config('lorekeeper.pets.pet_bonding_enabled'))
                                    <div class="progress mb-2">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                            style="width: {{ ($pet->level?->nextLevel?->bonding_required ? ($pet->level?->bonding / $pet->level?->nextLevel?->bonding_required) : 1 * 100) . '%' }}"
                                            aria-valuenow="{{ $pet->level?->bonding }}" aria-valuemin="0"
                                            aria-valuemax="{{ $pet->level?->nextLevel?->bonding_required ?? 100 }}">
                                            {{ $pet->level?->nextLevel?->bonding_required ? ($pet->level?->bonding . '/' . $pet->level?->nextLevel?->bonding_required) : $pet->level?->levelName }}
                                        </div>
                                    </div>
                                    @if (Auth::check() && Auth::user()->id == $character->user_id && $pet->canBond())
                                        <div class="form-group mb-0" id="bondForm">
                                            {!! Form::open(['url' => 'pets/bond/' . $pet->id]) !!}
                                            {!! Form::submit('Bond', ['class' => 'btn btn-primary', 'id' => 'bond']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    @else
                                        <div class="alert alert-warning mb-0">{{ $pet->canBond(true) }}</div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
@else
    <p>No pets found.</p>
@endif