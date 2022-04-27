<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ticket;

class generateTicket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:ticket';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Console command to generate ticket.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Ticket::factory()->create();
    }
}
