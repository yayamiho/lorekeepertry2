<?php

namespace App\Models\Cultivation;

use Illuminate\Database\Eloquent\Model;

class UserPlot extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'plot_id', 'item_id', 'user_area_id', 'stage', 'tended_at'
    ];

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_plot';

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the attachers.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User\User', 'user_id');
    }

    /**
     * Get the attachers.
     */
    public function userArea()
    {
        return $this->belongsTo('App\Models\Cultivation\UserArea', 'user_area_id');
    }

    /**
     * Get the planted item.
     */
    public function item()
    {
        return $this->belongsTo('App\Models\Item\Item', 'item_id');
    }

    /**
     * Get the plot.
     */
    public function plot()
    {
        return $this->belongsTo('App\Models\Cultivation\CultivationPlot', 'plot_id');
    }


    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/


}
