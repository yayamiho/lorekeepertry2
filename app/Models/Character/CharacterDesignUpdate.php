<?php

namespace App\Models\Character;

use Config;
use DB;
use App\Models\Model;
use App\Models\Currency\Currency;
use App\Models\User\UserItem;
use App\Models\Feature\FeatureCategory;
use App\Models\Feature\Feature;
use Illuminate\Database\Eloquent\SoftDeletes;

class CharacterDesignUpdate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'character_id', 'status', 'user_id', 'staff_id',
        'comments', 'staff_comments', 'data', 'extension',
        'use_cropper', 'x0', 'x1', 'y0', 'y1',
        'hash', 'species_id', 'subtype_id', 'rarity_id',
        'has_comments', 'has_image', 'has_addons', 'has_features',
        'submitted_at', 'update_type', 'fullsize_hash', 
        'approval_votes', 'rejection_votes'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'design_updates';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Dates on the model to convert to Carbon instances.
     *
     * @var array
     */
    public $dates = ['submitted_at'];

    /**
     * Validation rules for uploaded images.
     *
     * @var array
     */
    public static $imageRules = [
        'image' => 'nullable|mimes:jpeg,gif,png',
        'thumbnail' => 'nullable|mimes:jpeg,gif,png',
        'artist_url.*' => 'nullable|url',
        'designer_url.*' => 'nullable|url'
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the character associated with the design update.
     */
    public function character()
    {
        return $this->belongsTo('App\Models\Character\Character', 'character_id');
    }

    /**
     * Get the user who created the design update.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'user_id');
    }

    /**
     * Get the staff who processed the design update.
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\User\User', 'staff_id');
    }

    /**
     * Get the species of the design update.
     */
    public function species()
    {
        return $this->belongsTo('App\Models\Species\Species', 'species_id');
    }

    /**
     * Get the subtype of the design update.
     */
    public function subtype()
    {
        return $this->belongsTo('App\Models\Species\Subtype', 'subtype_id');
    }

    /**
     * Get the rarity of the design update.
     */
    public function rarity()
    {
        return $this->belongsTo('App\Models\Rarity', 'rarity_id');
    }

    /**
     * Get the features (traits) attached to the design update, ordered by display order.
     */
    public function features()
    {
        $ids = FeatureCategory::orderBy('sort', 'DESC')->pluck('id')->toArray();

        $query = $this->hasMany('App\Models\Character\CharacterFeature', 'character_image_id')->where('character_features.character_type', 'Update')->join('features', 'features.id', '=', 'character_features.feature_id')->select(['character_features.*', 'features.*', 'character_features.id AS character_feature_id']);

        return count($ids) ? $query->orderByRaw(DB::raw('FIELD(features.feature_category_id, '.implode(',', $ids).')')) : $query;
    }

    /**
     * Get the features (traits) attached to the design update with no extra sorting.
     */
    public function rawFeatures()
    {
        return $this->hasMany('App\Models\Character\CharacterFeature', 'character_image_id')->where('character_features.character_type', 'Update');
    }

    /**
     * Get the designers attached to the design update.
     */
    public function designers()
    {
        return $this->hasMany('App\Models\Character\CharacterImageCreator', 'character_image_id')->where('type', 'Designer')->where('character_type', 'Update');
    }

    /**
     * Get the artists attached to the design update.
     */
    public function artists()
    {
        return $this->hasMany('App\Models\Character\CharacterImageCreator', 'character_image_id')->where('type', 'Artist')->where('character_type', 'Update');
    }

    /**********************************************************************************************

        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to only include active (Open or Pending) update requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'Approved')->where('status', '!=', 'Rejected');
    }

    /**
     * Scope a query to only include MYO slot approval requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMyos($query)
    {
        $query->select('design_updates.*')->where('update_type', 'MYO');
    }

    /**
     * Scope a query to only include character design update requests.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCharacters($query)
    {
        $query->select('design_updates.*')->where('update_type', 'Character');
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Get the data attribute as an associative array.
     *
     * @return array
     */
    public function getDataAttribute()
    {
        return json_decode($this->attributes['data'], true);
    }

    /**
     * Get the items (UserItem IDs) attached to this update request.
     *
     * @return array
     */
    public function getInventoryAttribute()
    {
        // This is for showing the addons page
        // just need to retrieve a list of stack IDs to tell which ones to check

        return $this->data && isset($this->data['user']['user_items']) ? $this->data['user']['user_items'] : [];
    }

    /**
     * Get the user-owned currencies attached to this update request.
     *
     * @return array
     */
    public function getUserBankAttribute()
    {
        return $this->data && isset($this->data['user']['currencies']) ? $this->data['user']['currencies'] : [];
    }

    /**
     * Get the character-owned currencies attached to this update request.
     *
     * @return array
     */
    public function getCharacterBankAttribute()
    {
        return $this->data && isset($this->data['character']['currencies']) ? $this->data['character']['currencies'] : [];
    }

    /**
     * Check if all sections of the form have been touched.
     *
     * @return bool
     */
    public function getIsCompleteAttribute()
    {
        return ($this->has_comments && $this->has_image && $this->has_addons && $this->has_features);
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute()
    {
        return 'images/character-updates/'.floor($this->id / 1000);
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getImageFileNameAttribute()
    {
        return $this->id . '_'.$this->hash.'.'.$this->extension;
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
        return asset($this->imageDirectory . '/' . $this->imageFileName);
    }

    /**
     * Gets the file name of the model's thumbnail image.
     *
     * @return string
     */
    public function getThumbnailFileNameAttribute()
    {
        return $this->id . '_'.$this->hash.'_th.'.$this->extension;
    }

    /**
     * Gets the path to the file directory containing the model's thumbnail image.
     *
     * @return string
     */
    public function getThumbnailPathAttribute()
    {
        return $this->imagePath;
    }

    /**
     * Gets the URL of the model's thumbnail image.
     *
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return asset($this->imageDirectory . '/' . $this->thumbnailFileName);
    }

    /**
     * Gets the URL of the design update request.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('designs/'.$this->id);
    }

    /**
     * Gets the voting data of the design update request.
     *
     * @return string
     */
    public function getVoteDataAttribute()
    {
        return collect(json_decode($this->attributes['vote_data'], true));
    }

    /**********************************************************************************************

        OTHER FUNCTIONS

    **********************************************************************************************/

    /**
     * Get the available currencies that the user can attach to this update request.
     *
     * @param  string  $type
     * @return array
     */
    public function getBank($type)
    {
        if($type == 'user') $currencies = $this->userBank;
        else $currencies = $this->characterBank;
        if(!count($currencies)) return [];
        $ids = array_keys($currencies);
        $result = Currency::whereIn('id', $ids)->get();
        foreach($result as $i=>$currency)
        {
            $currency->quantity = $currencies[$currency->id];
        }
        return $result;
    }

    /**
     * Check if trait is within the attached items.
     *
     * @param  string  $type
     * @return array
     */
    public function isAttachedOrOnCharacter($featureId)
    {
        $addedItems = UserItem::whereIn('id', array_keys($this->inventory))->get();
        $featureIds = $addedItems->filter(function ($userItem) {
            return $userItem->item->hasTag('trait');
        })->map(function ($userItem) {
            return $userItem->item->tag('trait')->getData();
        })->flatten();

        $characterFeatures = $this->character->image->features->pluck('id') ?? [];
        
        if($featureIds->contains($featureId) || ($characterFeatures->contains($featureId))){
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all attached traits.
     *
     * @param  string  $type
     * @return array
     */
    public function getAttachedTraitIds()
    {
        $addedItems = UserItem::whereIn('id', array_keys($this->inventory))->get();
        $featureIds = $addedItems->filter(function ($userItem) {
            return $userItem->item->hasTag('trait');
        })->map(function ($userItem) {
            return $userItem->item->tag('trait')->getData();
        })->flatten()->toArray();

        return $featureIds;
    }

    /**
     * Gets the trait list based on attached trait items.
     *
     * @param  string  $type
     * @return array
     */
    public function getAttachedTraitSelect()
    {
        $selects = [];
        $addedItems = UserItem::whereIn('id', array_keys($this->inventory))->get();
        foreach($addedItems as $userItem){
            if($userItem->item->hasTag('trait')){
                $features = Feature::whereIn('id', $userItem->item->tag('trait')->getData());
                $alreadyAddedFeatures = $this->features->whereIn('feature_id', $userItem->item->tag('trait')->getData());
                $amount = $this->inventory[$userItem->id] - $alreadyAddedFeatures->count();
                //add the select for each item
                if($amount > 0){
                    foreach(range(1,$amount) as $i){
                        $choices = $features->whereNotIn('id', $alreadyAddedFeatures->pluck('id'))->orderBy('name')->pluck('name', 'id')->toArray();
                        if(count($choices) > 0) $selects[] = $features->whereNotIn('id', $alreadyAddedFeatures->pluck('id'))->orderBy('name')->pluck('name', 'id')->toArray();
                    }
                }
            }
        }
        return $selects;
    }

    /**
     * Checks if a trait remover item was added to this request, allowing users to remove traits that are not set via item.
     *
     * @param  string  $type
     * @return array
     */
    public function canRemoveTrait($feature)
    {
        $addedItems = UserItem::whereIn('id', array_keys($this->inventory))->get();
        $featureIds = $addedItems->filter(function ($userItem) {
            return $userItem->item->hasTag('trait');
        })->map(function ($userItem) {
            return $userItem->item->tag('trait')->getData();
        });
        
        $traitRemover = $addedItems->filter(function ($userItem) {
            return $userItem->item->hasTag('trait_remover');
        })->first();

        if(isset($traitRemover) && !$featureIds->contains($feature->id)){
            return true;
        } else {
            return false;
        }
    }
}
