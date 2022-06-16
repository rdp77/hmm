<?php

namespace App\Enums;

enum HardwareStatusEnum: string
{
    case NEWHARDWARE = 'baru';
    case NORMALHARDWARE = 'normal';
    case DAMAGEDHARDWARE = 'rusak';
}