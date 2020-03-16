<?php

use App\Settings;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
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
                'name' => 'study_flashcards_type_view',
                'description' => ''
            ],
        ];

        Settings::on()->truncate();

        foreach ($data as $row) {
            Settings::on()->create($row);
        }
    }
}
