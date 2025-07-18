<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketStepRequest;
use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;

class TicketStepController extends Controller
{
    public function create(TicketStepRequest $request, string $ticketId): RedirectResponse
    {
        $credentials = $request->validated();

        Ticket\TicketStep::create([
            'ticket_id' => $ticketId,
            'technician_id' => $credentials['step_technician'],
            'description' => $credentials['step_description'] ?? null,
            'date' => $credentials['step_date'],
        ]);

        return back()->with('success_step', "L'étape du ticket a été créé avec succès.");
    }

    public function delete(string $ticketId, string $id): RedirectResponse
    {
        Ticket\TicketStep::destroy($id);

        return back()->with('success_step', "L'étape du ticket a été supprimé avec succès.");
    }
}
