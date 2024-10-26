<?php

namespace App\Enums;

enum ReservationStatus: int
{
    case PENDING = 0; 
    case RESERVED = 1;  
    case CANCELED = -1;

}
