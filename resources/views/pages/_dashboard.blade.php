<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<div class="row justify-content-center">
    <div class="row" style=" margin-bottom:10px">
        <div class="col-md-12">
            @include('widgets._carousel')
        </div>

    </div>
    <div class="row" style=" margin-bottom:10px">
    </div>


    <div class="row">
        @include('widgets._news', ['textPreview' => true])
    </div>

    @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
