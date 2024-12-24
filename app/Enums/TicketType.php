<?php

namespace App\Enums;

enum TicketType: string
{
    case Regular = 'regular';
    case Child = 'child';
    case Student = 'student';
    case Preferential = 'preferential';
    case Special = 'special';
}
