<?php

namespace App\Enums;

enum PaymentStatus: int
{
    case PENDING = -1;
    case INTERNAL_ERROR = -2;
    case SUCCESS_CONFIRMED = 1;
    case SUCCESS_UNCONFIRMED = 2;
    case CANCELED_BY_USER = 3;
    case INVALID_CARD = 4;
    case INSUFFICIENT_BALANCE = 5;
    case WRONG_PASSWORD = 6;
    case REQUEST_LIMIT_EXCEEDED = 7;
    case DAILY_TRANSACTION_LIMIT_EXCEEDED = 8;
    case DAILY_AMOUNT_LIMIT_EXCEEDED = 9;
    case INVALID_CARD_ISSUER = 10;
    case SWITCH_ERROR = 11;
    case CARD_NOT_ACCESSIBLE = 12;

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pending',
            self::INTERNAL_ERROR => 'Internal Error',
            self::SUCCESS_CONFIRMED => 'Confirmed',
            self::SUCCESS_UNCONFIRMED => 'Unconfirmed',
            self::CANCELED_BY_USER => 'Canceled by User',
            self::INVALID_CARD => 'Invalid Card',
            self::INSUFFICIENT_BALANCE => 'Insufficient Balance',
            self::WRONG_PASSWORD => 'Incorrect Password',
            self::REQUEST_LIMIT_EXCEEDED => 'Request Limit Exceeded',
            self::DAILY_TRANSACTION_LIMIT_EXCEEDED => 'Daily Transaction Limit Exceeded',
            self::DAILY_AMOUNT_LIMIT_EXCEEDED => 'Daily Amount Limit Exceeded',
            self::INVALID_CARD_ISSUER => 'Invalid Card Issuer',
            self::SWITCH_ERROR => 'Switch Error',
            self::CARD_NOT_ACCESSIBLE => 'Card Not Accessible',
        };
    }
}
