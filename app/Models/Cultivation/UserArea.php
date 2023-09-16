<?php

namespace App\Models\Cultivation;

use Illuminate\Database\Eloquent\Model;

class UserArea extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'area_id'
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
    protected $table = 'user_area';

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
    public function area()
    {
        return $this->belongsTo('App\Models\Cultivation\CultivationArea', 'area_id');
    }



    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/


}
