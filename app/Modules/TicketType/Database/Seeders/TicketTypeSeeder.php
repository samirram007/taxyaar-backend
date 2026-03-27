<?php

namespace App\Modules\TicketType\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketType\Models\TicketType;

class TicketTypeSeeder extends Seeder
{
    public function run()
    {
        $ticketTypes = [
            [
                'name' => 'Feedback / Suggestion',
                'code' => '001',
                'description' => 'Feedback and suggestion',
            ],
            [
                'name' => 'Capital Gain Importing Issue',
                'code' => '002',
                'description' => 'Issues related to capital gain import',
            ],
            [
                'name' => 'Payment Related',
                'code' => '003',
                'description' => 'Payment related queries or issues',
            ],
            [
                'name' => 'Status of your Filed Return',
                'code' => '004',
                'description' => 'Check status of filed return',
            ],
            [
                'name' => 'Error in Filing',
                'code' => '005',
                'description' => 'Errors encountered during filing',
            ],
            [
                'name' => 'Verify PAN / OTP Issue',
                'code' => '006',
                'description' => 'PAN or OTP verification issues',
            ],
            [
                'name' => 'Query related to Tax calculation',
                'code' => '007',
                'description' => 'Tax calculation related queries',
            ],
            [
                'name' => 'Revised Filing',
                'code' => '008',
                'description' => 'Queries about revised filing',
            ],
            [
                'name' => 'How to queries',
                'code' => '009',
                'description' => 'General how-to queries',
            ],
            [
                'name' => 'Income Tax Notice Related',
                'code' => '010',
                'description' => 'Issues related to income tax notices',
            ],
            [
                'name' => 'Other complaint / issues',
                'code' => '011',
                'description' => 'Miscellaneous complaints or issues',
            ],
        ];

        foreach ($ticketTypes as $ticketType) {
            TicketType::updateOrCreate(
                ['code' => $ticketType['code']],
                $ticketType
            );
        }
    }
}
