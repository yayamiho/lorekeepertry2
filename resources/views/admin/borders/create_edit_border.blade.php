@extends('admin.layout')

@section('admin-title')
    Borders
@endsection

@section('admin-content')
    {!! breadcrumbs([
        'Admin Panel' => 'admin',
        'Borders' => 'admin/data/borders',
        ($border->id ? 'Edit' : 'Create') . ' Border' => $border->id ? 'admin/data/borders/edit/' . $border->id : 'admin/data/borders/create',
    ]) !!}

    <h1>{{ $border->id ? 'Edit' : 'Create' }} Border
        @if ($border->id)
            <a href="#" class="btn btn-outline-danger float-right delete-border-button">Delete Border</a>
        @endif
    </h1>

    {!! Form::open([
        'url' => $border->id ? 'admin/data/borders/edit/' . $border->id : 'admin/data/borders/create',
        'files' => true,
    ]) !!}

    <h3>Basic Information</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Name') !!}
                {!! Form::text('name', $border->name, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Border Category (Optional)') !!}
                {!! Form::select('border_category_id', $categories, $border->border_category_id, ['class' => 'form-control']) !!}
            </div>
        </div>
    </div>

    <h3>Image</h3>
    <p>An image is required. You can't have a border with no image!</p>

    <div class="row">
        @if ($border->id)
            <div class="col-md-2">
                <div class="form-group">
                    <h5>Image</h5>
                    <img src="{{ $border->imageUrl }}" class="mw-100" style="width:125px; height:125px;" />
                    <br>
                </div>
                <div class="form-group">
                    <h5>In Action</h5>
                    {!! $border->preview() !!}
                    <br>
                </div>
            </div>
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Border Image') !!}
                <div>{!! Form::file('image') !!}</div>
                <div class="text-muted">Supports .png and .gif</div>
            </div>
            <div class="form-group">
                {!! Form::label('Border Style (Required)') !!}{!! add_help('Choose how the border will display around an icon. It can display over or under the user\'s icon.') !!}
                {!! Form::select('border_style', ['0' => 'Under', '1' => 'Over'], $border->border_style, [
                    'class' => 'form-control',
                    'placeholder' => 'Select a Type',
                ]) !!}
            </div>
        </div>
    </div>
    <h5>Second Layer</h5>
    <p>You can layer a second image here.</p>
    <p>This image always layers over the avatar.</p>
    <div class="row">
        @if ($border->has_layer)
            <div class="col-md-2">
                <div class="form-group">
                    <h5>Image</h5>
                    <img src="{{ $border->layerUrl }}" class="mw-100" style="width:125px; height:125px;" />
                    <br>
                </div>
            </div>
            <div class="form-check">
                {!! Form::checkbox('remove_layer_image', 1, false, ['class' => 'form-check-input']) !!}
                {!! Form::label('remove_layer_image', 'Remove current layer image', ['class' => 'form-check-label']) !!}
            </div>
        @endif
        <div class="col-md-6">
            <div class="form-group">
                {!! Form::label('Layer Image') !!}
                <div>{!! Form::file('layer_image') !!}</div>
                <div class="text-muted">Supports .png and .gif</div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::checkbox('is_default', 1, $border->is_default, [
                    'class' => 'form-check-input',
                    'data-toggle' => 'toggle',
                ]) !!}
                {!! Form::label('is_default', 'Default Border', ['class' => 'form-check-label ml-3']) !!} {!! add_help('If enabled, this border will be automatically available for any users.') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::checkbox('is_active', 1, $border->is_active, [
                    'class' => 'form-check-input',
                    'data-toggle' => 'toggle',
                ]) !!}
                {!! Form::label('is_active', 'Active?', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Users can\'t see or select this border if it isn\'t visible.') !!}
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::checkbox('admin_only', 1, $border->admin_only, [
                    'class' => 'form-check-input',
                    'data-toggle' => 'toggle',
                ]) !!}
                {!! Form::label('admin_only', 'Staff Only?', ['class' => 'form-check-label ml-3']) !!} {!! add_help('Only users who are staff can select this border if turned on.') !!}
            </div>
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('Description (Optional)') !!}
        {!! Form::textarea('description', $border->description, ['class' => 'form-control wysiwyg']) !!}
    </div>

    <div class="text-right">
        {!! Form::submit($border->id ? 'Edit' : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}

    @if ($border->id)
        <hr />
        <div class="card mb-3 p-4">
            <h2>Variants</h2>
            <p>These are the variations for this border. A user that owns this base border can switch between its variants for free.</p>
            <div class="card border-0">
                <div class="card-body">
                    <div class="text-right">
                        <a href="#" class="btn btn-primary" id="add-variant">Add Variant</a>
                    </div>
                    @if ($border->variants->count())
                        <div class="row">
                            @foreach ($border->variants as $variant)
                                <div class="col-md-3 col-6 text-center">
                                    <div class="shop-image">
                                        {!! $variant->preview() !!}
                                    </div>
                                    <div class="shop-name mt-1 text-center">
                                        <h5>{!! $variant->name !!}</h5>
                                        <a href="#" class="btn btn-sm btn-primary edit-variant" data-id="{{ $variant->id }}"><i class="fas fa-cog mr-1"></i>Edit</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">No variants found.</div>
                    @endif
                </div>
            </div>
        </div>
        <h3>Preview</h3>
        <div class="card mb-3">
            <div class="card-body">
                @include('world._border_entry', ['border' => $border])
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function() {
            $('.selectize').selectize();
            $('.delete-border-button').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/borders/delete') }}/{{ $border->id }}", 'Delete Border');
            });
            $('#add-variant').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/borders/edit/' . $border->id . '/variants/create') }}", 'Create Variant');
            });

            $('.edit-variant').on('click', function(e) {
                e.preventDefault();
                loadModal("{{ url('admin/data/borders/edit/' . $border->id . '/variants/edit') }}/" + $(this).data('id'), 'Edit Variant');
            });
        });
    </script>
@endsection
