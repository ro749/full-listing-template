<?php

namespace Ro749\FullListingTemplate\Enums\Attributes;

enum QuotationAttr: string
{
    case CLIENT = 'client';
    case ASESOR = 'asesor';
    case UNIT = 'unit_pgd';
    case MEDIUM = 'medium';
    case STATUS = 'status';
    case QUOTED_PRICE = 'quoted_price';
    case ACTUAL_PRICE = 'actual_price';
    case N_OPEN = 'n_open';
    case LAST_VIEWED_AT = 'last_viewed_at';
}