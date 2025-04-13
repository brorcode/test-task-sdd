<?php

namespace App\Enums;

enum ActionType: int
{
    case ACTION_TYPE_DATA_IMPORT = 1;
    case ACTION_TYPE_DATA_CLEANUP = 2;
    case ACTION_TYPE_DATA_BACKUP = 3;
}
