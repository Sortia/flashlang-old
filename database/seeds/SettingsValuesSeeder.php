<?php

use App\Models\SettingsValues;
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
                'value'       => 'flip',
                'description' => 'Flip',
                'settings_id' => 1,
            ],
            [
                'value'       => 'slide',
                'description' => 'Slide',
                'settings_id' => 1,
            ],
            [
                'value'       => 'front_text',
                'description' => 'Front',
                'settings_id' => 2,
            ],
            [
                'value'       => 'back_text',
                'description' => 'Back',
                'settings_id' => 2,
            ],
            [
                'value'       => 'en',
                'description' => 'English',
                'settings_id' => 3,
            ],
            [
                'value'       => 'ru',
                'description' => 'Russian',
                'settings_id' => 3,
            ],

        ];

        SettingsValues::truncate();

        foreach ($data as $row) {
            SettingsValues::create($row);
        }
    }
}
