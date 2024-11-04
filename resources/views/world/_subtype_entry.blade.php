<div class="row world-entry">
    @if ($subtype->subtypeImageUrl)
        <div class="col-md-3 world-entry-image">
            <a href="{{ $subtype->subtypeImageUrl }}" data-lightbox="entry" data-title="{{ $subtype->name }}">
                <img src="{{ $subtype->subtypeImageUrl }}" class="world-entry-image" alt="{{ $subtype->name }}" />
            </a>
        </div>
    @endif
    <div class="{{ $subtype->subtypeImageUrl ? 'col-md-9' : 'col-12' }}">
<<<<<<< HEAD
        <x-admin-edit title="Subtype" :object="$subtype" />
        <h3>
            @if (!$subtype->is_visible)
                <i class="fas fa-eye-slash mr-1"></i>
            @endif
            {!! $subtype->displayName !!} ({!! $subtype->species->displayName !!} Subtype)
            <a href="{{ $subtype->searchUrl }}" class="world-entry-search text-muted">
                <i class="fas fa-search"></i>
            </a>
        </h3>
=======
        <h3>{!! $subtype->displayName !!} ({!! $subtype->species->displayName !!} {{ __('lorekeeper.subtype')}}) <a href="{{ $subtype->searchUrl }}" class="world-entry-search text-muted"><i class="fas fa-search"></i></a></h3>
>>>>>>> 7741e9cbbdc31ea79be2d1892e9fa2efabce4cec
        <div class="world-entry-text">
            {!! $subtype->parsed_description !!}
        </div>
    </div>
</div>
