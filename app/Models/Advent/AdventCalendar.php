<?php

namespace App\Models\Advent;

use Config;
use DB;
use Carbon\Carbon;
use App\Models\Model;

class AdventCalendar extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'summary', 'start_at', 'end_at', 'data'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'advent_calendars';

    /**
     * Dates on the model to convert to Carbon instances.
     *
     * @var array
     */
    public $dates = ['start_at', 'end_at'];

    /**
     * Validation rules for advent calendar creation.
     *
     * @var array
     */
    public static $createRules = [
        'name' => 'required|unique:advent_calendars|between:3,50',
        'display_name' => 'required|between:3,40',
        'summary' => 'nullable',
    ];

    /**
     * Validation rules for advent calendar updating.
     *
     * @var array
     */
    public static $updateRules = [
        'name' => 'required|between:3,50',
        'display_name' => 'required|between:3,40',
        'summary' => 'nullable',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the participation logs attached to this advent calendar.
     */
    public function participants()
    {
        return $this->hasMany('App\Models\Advent\AdventParticipant', 'advent_id');
    }

    /**********************************************************************************************

        SCOPES

    **********************************************************************************************/

    /**
     * Scope a query to only include active advents.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(function($query) {
            $query->whereNull('start_at')->orWhere('start_at', '<', Carbon::now())->orWhere(function($query) {
                $query->where('start_at', '>=', Carbon::now());
            });
        })->where(function($query) {
                $query->whereNull('end_at')->orWhere('end_at', '>', Carbon::now())->orWhere(function($query) {
                    $query->where('end_at', '<=', Carbon::now());
                });
        });

    }

    /**
     * Scope a query to sort advent calendars in alphabetical order.
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
     * Scope a query to sort advent calendars by newest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortNewest($query)
    {
        return $query->orderBy('id', 'DESC');
    }

    /**
     * Scope a query to sort advent calendars oldest first.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortOldest($query)
    {
        return $query->orderBy('id');
    }

    /**
     * Scope a query to sort advent calendars by start date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool                                   $reverse
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortStart($query, $reverse = false)
    {
        return $query->orderBy('start_at', $reverse ? 'DESC' : 'ASC');
    }

    /**
     * Scope a query to sort advent calendars by end date.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  bool                                   $reverse
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortEnd($query, $reverse = false)
    {
        return $query->orderBy('end_at', $reverse ? 'DESC' : 'ASC');
    }

    /**
     * Scope a query to get participants of a particular advent calendar.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParticipants($query)
    {
        $query->select('advent_participants.*')->where('advent_id', $this->id);
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the model's name.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return $this->attributes['display_name'];
    }

    /**
     * Displays the model's name, linked to its page.
     *
     * @return string
     */
    public function getDisplayLinkAttribute()
    {
        return '<a href="'.$this->url.'" class="display-prompt">'.$this->attributes['display_name'].'</a>';
    }

    /**
     * Gets the URL of the model's page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('advent-calendars/'.$this->id);
    }

    /**
     * Check if the advent calendar is active or not.
     *
     * @return string
     */
    public function getIsActiveAttribute()
    {
        if($this->start_at <= Carbon::now() && $this->end_at >= Carbon::now())
            return TRUE;
        else
            return FALSE;

    }

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

}
