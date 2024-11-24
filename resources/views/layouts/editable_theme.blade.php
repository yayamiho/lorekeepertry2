@php
    $titleColor = $theme->themeEditor->title_color ?? null;
    $navBarColor = $theme->themeEditor->nav_color ?? null; 
    $navTextColor  = $theme->themeEditor->nav_text_color ?? null; 

    $headerImageDisplay = $theme->themeEditor->header_image_display ?? null;
    $headerImage = $theme->header_image_url ?? null; 
    $headerSize = $theme->themeEditor->header_size ?? null; 

    $logoImageDisplay = $theme->themeEditor->logo_image_display ?? null;
    $logoImage = $theme->logo_image_url ?? null; 

    $backgroundColor = $theme->themeEditor->background_color ?? null;
    $backgroundImage = $theme->backgroundImageUrl ?? null; 
    $backgroundSize = $theme->themeEditor->background_size ?? null; 

    $mainMarginTop = ($headerImageDisplay == 'none') ? 50 : 0;
    $mainColor = $theme->themeEditor->main_color ?? null;  
    $mainTextColor = $theme->themeEditor->main_text_color ?? null; 

    $cardColor = $theme->themeEditor->card_color ?? null;  
    $cardTextColor = $theme->themeEditor->card_text_color ?? null;  
    $cardHeaderColor = $theme->themeEditor->card_header_color ?? null;  
    $cardHeaderTextColor = $theme->themeEditor->card_header_text_color ?? null;  

    $sidebarSectionHeaderColor = $theme->themeEditor->sidebar_section_header_color ?? null;  
    $sidebarTextColor = $theme->themeEditor->sidebar_text_color ?? null; 
    $sidebarHeaderTextColor = $theme->themeEditor->sidebar_header_text_color ?? null; 
    $sidebarBorderDisplay = $theme->themeEditor->sidebar_border ?? null;
    $sidebarBorderColor = $theme->themeEditor->sidebar_border_color ?? null;

    $linkColor = $theme->themeEditor->link_color ?? null;  
    $primaryButtonColor = $theme->themeEditor->primary_button_color ?? null;  
    $secondaryButtonColor = $theme->themeEditor->secondary_button_color ?? null;
@endphp

<style>

/** Style the site header and nav */
.site-header-image{
    @if($headerImageDisplay) display: {{ $headerImageDisplay }}; @endif
    @if($headerImage) background-image: url('{{ $headerImage }}')!important; @endif
    @if($headerSize) background-size: 100% {{ $headerSize }} !important; @endif
}
/** Style logo */
.site-header-image #logo{
    @if($logoImageDisplay) display: {{ $logoImageDisplay }}; @endif
    @if ($logoImage) content: url('{{ $logoImage }}'); @endif
}

.bg-dark, .sidebar .sidebar-header, .sidebar a.active, .sidebar a.active:hover {
    @if($navBarColor) background-color: {{ $navBarColor }} !important; @endif
    @if($navTextColor) color: {{ $navTextColor }} !important; @endif
}

@if($navTextColor)
    .dropdown-item:hover, .sidebar a:hover, .sidebar a:active, .selectize-dropdown .active {
    filter: brightness(115%);
    }
@endif

.navbar-dark .navbar-nav .nav-link {
    @if($navTextColor) color: {{ $navTextColor }} !important; @endif
}

.navbar-brand {
    @if($titleColor) color: {{ $titleColor }} !important; @endif
}

@media (max-width: 991px) {
    .site-header-image {
        display: none;
    }
}

/** Style card header */

.card-header {
    @if($cardHeaderColor) background-color: {{ $cardHeaderColor }} !important; @endif
}

.card-header .card-title a, .card-header .card-title, .card-header a {
    @if($cardHeaderTextColor) color: {{ $cardHeaderTextColor }} !important; @endif
}

/** Style sidebar */

.sidebar-section-header {
    @if($sidebarSectionHeaderColor) background-color: {{ $sidebarSectionHeaderColor }} !important; @endif
}

.sidebar a, .sidebar-section-header {
    @if($sidebarTextColor) color: {{ $sidebarTextColor }} !important; @endif
}

.sidebar-header a {
    @if($sidebarHeaderTextColor) color: {{$sidebarHeaderTextColor}} !important; @endif
}

.sidebar ul li {
    @if($sidebarBorderDisplay) border-style: {{$sidebarBorderDisplay}}; @endif
    @if($sidebarBorderColor) border-color: {{$sidebarBorderColor}}; @endif
}

/** Style main background */

#app {
    @if($backgroundImage) background-image: url('{{ $backgroundImage }}'); @endif
    @if($backgroundColor) background-color: {{ $backgroundColor }} !important; @endif
    @if($backgroundSize)
     background-size: 100% {{ $backgroundSize }} !important; 
     background-attachment:fixed;
    @endif
    background-repeat: repeat;
}


/** Style &buttons */

.btn-primary, .page-item.active .page-link {
    @if($primaryButtonColor) background-color: {{ $primaryButtonColor }} !important; @endif
    @if($primaryButtonColor) border-color: {{ $primaryButtonColor }} !important; @endif
}

.btn-secondary {
    @if($secondaryButtonColor) background-color: {{ $secondaryButtonColor }} !important; @endif
    @if($secondaryButtonColor) border-color: {{ $secondaryButtonColor }} !important; @endif
}


/** Style the main content + sidebars and make links/forms/cards fit. This part gets commented out if a css theme is used! */
.main-content, .sidebar {
    @if($mainMarginTop) margin-top: {{ $mainMarginTop }}px; @endif
}

.main-content, .modal-content, 
.sidebar-section, .sidebar-item, .sidebar a:hover, .sidebar a:active, 
option:hover, .form-control, .selectize-input, .selectize-dropdown .active, 
::placeholder, .breadcrumb-item, 
.dropdown-item:hover, .dropdown-item, .dropdown-menu, #tinymce {
    @if($mainColor) background-color: {{ $mainColor }} !important; @endif
    @if($mainTextColor) color: {{ $mainTextColor }} !important; @endif
}

.card, .list-group-item, .nav-tabs .active {
    @if($cardColor) background-color: {{ $cardColor }} !important; @endif
    @if($cardTextColor) color: {{ $cardTextColor }} !important; @endif
}

a:not(.btn, .navbar-brand, .card-link, .dropdown-item):not(.sidebar-item > a), a strong, .text-muted {
    @if($linkColor) color: {{ $linkColor }} !important; @endif
}

</style>

