
@isset($design)
<style>
/**
Sets the font for all your headers
*/
h1, h2, h3, h4, h5,
.h1, .h2, .h3, .h4, .h5 {
    font-family:{{ $design->heading_font_family }} !important; 
    letter-spacing: {{ $design->heading_letter_spacing }}px !important;
    text-transform: {{ $design->heading_text_transform }} !important; 
    font-weight: {{ $design->heading_font_weight }} !important;
}

/**
Sets the font for the navbar up top + nav tabs
*/
.navbar .navbar-brand, .navbar .nav-item, .nav-tabs .nav-link {
    font-family: {{ $design->navigation_font_family }} !important;
    letter-spacing: {{ $design->navigation_letter_spacing }}px !important; 
    text-transform: {{ $design->navigation_text_transform }} !important;
    font-weight: {{ $design->navigation_font_weight }} !important;
}

/**
Sets the font for the sidebars
*/
.sidebar .sidebar-header, .sidebar .sidebar-section .sidebar-section-header, .sidebar a {
    font-family: {{ $design->sidebar_font_family }} !important;
    letter-spacing: {{ $design->sidebar_letter_spacing }}px !important; 
    text-transform: {{ $design->sidebar_text_transform }} !important;
    font-weight: {{ $design->sidebar_font_weight }} !important;
}

/**
Sets the font for all text on site/main text font
*/
body {
    font-family: {{ $design->body_font_family }} !important;
    letter-spacing: {{ $design->body_letter_spacing }}px !important; 
    text-transform: {{ $design->body_text_transform }} !important;
    font-weight: {{ $design->body_font_weight }} !important;
}
</style>
@endisset