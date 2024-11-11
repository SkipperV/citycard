<?php

namespace App\Enums;

enum TicketType: string
{
    case Regular = 'Стандартний';
    case Children = 'Дитячий';
    case Student = 'Студентський';
    case Preferential = 'Пільговий';
    case Special = 'Спеціальний';
}
