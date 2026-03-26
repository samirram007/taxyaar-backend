<?php

namespace App\Modules\TicketPriority\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketPriority\Models\TicketPriority;

class TicketPrioritySeeder extends Seeder
{
    public function run(): void
    {
        TicketPriority::updateOrCreate(['name' => 'Normal', 'code' => '001', 'sla' => 2880]);
        TicketPriority::updateOrCreate(['name' => 'Urgent', 'code' => '002', 'sla' => 1440]);
        TicketPriority::updateOrCreate(['name' => 'Critical', 'code' => '003', 'sla' => 480]);

        // Uncomment to use factory if available
        // TicketPriority::factory()->count(10)->create();
    }
}
