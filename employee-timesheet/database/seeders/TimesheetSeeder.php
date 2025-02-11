<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Timesheet;
use Carbon\Carbon;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        
        Timesheet::insert([
            [
                'user_id' => 2, 
                'date' => Carbon::today(),
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
                'notes' => 'Worked on project A',
            ],
            [
                'user_id' => 2, 
                'date' => Carbon::yesterday(),
                'start_time' => '10:00:00',
                'end_time' => '18:00:00',
                'notes' => 'Worked on project B',
            ],
        ]);
    }
}
