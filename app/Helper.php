<?php

namespace App;

use Carbon\Carbon;

class Helper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    static public function ConvertTo12HourFormat($time24) {
        return  date('h:i A', strtotime($time24));
    }
}
