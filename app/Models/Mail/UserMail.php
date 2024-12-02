<?php

namespace App\Models\Mail;

use App\Models\Model;
use App\Models\User\User;

class UserMail extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recipient_id', 'subject', 'message', 'seen', 'parent_id',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_mails';

    /**
     * Whether the model contains timestamps to be saved and updated.
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Validation rules for creation.
     *
     * @var array
     */
    public static $createRules = [
        'subject'   => 'required|between:3,100',
        'message'   => 'required',
        'parent_id' => 'nullable',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the staff that sent the message.
     */
    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who was sent the message.
     */
    public function recipient() {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    /**
     * Get the parent message.
     */
    public function parent() {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the child messages.
     */
    public function children() {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the message subject, linked to the message itself.
     *
     * @return string
     */
    public function getDisplayNameAttribute() {
        return '<a href="'.$this->url.'">'.$this->subject.'</a>';
    }

    /**
     * Gets the message URL.
     *
     * @return string
     */
    public function getViewUrlAttribute() {
        return url('mail/view/'.$this->id);
    }
}
