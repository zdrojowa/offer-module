<?php

namespace Selene\Modules\OfferModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Convenience extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'conveniences';

    protected $appends = ['id'];
    protected $hidden  = ['_id'];

    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'url',
        'order'
    ];
}
