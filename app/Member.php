<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Member
 * @package App
 * @property int $id
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property-read Event $events
 */
class Member extends Model
{
    protected $fillable = [
        'firstname',
        'lastname',
        'email'
    ];

    /**
     * @return BelongsToMany
     */
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_member');
    }
}
