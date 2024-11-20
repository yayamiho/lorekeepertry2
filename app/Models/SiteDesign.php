<?php

namespace App\Models;

use Carbon\Carbon;
use Config;
use App\Models\Model;


use App\Traits\Commentable;

class SiteDesign extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'design', 
        'heading_font_family', 'heading_letter_spacing', 'heading_text_transform', 'heading_font_weight',
        'navigation_font_family', 'navigation_letter_spacing', 'navigation_text_transform', 'navigation_font_weight',
        'sidebar_font_family', 'sidebar_letter_spacing', 'sidebar_text_transform', 'sidebar_font_weight',
        'body_font_family', 'body_letter_spacing', 'body_text_transform', 'body_font_weight'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site_design';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = false;


    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'design' => 'required|between:3,100',
    ];
    
    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'design' => 'required|between:3,100',
    ];


    /**********************************************************************************************
    
        ACCESSORS

    **********************************************************************************************/


}
