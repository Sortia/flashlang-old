<?php

use App\SideType;
use Illuminate\Database\Seeder;

class SideTypeSeeder extends Seeder
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
                'name' => 'Front',
            ],
            [
                'name' => 'Back',
            ]
        ];

        SideType::on()->truncate();

        foreach ($data as $row) {
            SideType::on()->create($row);
        }
    }
}
