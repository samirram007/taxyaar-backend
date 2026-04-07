<?php

namespace App\Modules\UserFiscalYear\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\UserFiscalYear\Models\UserFiscalYear;

class UserFiscalYearSeeder extends Seeder
{
    public function run(): void
    {


        UserFiscalYear::create([
            'user_id' => 1,
            'fiscal_year_id' => 2,
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'current_date' => now(),
        ]);

        // Uncomment to use factory if available
        // UserFiscalYear::factory()->count(10)->create();
    }
}
