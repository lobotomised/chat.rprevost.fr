<?php

use App\Console\Commands\PurgeExpiredSoftDeletedCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command(PurgeExpiredSoftDeletedCommand::class)->daily()->at('05:30');
