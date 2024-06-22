<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Ticket;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\TicketResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TicketResource\RelationManagers;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;
    protected static ?string $navigationLabel = "Boletos";
    protected static ?string $modelLabel = 'Boleto';

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

     public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->required(),

                Forms\Components\Select::make('screening_id')
                    ->label('Función')
                    ->options(function () {
                        return \App\Models\Screening::with('movie')
                            ->get()
                            ->mapWithKeys(function ($screening) {
                                $start_time = Carbon::parse($screening->start_time)->format('d-m-Y H:i');
                                $price = $screening->price ?? 'N/A';
                                $title = "{$screening->movie->titulo} - $start_time - $price";
                                return [$screening->id => $title];
                            });
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('seat_number')
                    ->label('Número de Asiento')
                    ->numeric()
                    ->required(),
                Forms\Components\Hidden::make('user_id')->default(auth()->user()->id)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable(),
                Tables\Columns\TextColumn::make('screening.movie.titulo')
                    ->label('Película')
                    ->searchable(),
                Tables\Columns\TextColumn::make('screening.start_time')
                    ->label('Hora de Inicio')
                    ->dateTime('d-m-Y H:i'),
                Tables\Columns\TextColumn::make('screening.price')
                    ->label('Precio')
                    ->money('usd'),
                Tables\Columns\TextColumn::make('seat_number')
                    ->label('Número de Asiento'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Vendido por')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Compra')
                    ->dateTime('d-m-Y H:i'),
            ])
            ->filters([
                // ...
            ])
             ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Imprimir Ticket')
                    ->url(fn (Ticket $record): string => route('tickets.download', $record))
                    ->icon('heroicon-o-ticket')
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
