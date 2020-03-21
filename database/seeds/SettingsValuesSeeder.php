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
                'description' => 'Flip',
                'settings_id' => 1,
            ],
            [
                'value' => 'slide',
                'description' => 'Slide',
                'settings_id' => 1,
            ],

        [
                'value' => 'front_text',
                'description' => 'Front',
                'settings_id' => 2,
            ],

        [
                'value' => 'back_text',
                'description' => 'Back',
                'settings_id' => 2,
            ],

        ];

        SettingsValues::on()->truncate();

        foreach ($data as $row) {
            SettingsValues::on()->create($row);
        }
    }
}
