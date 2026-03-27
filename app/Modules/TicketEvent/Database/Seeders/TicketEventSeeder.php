<?php

namespace App\Modules\TicketEvent\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketEvent\Models\TicketEvent;

class TicketEventSeeder extends Seeder
{
    public function run(): void
    {
        TicketEvent::create(['name' => 'Sample TicketEvent']);

        // Uncomment to use factory if available
        // TicketEvent::factory()->count(10)->create();
    }
}
