<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Сущность Мероприятия
 * Class Event
 * @package App
 * @property int $id
 * @property string $title
 * @property \DateTime $date
 * @property int $city_id
 * @property-read City $city
 */
class Event extends Model
{
    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsToMany
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(Member::class,'event_member');
    }
}
