<?php

namespace App\Enums;


enum TicketStatus: string
{
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case PENDING = 'pending';
    case RESOLVED = 'resolved';
    case CLOSED = 'closed';
    case REOPENED = 'reopened';
    case ON_HOLD = 'on_hold';
    case CANCELLED = 'cancelled';

    public static function getValues(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
