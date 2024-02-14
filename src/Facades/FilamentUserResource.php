<?php

namespace Magarrent\FilamentUserResource\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Magarrent\FilamentUserResource\FilamentUserResource
 */
class FilamentUserResource extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Magarrent\FilamentUserResource\FilamentUserResource::class;
    }
}
