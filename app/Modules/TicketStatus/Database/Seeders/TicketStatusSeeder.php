<?php

namespace App\Modules\TicketStatus\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketStatus\Models\TicketStatus;

class TicketStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'OPEN',
                'code' => 'open',
                'description' => 'Created, not yet picked',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 1,
                'color_code' => '#6c757d',
            ],
            [
                'name' => 'ASSIGNED',
                'code' => 'assigned',
                'description' => 'Owner decided, work not started',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 2,
                'color_code' => '#0d6efd',
            ],
            [
                'name' => 'IN_PROGRESS',
                'code' => 'in_progress',
                'description' => 'Actively being worked',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 3,
                'color_code' => '#0dcaf0',
            ],
            [
                'name' => 'WAITING_FOR_CUSTOMER',
                'code' => 'waiting_for_customer',
                'description' => 'Blocked by user input or documents',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 4,
                'color_code' => '#ffc107',
            ],
            [
                'name' => 'WAITING_FOR_INTERNAL',
                'code' => 'waiting_for_internal',
                'description' => 'Blocked by internal team or system',
                'is_active' => true,
                'is_public' => false,
                'display_order' => 5,
                'color_code' => '#fd7e14',
            ],
            [
                'name' => 'ON_HOLD',
                'code' => 'on_hold',
                'description' => 'Paused, no immediate action expected',
                'is_active' => true,
                'is_public' => false,
                'display_order' => 6,
                'color_code' => '#adb5bd',
            ],
            [
                'name' => 'ESCALATED',
                'code' => 'escalated',
                'description' => 'Raised to higher level',
                'is_active' => true,
                'is_public' => false,
                'display_order' => 7,
                'color_code' => '#dc3545',
            ],
            [
                'name' => 'RESOLVED',
                'code' => 'resolved',
                'description' => 'Solution provided',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 8,
                'color_code' => '#198754',
            ],
            [
                'name' => 'CLOSED',
                'code' => 'closed',
                'description' => 'Finished, no further action',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 9,
                'color_code' => '#212529',
            ],
            [
                'name' => 'REOPENED',
                'code' => 'reopened',
                'description' => 'Customer not satisfied / issue persists',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 10,
                'color_code' => '#6610f2',
            ],
            [
                'name' => 'CANCELLED',
                'code' => 'cancelled',
                'description' => 'Invalid or withdrawn',
                'is_active' => true,
                'is_public' => true,
                'display_order' => 11,
                'color_code' => '#6c757d',
            ],
        ];

        foreach ($statuses as $status) {
            TicketStatus::updateOrCreate(
                ['code' => $status['code']],
                $status
            );
        }
    }
}
