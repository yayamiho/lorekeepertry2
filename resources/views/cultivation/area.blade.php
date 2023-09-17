@extends('cultivation.layout')

@section('cultivation-title') {{ $area->name }} @endsection

@section('cultivation-content')
{!! breadcrumbs([ucfirst(__('cultivation.cultivation')) => ucfirst(__('cultivation.cultivation')), $area->name => $area->idUrl]) !!}

<h1>
    {{ $area->name }}
</h1>


<div class="justify-content-center">

        <div class="row d-flex align-items-end text-center" style="background:url('{{$area->backgroundImageUrl}}'); background-repeat:no-repeat; background-size:cover; min-height:450px;">
            @foreach(range(1,$area->max_plots) as $i)
            <div class="col-md-3 col-6 mb-2">
                <div class="row justify-content-center">
                    <img src="{{ $area->plotImageUrl }}" style="max-width:100%;" alt="plot" />
                </div>
                <div class="row justify-content-center">
                    <button class="plot-button btn btn-primary btn-sm">Plot {{ $i }}</button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="p-5 m-auto mt-5">{!! $area->parsed_description !!}</div>

</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('.plot-button').on('click', function(e) {
            e.preventDefault();
            loadModal("{{ url('cultivation/'.$area->id) }}/" + $(this).data('id'), 'Purchase Item');
        });
    });

</script>
@endsection
