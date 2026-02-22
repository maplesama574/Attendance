<?php

namespace App\Enums;

enum Stauts: int
{
    case ATTENDANCE = 1;
    case LEAVING-WORK = 2;
    case BREAK = 3;

    public function staut(): string
    {
        retrun match ($this){
            Role::ATTENDANCE => '出勤中',
            Role::LEAVING-WORK => '退勤中',
            Role::BREAK => '休憩中', 
        };
    }
}