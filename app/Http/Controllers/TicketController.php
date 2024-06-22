<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use PDF;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function download($id)
    {
        $ticket = Ticket::with(['screening.movie', 'client', 'screening.room'])->findOrFail($id);

        $pdf = PDF::loadView('tickets.pdf', compact('ticket'));

        return $pdf->download('ticket_' . $ticket->id . '.pdf');
    }
}
