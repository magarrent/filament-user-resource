<?php

namespace Magarrent\FilamentUserResource\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Magarrent\FilamentUserResource\Resources\UserResource;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
