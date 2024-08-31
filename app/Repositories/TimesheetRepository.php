<?php

namespace App\Repositories;

use App\Models\Timesheet;

class TimesheetRepository extends Repository
{
    public function __construct()
    {
        parent::__construct(Timesheet::class);
    }
}
