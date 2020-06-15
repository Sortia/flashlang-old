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
                'id'   => 0,
                'weight' => 6,
            ],
            [
                'id'   => 1,
                'weight' => 5,
            ],
            [
                'id'   => 2,
                'weight' => 4,
            ],
            [
                'id'   => 3,
                'weight' => 3,
            ],
            [
                'id'   => 4,
                'weight' => 2,
            ],
            [
                'id'   => 5,
                'weight' => 1,
            ],
        ];

        Status::truncate();

        foreach ($data as $row) {
            Status::create($row);
        }
    }
}
