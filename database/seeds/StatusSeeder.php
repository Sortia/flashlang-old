<?php

use App\Models\Status;
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
                'name'   => 1,
                'value'  => 0,
                'weight' => 6,
            ],
            [
                'name'   => 2,
                'value'  => 1,
                'weight' => 5,
            ],
            [
                'name'   => 3,
                'value'  => 2,
                'weight' => 4,
            ],
            [
                'name'   => 4,
                'value'  => 3,
                'weight' => 3,
            ],
            [
                'name'   => 5,
                'value'  => 4,
                'weight' => 2,
            ],
            [
                'name'   => 6,
                'value'  => 5,
                'weight' => 1,
            ],
        ];

        Status::truncate();

        foreach ($data as $row) {
            Status::create($row);
        }
    }
}
