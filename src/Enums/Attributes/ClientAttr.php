<?php

namespace Ro749\FullListingTemplate\Enums\Attributes;

enum ClientAttr: string
{
    
    case NAME = 'name';
    case MAIL = 'mail';
    case PHONE = 'phone';
    case CATEGORY = 'category';
    case PRIORITY = 'priority';
    case SHORT_COMMENT = 'short_comment';
    case LONG_COMMENT = 'long_comment';
    case ASESOR = 'asesor';
}