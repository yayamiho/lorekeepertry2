<h1>Welcome, {!! Auth::user()->displayName !!}!</h1>

<div class="row justify-content-center">
    <div class="row" style=" margin-bottom:10px; width:99%">
    @include('widgets._carousel')

    </div>
    <div class="row newsSales" style=" width:99%">
        @include('widgets._news', ['textPreview' => true])

        @include('widgets._sales')
    </div>

    <div class="row newsSeparateSales" style=" width:99%">
        @include('widgets._news', ['textPreview' => true])
    </div>
    <div class="row newsSeparateSales" style=" width:99%">
        @include('widgets._sales')
    </div>
    
    <div class="row" style=" margin-top:-15px; width:99%; display:flex; justify-content:space-around">
        <img class="dashboard-button" src="/images/discord.png" alt="">
        <img class="dashboard-button" src="/images/supporter.png" alt="">
    </div>
</div>

    @include('widgets._recent_gallery_submissions', ['gallerySubmissions' => $gallerySubmissions])
