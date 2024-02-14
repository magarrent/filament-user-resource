<?php

namespace Magarrent\FilamentUserResource;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Magarrent\FilamentUserResource\Resources\UserResource;

class FilamentUserResource implements Plugin
{

    public function getId(): string
    {
        return 'magarrent-filament-user-resource';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                UserResource::class
            ]);
    }

    public function boot(Panel $panel): void
    {

    }
}
