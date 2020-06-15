<?php

namespace Selene\Modules\OfferModule\Support;

use MyCLabs\Enum\Enum;

class Status extends Enum
{
    protected const DRAFT  = 'draft';
    protected const PUBLIC = 'public';
}
