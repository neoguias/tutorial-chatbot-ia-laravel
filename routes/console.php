<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('larachat:index')->dailyAt('03:00');
