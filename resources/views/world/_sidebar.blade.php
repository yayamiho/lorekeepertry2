<ul>
    <li class="sidebar-header"><a href="{{ url('world') }}" class="card-link">Encyclopedia</a></li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Characters</div>
        <div class="sidebar-item"><a href="{{ url('world/species') }}"
                class="{{ set_active('world/species*') }}">{{ __('lorekeeper.specieses') }}</a></div>
        <div class="sidebar-item"><a href="{{ url('world/subtypes') }}"
                class="{{ set_active('world/subtypes*') }}">{{ __('lorekeeper.subtypes') }}</a></div>
        <div class="sidebar-item"><a href="{{ url('world/rarities') }}"
                class="{{ set_active('world/rarities*') }}">Rarities</a></div>
        <div class="sidebar-item"><a href="{{ url('world/trait-categories') }}"
                class="{{ set_active('world/trait-categories*') }}">Trait Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/traits') }}" class="{{ set_active('world/traits*') }}">
                Traits</a></div>
        @if (config('lorekeeper.extensions.visual_trait_index.enable_universal_index'))
            <div class="sidebar-item"><a href="{{ url('world/universaltraits') }}"
                    class="{{ set_active('world/universaltraits*') }}">Universal Trait Index</a></div>
        @endif
        <div class="sidebar-item"><a href="{{ url('world/character-categories') }}"
                class="{{ set_active('world/character-categories*') }}">Character Categories</a></div>
    </li>
    <li class="sidebar-section">
        <div class="sidebar-section-header">Assets</div>
        <div class="sidebar-item"><a href="{{ url('world/item-categories') }}"
                class="{{ set_active('world/item-categories*') }}">Item Categories</a></div>
        <div class="sidebar-item"><a href="{{ url('world/items') }}" class="{{ set_active('world/items*') }}">Items</a>
        </div>
        <div class="sidebar-item"><a href="{{ url('world/currencies') }}"
                class="{{ set_active('world/currencies*') }}">Currencies</a></div>
        <div class="sidebar-item"><a href="{{ url('world/pet-categories') }}"
                class="{{ set_active('world/pet-categories*') }}">Pet Categories</a>
        </div>
        <div class="sidebar-item"><a href="{{ url('world/bestiary') }}" class="{{ set_active('world/bestiary*') }}">Bestiary</a>
        </div>
        <div class="sidebar-item"><a href="{{ url('world/recipes') }}"
                class="{{ set_active('world/recipes*') }}">Recipes</a></div>

        <div class="sidebar-item"><a href="{{ url('world/collections') }}"
                class="{{ set_active('world/collections*') }}">Collections</a></div>
        <div class="sidebar-item"><a href="{{ url('world/borders') }}" class="{{ set_active('world/borders*') }}">User
                Borders</a></div>
        <div class="sidebar-item"><a href="{{ url('world/' . __('awards.awards')) }}"
                class="{{ set_active('world/' . __('awards.awards') . '*') }}">Awards </a></div>
        <div class="sidebar-item"><a href="{{ url('world/' . __('volumes.library')) }}"
                class="{{ set_active('world/' . __('volumes.library')) }}">Library</a></div>
    </li>
</ul>