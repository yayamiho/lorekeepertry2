<li class="list-group-item">
    <a class="card-title h5 collapse-title" data-toggle="collapse" href="#bookform"> Use
        {{ ucfirst(__('volumes.book')) }}</a>
    <div id="bookform" class="collapse">
        {!! Form::hidden('tag', $tag->tag) !!}
        @php
            $book = \App\Models\Volume\Book::find($tag->getData()['book_id']);
        @endphp
        <p>Using this item will credit all of {!! $book->displayName !!}'s {{ __('volumes.volumes') }} to your {{ __('volumes.volumes') }} collection.</p>
        <p>This action is not reversible. Are you sure you want to use this item?</p>

        <div class="text-right">
            {!! Form::button('Use', [
                'class' => 'btn btn-primary',
                'name' => 'action',
                'value' => 'act',
                'type' => 'submit',
            ]) !!}
        </div>
    </div>
</li>
