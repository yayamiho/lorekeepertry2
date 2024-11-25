<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<div class="row justify-content-center">
    <div class="row" style=" margin-bottom:10px; width:99%">
    @include('widgets._carousel')

    </div>
    <div class="row" style=" width:99%">
        @include('widgets._news', ['textPreview' => true])

        @include('widgets._sales')
    </div>
    
    <div class="row" style=" margin-top:-10px; width:99%; display:flex; justify-content:space-around">
        <img class="dashboard-button" src="https://placehold.co/486x133" alt="">
        <img class="dashboard-button" src="https://placehold.co/486x133" alt="">
    </div>
</div>

    @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
