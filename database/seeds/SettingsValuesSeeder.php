<?php

use App\SettingsValues;
use Illuminate\Database\Seeder;

class SettingsValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'value' => 'flip',
                'description' => '',
                'settings_id' => 1,
            ],
            [
                'value' => 'slide',
                'description' => '',
                'settings_id' => 1,
            ],

        ];

        SettingsValues::on()->truncate();

        foreach ($data as $row) {
            SettingsValues::on()->create($row);
        }
    }
}
