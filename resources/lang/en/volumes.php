<?php

return [

    /*
    / --------------------------------------------------------------------------
    / Volumes Extension Language Lines
    / --------------------------------------------------------------------------
    /
    / Note that if you adjust anything in here, you WILL NEED to adjust them
    / manually in any config file, specifically config/lorekeeper/notifications.
    / You can optionally also modify them in config/lorekeeper/admin_sidebar but
    / as that is admin-facing only, that isn't as important.
    /
    / If your text has more than one word (like "award case" for instance),
    / it *may* cause issues in loading pages.
    /
    */

    'book' => 'book',                         // use __
    'books' => 'books',                       // use __
    'books_' => 'book|books',                // Use trans_choice instead of __

    
    'volume' => 'volume',                         // use __
    'volumes' => 'volumes',                       // use __
    'volumes_' => 'volume|volumes',                // Use trans_choice instead of __

    'library' => 'library',                 // use __
    'libraries' => 'libraries',               // use __
    'libraries_' => 'library|libraries',    // Use trans_choice instead of __

    'bookshelf' => 'bookshelf',                         // use __
    'bookshelves' => 'bookshelves',                       // use __
    'bookshelves_' => 'bookshelf|bookshelves',                // Use trans_choice instead of __

];