<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = Setting::create([
            'title' => 'Task Management System',
            'email' =>'task@task.com',
            'sub_title' =>'Task Management System',
            'contact_number' =>'+9723664755',
        ]);
    }
}
