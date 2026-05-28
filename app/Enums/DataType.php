<?php

namespace App\Enums;

enum DataType: string
{
    case DONOR_RESULT = 'donor_result';
    case APPOINTMENT_CLIC = 'appointment_clic';
    case DONOR_SHARE = 'donor_share';
    case SUPPORTER_RESULT = 'supporter_result';
    case SUPPORTER_SHARE = 'supporter_share';
}
