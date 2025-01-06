<?php

namespace App\Enums;

enum TransactionType: string
{
    case Income = 'income';
    case Outcome = 'outcome';
}
