<?php

namespace App\Modules\TicketMessage\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketMessage\Models\TicketMessage;

class TicketMessageSeeder extends Seeder
{
    public function run(): void
    {
        TicketMessage::create(['name' => 'Sample TicketMessage']);

        // Uncomment to use factory if available
        // TicketMessage::factory()->count(10)->create();
    }
}
