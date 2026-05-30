<?php

namespace App\Enums;

enum SeasonStatus: string
{
    case OPEN = 'open';
    case CLOSED = 'closed';
    case FUTURE = 'future';
}
