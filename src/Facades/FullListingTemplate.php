<?php

namespace Ro749\FullListingTemplate\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ro749\FullListingTemplate\FullListingTemplate
 */
class FullListingTemplate extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Ro749\FullListingTemplate\FullListingTemplate::class;
    }
}
