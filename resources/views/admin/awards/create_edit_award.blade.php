@extends('admin.layout')

@section('admin-title') Awards @endsection

@section('admin-content')
{!! breadcrumbs(['Admin Panel' => 'admin', 'Awards' => 'admin/data/awards', ($award->id ? 'Edit' : 'Create').' Award' => $award->id ? 'admin/data/awards/edit/'.$award->id : 'admin/data/awards/create']) !!}

<h1>{{ $award->id ? 'Edit' : 'Create' }} Award
    @if($award->id)
        <a href="#" class="btn btn-outline-danger float-right delete-award-button">Delete Award</a>
    @endif
</h1>

{!! Form::open(['url' => $award->id ? 'admin/data/awards/edit/'.$award->id : 'admin/data/awards/create', 'files' => true]) !!}

<h3>Basic Information</h3>

<div class="row no-gutters">
    <div class="col-md-7 form-group d-flex align-items-center">
        {!! Form::label('name', 'Name', ['class' => 'mr-2 mb-0 font-weight-bold']) !!}
        {!! Form::text('name', $award->name, ['class' => 'form-control']) !!}
    </div>
    <div class="col-md form-group pl-md-3">
        {!! Form::checkbox('is_released', 1, $award->id ? $award->is_released : 1, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('is_released', 'Is Released', ['class' => 'form-check-label font-weight-bold ml-3']) !!} {!! add_help('If this is off, users will not be able to view information for the award/it will be hidden from view. This is overridden by the award being owned at any point by anyone on the site.') !!}
    </div>
    <div class="col-md-3 form-group pl-md-3">
        {!! Form::checkbox('allow_transfer', 1, $award->id ? $award->allow_transfer : 0, ['class' => 'form-check-input', 'data-toggle' => 'toggle']) !!}
        {!! Form::label('allow_transfer', 'Allow User → User Transfer', ['class' => 'form-check-label font-weight-bold ml-3']) !!} {!! add_help('If this is off, users will not be able to transfer this award to other users. Non-account-bound awards can be account-bound when granted to users directly.') !!}
    </div>
</div>

<div class="form-group">
    @if($award->has_image)
        <img src="{{ $award->imageUrl }}" class="float-left mr-2"/>
    @endif
    {!! Form::label('image', 'World Page Image (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!} {!! add_help('This image is used only on the world information pages.') !!}
    <div>{!! Form::file('image') !!}</div>
    <div class="text-muted">Recommended size: 100px x 100px</div>
    @if($award->has_image)
        <div class="form-check">
            {!! Form::checkbox('remove_image', 1, false, ['class' => 'form-check-input']) !!}
            {!! Form::label('remove_image', 'Remove current image', ['class' => 'form-check-label']) !!}
        </div>
    @endif
</div>

<div class="row" style="clear:both;">
    <div class="form-group col-md d-flex align-items-center">
            {!! Form::label('award_category_id', 'Category (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!}
            {!! Form::select('award_category_id', $categories, $award->award_category_id, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group col-md d-flex align-items-center">
            <div class="font-weight-bold">{!! Form::label('rarity', 'Rarity (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!}</div>
            {!! Form::number('rarity', $award && $award->rarity ? $award->rarity : '', ['class' => 'form-control']) !!}
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="form-group">
            {!! Form::label('reference_url', 'Reference Link (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!} {!! add_help('An optional link to an additional reference') !!}
            {!! Form::text('reference_url', $award->reference_url, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md">
    {!! Form::label('artist_id', 'Artist (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!} {!! add_help('Provide the artist\'s username if they are on site or, failing that, a link.') !!}
        <div class="row">
            <div class="col-md">
                <div class="form-group">
                    {!! Form::select('artist_id', $userOptions, $award && $award->artist_id ? $award->artist_id : null, ['class'=> 'form-control mr-2 selectize', 'placeholder' => 'Select a User']) !!}
                </div>
            </div>
            <div class="col-md">
                <div class="form-group">
                    {!! Form::text('artist_url', $award && $award->artist_url ? $award->artist_url : '', ['class' => 'form-control mr-2', 'placeholder' => 'Artist URL']) !!}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('description', 'Description (Optional)', ['class' => 'mb-0 font-weight-bold']) !!}
    {!! Form::textarea('description', $award->description, ['class' => 'form-control wysiwyg']) !!}
</div>

<div class="form-group d-md-flex align-items-center">
    {!! Form::label('release', 'Source (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!} {!! add_help('Where or how this award was earned.') !!}
    {!! Form::text('release', $award && $award->source ? $award->source : '', ['class' => 'ml-md-2 form-control']) !!}
</div>

<h3>Availability Information</h3>

<div class="row">
    <div class="col">
        <div class="form-group d-md-flex align-items-center">
            {!! Form::label('prompts[]', 'Drop Location(s) (Optional)', ['class' => 'mr-2 mb-0 font-weight-bold']) !!} {!! add_help('You can select up to 10 prompts at once.') !!}
            {!! Form::select('prompts[]', $prompts, $award && isset($award->data['prompts']) ? $award->data['prompts'] : '', ['id' => 'promptsList', 'class' => 'ml-md-2 form-control', 'multiple']) !!}
        </div>
    </div>
</div>

<div class="text-right">
    {!! Form::submit($award->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>

{!! Form::close() !!}


@if($award->id)
    <h3>Preview</h3>
    <div class="card mb-3">
        <div class="card-body">
            @include('world._award_entry', ['imageUrl' => $award->imageUrl, 'name' => $award->displayName, 'description' => $award->parsed_description, 'searchUrl' => $award->searchUrl])
        </div>
    </div>

@endif

@endsection

@section('scripts')
@parent
<script>
$( document ).ready(function() {
    $('.selectize').selectize();

    $('#promptsList').selectize({
        maxAwards: 10
    });

    $('.delete-award-button').on('click', function(e) {
        e.preventDefault();
        loadModal("{{ url('admin/data/awards/delete') }}/{{ $award->id }}", 'Delete Award');
    });
});

</script>
@endsection
