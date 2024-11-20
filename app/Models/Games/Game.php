<?php
namespace App\Models\Game;
use App\Models\Model;

class Game extends Model{
    protected $fillable=[
        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        'name', 'user_id', 'sort', 'has_image', 'description', 'parsed_description', 'is_active', 'hash', 'is_staff', 'is_timed_game', 'start_at', 'end_at', 'score', 'score_ratio', 'currency_ratio'
    ];

    protected $table = 'games';

    /**
     * Validation rules for creation.
     */
    public static $createRules = [
        'name'        => 'required|unique:item_categories|between:3,100',
        'description' => 'nullable',
        'image'       => 'mimes:png',
        'score_ratio'   => 'nullable|integer|min:1',
        'currency_ratio'    => 'nullable|integer|min:1',
    ];

    /**
     * Validation rules for updating.
     *
     * @var array
     */
    public static $updateRules = [
        'name'        => 'required|between:3,100',
        'description' => 'nullable',
        'image'       => 'mimes:png',
        'score_ratio'   => 'nullable|integer|min:1',
        'currency_ratio'    => 'nullable|integer|min:1',
    ];

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the shop's name, linked to its purchase page.
     *
     * @return string
     */
    public function getDisplayNameAttribute() {
        return '<a href="'.$this->url.'" class="display-shop">'.$this->name.'</a>';
    }

    /**
     * Gets the file directory containing the model's image.
     *
     * @return string
     */
    public function getImageDirectoryAttribute() {
        return 'images/data/games';
    }

    /**
     * Gets the file name of the model's image.
     *
     * @return string
     */
    public function getGameImageFileNameAttribute() {
        return $this->hash.$this->id.'-image.png';
    }

    /**
     * Gets the path to the file directory containing the model's image.
     *
     * @return string
     */
    public function getGameImagePathAttribute() {
        return public_path($this->imageDirectory);
    }

    /**
     * Gets the URL of the model's image.
     *
     * @return string
     */
    public function getGameImageUrlAttribute() {
        if (!$this->has_image) {
            return null;
        }

        return asset($this->imageDirectory.'/'.$this->shopImageFileName);
    }

    /**
     * Gets the URL of the model's encyclopedia page.
     *
     * @return string
     */
    public function getUrlAttribute() {
        return url('games/'.$this->id);
    }

}