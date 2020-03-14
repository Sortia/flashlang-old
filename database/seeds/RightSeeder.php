<?php

use App\Right;
use Illuminate\Database\Seeder;

class RightSeeder extends Seeder
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
                'name' => 'Maintainer',
                'description' => 'Can do all'
            ],
            [
                'name' => 'Guest',
                'description' => 'Read only'
            ]
        ];

        Right::on()->truncate();

        foreach ($data as $row) {
            Right::on()->create($row);
        }
    }
}
