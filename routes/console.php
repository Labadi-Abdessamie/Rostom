<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Scheduled: refresh live site stats every 24 hours
Schedule::command('stats:refresh')->daily();
