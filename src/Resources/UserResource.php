<?php

namespace Magarrent\FilamentUserResource\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hash;
use Illuminate\Support\Facades\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'users';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    ->required(),

                TextInput::make('email')
                    ->translateLabel()
                    ->required(),

                DatePicker::make('email_verified_at')
                    ->translateLabel(),

                TextInput::make('password')
                    ->translateLabel()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?User $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?User $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email_verified_at')
                    ->translateLabel()
                    ->toggleable()
                    ->date(),
                TextColumn::make('created_at')
                    ->translateLabel()
                    ->toggleable()
                    ->sortable()
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                ActionGroup::make([
                    Action::make('remember_password')
                        ->icon('heroicon-o-inbox-arrow-down')
                        ->label(__('Send Remember Password Email'))
                        ->translateLabel()
                        ->action(function(User $user) {
                            $status = Password::sendResetLink(
                                ['email' => $user->getEmailForPasswordReset()]
                            );

                            if($status === Password::RESET_LINK_SENT) {
                                Notification::make()
                                    ->title(__('Password Reset Email Sent'))
                                    ->body(__('A password reset email has been sent to the user.'))
                                    ->success()
                                    ->send();
                            }
                        }),
                ])
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Magarrent\FilamentUserResource\Resources\UserResource\Pages\ListUsers::route('/'),
            'create' => \Magarrent\FilamentUserResource\Resources\UserResource\Pages\CreateUser::route('/create'),
            'edit' => \Magarrent\FilamentUserResource\Resources\UserResource\Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }
}
