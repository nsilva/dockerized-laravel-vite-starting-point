<?php

namespace App\Support\Enums;

enum TodoStatusEnum: string
{
    case NOT_STARTED = 'not started';
    case IN_PROGRESS = 'in progress';
    case COMPLETE    = 'complete';
}
