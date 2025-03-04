<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


// Backup cada domingo a las 2:00 AM
Schedule::command('backup:run')->weekly()->sundays()->at('02:00');

// Limpieza cada lunes a las 2:30 AM (elimina backups antiguos)
Schedule::command('backup:clean')->weekly()->mondays()->at('02:30');
