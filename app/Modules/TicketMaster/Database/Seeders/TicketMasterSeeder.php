<?php

namespace App\Modules\TicketMaster\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketMaster\Models\TicketMaster;

class TicketMasterSeeder extends Seeder
{
    public function run(): void
    {
        TicketMaster::create(['name' => 'Sample TicketMaster']);

        // Uncomment to use factory if available
        // TicketMaster::factory()->count(10)->create();
    }
}
