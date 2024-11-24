<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<div class="row justify-content-center">
    <div class="row" style=" margin-bottom:10px; width:99%">
    @include('widgets._carousel')

    </div>
    <div class="row" style=" margin-bottom:10px; width:99%">
        @include('widgets._news', ['textPreview' => true])

        @include('widgets._sales')
    </div>
</div>

    @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
