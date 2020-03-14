<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
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
                'name' => 'Active',
            ],
            [
                'name' => 'Completed',
            ]
        ];

        Status::on()->truncate();

        foreach ($data as $row) {
            Status::on()->create($row);
        }
    }
}
