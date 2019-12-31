<?php

namespace App\Models\Item;

use Config;
use App\Models\Model;

class ItemLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recipient_id', 
        'log', 'log_type', 'data',
        'item_id', 'quantity', 'stack_id'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_items_log';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**********************************************************************************************
    
        RELATIONS

    **********************************************************************************************/

    /**
     * Get the user who initiated the logged action.
     */
    public function sender() 
    {
        return $this->belongsTo('App\Models\User\User', 'sender_id');
    }

    /**
     * Get the user who received the logged action.
     */
    public function recipient() 
    {
        return $this->belongsTo('App\Models\User\User', 'recipient_id');
    }

    /**
     * Get the item that is the target of the action.
     */
    public function item() 
    {
        return $this->belongsTo('App\Models\Item\Item');
    }
}