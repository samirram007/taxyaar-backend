<?php

namespace App\Modules\TicketEventType\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\TicketEventType\Models\TicketEventType;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TicketEventTypeSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();


        $parents = [
            'LIFECYCLE' => 'Lifecycle events',
            'ASSIGNMENT' => 'Assignment events',
            'COMMUNICATION' => 'Communication events',
            'DOCUMENT' => 'Document events',
            'SYSTEM_SLA' => 'System / SLA events',
            'USER_INTERACTION' => 'User interaction',
        ];

        $parentIds = [];

        foreach ($parents as $code => $desc) {
            $id = DB::table('ticket_event_types')->insertGetId([
                'name' => $code,
                'parent_id' => null,
                'description' => $desc,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $parentIds[$code] = $id;
        }

        $events = [
            ['TICKET_CREATED', 'LIFECYCLE'],
            ['STATUS_CHANGED', 'LIFECYCLE'],
            ['TICKET_CLOSED', 'LIFECYCLE'],
            ['TICKET_REOPENED', 'LIFECYCLE'],

            ['TICKET_ASSIGNED', 'ASSIGNMENT'],
            ['TICKET_TRANSFERRED', 'ASSIGNMENT'],
            ['AUTO_ASSIGNED', 'ASSIGNMENT'],

            ['MESSAGE_SENT', 'COMMUNICATION'],
            ['MESSAGE_RECEIVED', 'COMMUNICATION'],
            ['EMAIL_SENT', 'COMMUNICATION'],
            ['SMS_SENT', 'COMMUNICATION'],

            ['DOCUMENT_UPLOADED', 'DOCUMENT'],
            ['DOCUMENT_RECEIVED', 'DOCUMENT'],
            ['DOCUMENT_VERIFIED', 'DOCUMENT'],
            ['DOCUMENT_REJECTED', 'DOCUMENT'],

            ['SLA_BREACHED', 'SYSTEM_SLA'],
            ['SLA_WARNING_TRIGGERED', 'SYSTEM_SLA'],
            ['ESCALATED', 'SYSTEM_SLA'],
            ['AUTO_REASSIGNED', 'SYSTEM_SLA'],

            ['COMMENT_ADDED', 'USER_INTERACTION'],
            ['NOTE_ADDED', 'USER_INTERACTION'],
        ];

        foreach ($events as [$name, $parentKey]) {
            DB::table('ticket_event_types')->insert([
                'name' => $name,
                'parent_id' => $parentIds[$parentKey],
                'description' => null,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}