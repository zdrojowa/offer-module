<?php

namespace Selene\Modules\OfferModule\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Offer extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'offers';

    protected $appends = ['id'];
    protected $hidden  = ['_id'];

    protected $primaryKey = '_id';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
        'is_active',
        'date_from',
        'date_to',
        'costs',
        'min_nights',
        'discount',
        'programs',
        'packs',
        'files',
        'conveniences',
        'objects',
        'order'
    ];
}
