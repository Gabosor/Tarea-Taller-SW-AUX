<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Screening;
use Filament\Tables\Table;
use Carbon\Carbon;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ScreeningResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ScreeningResource\RelationManagers;
use Illuminate\Validation\ValidationException;
class ScreeningResource extends Resource
{
    protected static ?string $model = Screening::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';
    protected static ?string $navigationLabel = "Asignar pelicula a sala";
    protected static ?string $modelLabel = 'Asignar Película a Sala';
protected static ?string $navigationGroup = 'Administrador';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('movie_id')
                    ->relationship('movie', 'titulo')
                    ->label('Pelicula')
                    ->required(),

                Forms\Components\Select::make('room_id')
                    ->relationship('room', 'name')
                    ->label('Sala')
                    ->required(),

                Forms\Components\DateTimePicker::make('start_time')
                    ->label('Hora Inicio')
                    ->seconds(false)
                    ->default(now())
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->label('Precio')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('duration')
                    ->label('Duración (minutos)')
                    ->numeric()
                    ->required(),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
               Tables\Columns\TextColumn::make('movie.titulo')
                    ->searchable()
                    ->label('Pelicula'),
                Tables\Columns\TextColumn::make('room.name')
                    ->searchable()
                    ->label('Sala'),
                Tables\Columns\TextColumn::make('price')
                    ->searchable()
                    ->label('Precio'),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Inicio')
                    ->searchable()
                    ,
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Fin'),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duracion'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListScreenings::route('/'),
            'create' => Pages\CreateScreening::route('/create'),
            'edit' => Pages\EditScreening::route('/{record}/edit'),
        ];
    }
}
