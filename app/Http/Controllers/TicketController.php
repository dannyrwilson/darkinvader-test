<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;

class TicketController extends Controller
{
    public function getTickets($status) {

    	// detect status (open/closed) required
    	$status = ($status == 'open') ? null : 1;

    	// Usually digging deeper, i would usually create a "TicketRepository" class which would usually intercept the data between the model and controller.
    	$tickets = Ticket::with('user')
    	->where('status', $status)
    	->paginate();

    	// return JSON response
    	return response()->json($tickets);

    }

    public function getUserTickets($email) {
        
        // Get user by email
        $userTickets = User::with('tickets')
        ->where('email', $email)
        ->first();
            
        // Paginate ticket relation
        $paginatedTickets = $userTickets
        ->tickets()
        ->paginate();

        // return JSON response
        return response()->json($paginatedTickets);
    }

    public function getStats() {

        $mostTickets = Ticket::with('user')
        ->select([
            \DB::RAW("COUNT(id) AS total_tickets"),
            'user_id'
        ])
        ->groupBy('user_id')
        ->orderBy('total_tickets', 'DESC')
        ->first();

        $lastProcessingTime = Ticket::orderBy('updated_at', 'DESC')
            ->first()->updated_at;

        $array = [
            'total_tickets' => Ticket::count(),
            'total_tickets_unprocessed' => Ticket::whereNull('status')->count(),
            'most_tickets' => $mostTickets->user->name,
            'last_processing_time' => $lastProcessingTime
        ];

        return response()->json($array);
    }
}
