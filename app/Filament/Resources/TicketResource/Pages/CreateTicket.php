<?php
namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $screening = \App\Models\Screening::find($data['screening_id']);
        $room = $screening->room;

        if (!$screening) {
            Notification::make()
                ->title('La función seleccionada no existe.')
                ->danger()
                ->send();
            return $data;
        }

        $existingTicket = \App\Models\Ticket::where('screening_id', $data['screening_id'])
                                ->where('seat_number', $data['seat_number'])
                                ->first();

        if ($existingTicket) {
            Notification::make()
                ->title('El asiento ya está ocupado.')
                ->danger()
                ->send();
            return $data;
        }

        $totalTickets = \App\Models\Ticket::where('screening_id', $data['screening_id'])->count();

        if ($totalTickets >= $room->capacity) {
            Notification::make()
                ->title('La sala ha alcanzado su capacidad máxima.')
                ->danger()
                ->send();
            return $data;
        }

        $current_time = Carbon::now();
        $start_time = Carbon::parse($screening->start_time);
        $time_diff = $start_time->diffInMinutes($current_time);

        if ($time_diff < 3) {
            Notification::make()
                ->title('No puedes vender un boleto con menos de 3 minutos antes de que inicie la función.')
                ->danger()
                ->send();
            return $data;
        }

        $data['user_id'] = auth()->id();

        return $data;
    }
}
