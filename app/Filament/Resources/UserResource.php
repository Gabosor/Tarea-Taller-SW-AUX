<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $modelLabel = 'Usuario';
     protected static ?string $navigationGroup = 'Administrador';
    public static function form(Form $form): Form
    {
        return $form
             ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nombre')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->required()
                    ->email(),
                Forms\Components\TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn ($livewire) => $livewire instanceof Pages\CreateUser) // Solo requerido en creación
                    ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : null)
                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateUser || $livewire instanceof Pages\EditUser),
                Forms\Components\Select::make('rol')
                    ->label('Rol')
                    ->options([
                        1 => 'Empleado',
                        2 => 'Administrador',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
             ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo Electrónico'),
                Tables\Columns\TextColumn::make('rol_text')
                    ->label('Rol'),
            ])
            ->filters([
                // Agrega filtros si es necesario
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('promote')
                    ->label('Promover a Administrador')
                    ->action(function (User $record) {
                        $record->update(['rol' => 2]);
                        Notification::make()
                            ->title('Usuario promovido a Administrador')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-up'),

                Tables\Actions\Action::make('demote')
                    ->label('Degradar a Empleado')
                    ->action(function (User $record) {
                        $record->update(['rol' => 1]);
                        Notification::make()
                            ->title('Usuario degradado a Empleado')
                            ->success()
                            ->send();
                    })
                    ->requiresConfirmation()
                    ->icon('heroicon-o-arrow-down'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
