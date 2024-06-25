<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MovieResource\Pages;
use App\Filament\Resources\MovieResource\RelationManagers;
use App\Models\Movie;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\ImageColumn;

class MovieResource extends Resource
{
    protected static ?string $model = Movie::class;
    protected static ?string $navigationLabel = "Gestionar Peliculas";
    protected static ?string $modelLabel = 'Película';
protected static ?string $navigationGroup = 'Administrador';
    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('titulo')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('director')
                    ->maxLength(255),
                Forms\Components\TextInput::make('duracion')
                    ->required()
                    ->numeric(),
                Forms\Components\FileUpload::make('portada')
                    ->disk('public')
                    ->directory('images')
                    ->visibility('public')
                    ->image()
                    ->placeholder('Sube la portada de la película aquí')
                    ->required()

                ,
                Forms\Components\Textarea::make('sinopsis')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('fecha_estreno')
                    ->required(),
                Forms\Components\TextInput::make('genero')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('clasificacion')
                    ->required()
                    ->maxLength(255),
              
    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('director')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duracion')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_estreno')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('genero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('clasificacion')
                    ->searchable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\ImageColumn::make('portada')
                    ->disk('public')
            ])
            ->filters([
                //
            ])
             ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                
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
            'index' => Pages\ListMovies::route('/'),
            'create' => Pages\CreateMovie::route('/create'),
            'edit' => Pages\EditMovie::route('/{record}/edit'),
        ];
    }
}
