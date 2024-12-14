<?php

namespace App\Enums;

enum ReservationStatus: int
{
    case PENDING = 0; 
    case RESERVED = 1;  
    case CANCELED = -1;

    public static function handleReservationStatus(int $status): string
    {
        return match (self::from($status)) {
            self::PENDING => 'Reservation is pending.',
            self::RESERVED => 'Reservation has been confirmed.',
            self::CANCELED => 'Reservation has been canceled.',
            default => 'Unknown reservation status.',
        };
    }
}

