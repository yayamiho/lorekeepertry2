<?php

namespace App\Models\Award;

use Config;
use DB;
use App\Models\Model;
use App\Models\Award\AwardCategory;

use App\Models\User\User;
use App\Models\Shop\Shop;
use App\Models\Prompt\Prompt;

class Award extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'award_category_id', 'name', 'has_image', 'description', 'parsed_description',
        'data', 'is_released', 'is_featured', 'is_user_owned', 'is_character_owned',
        'user_limit', 'character_limit', 'allow_transfer', 'extension',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'awards';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'credits' => 'array'
    ];

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'award_category_id' => 'nullable',
        'name' => 'required|unique:awards|between:3,100',
        'description' => 'nullable',
        'image' => 'mimes:png,jpeg,jpg,gif',
        'rarity' => 'nullable',
        'uses' => 'nullable|between:3,250',
        'release' => 'nullable|between:3,100'
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'award_category_id' => 'nullable',
        'name' => 'required|between:3,100',
        'description' => 'nullable',
        'image' => 'mimes:png,jpeg,jpg,gif',
        'uses' => 'nullable|between:3,250',
        'release' => 'nullable|between:3,100'
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the category the award belongs to.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Award\AwardCategory', 'award_category_id');
    }


    /**********************************************************************************************

        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to sort awards in alphabetical order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool                                   $reverse
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortAlphabetical($query, $reverse = false)
    {
        return $query->orderBy('name', $reverse ? 'DESC' : 'ASC');
    }

    /**
     * Scope a query to sort awards in category order.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortCategory($query)
    {
        if(AwardCategory::all()->count()) return $query->orderBy(AwardCategory::select('sort')->whereColumn('awards.award_category_id', 'award_categories.id'), 'DESC');
        return $query;
    }

    /**
     * Scope a query to sort awards by newest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortNewest($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    /**
     * Scope a query to sort features oldest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortOldest($query)
    {
        return $query->orderBy('id');
    }

    /**
     * Scope a query to show only released or "released" (at least one user-owned stack has ever existed) items.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeReleased($query)
    {
        $users = UserAward::pluck('award_id')->toArray();
        $characters = CharacterAward::pluck('award_id')->toArray();
        $array = array_merge($users, $characters);
        return $query->whereIn('id', $array)->orWhere('is_released', 1);
    }


    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the model's name, linked to its encyclopedia page.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return '<a href="'.$this->url.'" class="display-award">'.$this->name.'</a>';
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/data/awards';
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->id . '-image.' . $this->extension;
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getImagePathAttribute()
    {
        return public_path($this->imageDirectory);
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        if (!$this->has_image) return null;
        return asset($this->imageDirectory . '/' . $this->imageFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('world/awards?name='.$this->name);
    }

    /**
     * Gets the URL of the individual award's page, by ID.
     *
     * @return string
     */
    public function getIdUrlAttribute()
    {
        return url('world/awards/'.$this->id);
    }

    /**
     * Gets the currency's asset type for asset management.
     *
     * @return string
     */
    public function getAssetTypeAttribute()
    {
        return 'awards';
    }

    // /**
    //  * Get the artist of the award's image.
    //  *
    //  * @return string
    //  */
    // public function getAwardArtistAttribute()
    // {
    //     if(!$this->artist_url && !$this->artist_id) return null;

    //     // Check to see if the artist exists on site
    //     $artist = checkAlias($this->artist_url, false);
    //     if(is_object($artist)) {
    //         $this->artist_id = $artist->id;
    //         $this->artist_url = null;
    //         $this->save();
    //     }

    //     if($this->artist_id)
    //     {
    //         return $this->artist->displayName;
    //     }
    //     else if ($this->artist_url)
    //     {
    //         return prettyProfileLink($this->artist_url);
    //     }
    // }
    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getDataAttribute()
    {
        if (!$this->id) return null;
        return json_decode($this->attributes['data'], true);
    }

    public function getCreditsAttribute(){
        return $this->data['credits'];
    }

    /**
     * Get the rarity attribute.
     *
     * @return string
     */
    public function getRarityAttribute()
    {
        if (!$this->data) return null;
        return $this->data['rarity'];
    }

    /**
     * Get the uses attribute.
     *
     * @return string
     */
    public function getUsesAttribute()
    {
        if (!$this->data) return null;
        return $this->data['uses'];
    }

    /**
     * Get the source attribute.
     *
     * @return string
     */
    public function getSourceAttribute()
    {
        if (!$this->data) return null;
        return $this->data['release'];
    }

    /**
     * Get the prompts attribute as an associative array.
     *
     * @return array
     */
    public function getPromptsAttribute()
    {
        if (!$this->data) return null;
        $awardPrompts = $this->data['prompts'];
        return Prompt::whereIn('id', $awardPrompts)->get();
    }

    /**********************************************************************************************

        OTHER FUNCTIONS

    **********************************************************************************************/

}
