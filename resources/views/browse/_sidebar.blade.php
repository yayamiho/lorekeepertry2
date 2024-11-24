<ul>
    <li class="sidebar-header"><a href="{{ url('masterlist') }}" class="card-link">Masterlist</a></li>
    <li class="sidebar-section">
        <!--<div class="sidebar-section-header">Masterlist</div>-->
        <!--<div class="sidebar-item"><a href="{{ url('masterlist') }}" class="{{ set_active('masterlist*') }}">All
                Characters</a></div>-->
        @if (isset($sublists) && $sublists->count() > 0)
            @foreach ($sublists as $sublist)
                <div class="sidebar-item"><a href="{{ url('sublist/' . $sublist->key) }}"
                        class="{{ set_active('sublist/' . $sublist->key) }}">{{ $sublist->name }}</a></div>
            @endforeach
        @endif
    </li>
</ul>