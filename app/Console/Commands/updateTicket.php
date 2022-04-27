<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;

class updateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Processes a ticket every 5 minutes.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $latestTicket = Ticket::orderBy('id', 'ASC')
        ->whereNull('status')
        ->first();
        
        $latestTicket->status = 1;
        $latestTicket->save();
    }
}
