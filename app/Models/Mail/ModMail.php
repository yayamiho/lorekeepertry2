<?php

namespace App\Models\Mail;

use App\Models\Model;
use App\Models\User\User;
use App\Traits\Commentable;
use Illuminate\Support\Facades\Auth;

class ModMail extends Model {
    use Commentable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id', 'user_id', 'subject', 'message', 'issue_strike', 'strike_count', 'previous_strike_count', 'seen',
        'strike_expiry', 'has_expired',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mod_mails';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'strike_expiry' => 'datetime',
    ];

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
        'subject' => 'required|between:3,100',
        'message' => 'required',
    ];

    /**********************************************************************************************

        RELATIONS

    **********************************************************************************************/

    /**
     * Get the staff that sent the message.
     */
    public function staff() {
        return $this->belongsTo(User::class, 'staff_id');
    }

    /**
     * Get the user who was sent the message.
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**********************************************************************************************

        ACCESSORS

    **********************************************************************************************/

    /**
     * Displays the news post title, linked to the news post itself.
     *
     * @return string
     */
    public function getDisplayNameAttribute() {
        return '<a href="'.$this->url.'">'.$this->subject.'</a>';
    }

    /**
     * Gets the news post URL.
     *
     * @return string
     */
    public function getViewUrlAttribute() {
        if (Auth::user()->id != $this->recipient_id || Auth::user()->id == $this->user_id) {
            return url('admin/mail/view/'.$this->id);
        }

        return url('inbox/view/'.$this->id);
    }
}
