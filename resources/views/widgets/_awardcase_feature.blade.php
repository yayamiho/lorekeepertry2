@if($target->awards->where('is_featured',1) && $count)
    <div class="my-3 card {{ $float ? 'float-md-right ml-md-4' : '' }}"><div class="row justify-content-center align-items-center">
        @foreach($target->awards->where('is_featured',1)->unique()->take($count) as $award)
            <div class="text-center mb-1 px-1">
                <a href="{{$award->url}}" class="alert alert-success"><img src="{{ $award->imageUrl }}" alt="{{ $award->name }}" data-toggle="tooltip" data-title="{{ $award->name }}"/></a>
            </div>
        @endforeach
    </div></div>
@endif
