<?php

namespace App\Models\Volume;

use App\Models\Character\Character;
use App\Models\Model;
use App\Models\User\User;

class BookAuthor extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'book_id', 'author_type', 'author', 'credit_type',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'book_authors';

    /**********************************************************************************************

    RELATIONS

     **********************************************************************************************/

    /**
     * Get the image associated with this record.
     */
    public function book()
    {
        return $this->belongsTo('App\Models\Volume\Book', 'book_id');
    }

    /**********************************************************************************************

    OTHER FUNCTIONS

     **********************************************************************************************/

    /**
     * Displays a link using the creator's URL.
     *
     * @return string
     */
    public function displayLink()
    {
        switch ($this->author_type) {
            case 'OnsiteUser':
                $user = User::find($this->author);
                if (!$user) {
                    return 'Deleted User';
                }

                return $user->displayName;
                break;
            case 'OffsiteUser':
                return '<a href="https://www.' . $this->author . '">' . $this->author . '</a>';
                break;
            case 'OffsiteCharacter':
                return '<a href="https://www.' . $this->author . '">' . $this->author . '</a>';
                break;
            case 'OnsiteCharacter':
                $character = Character::find($this->author);
                if (!$character) {
                    return 'Deleted Character';
                }

                return $character->displayName;
        }
    }
}
