<?php

namespace Tests\Unit\Services;

use App\Http\Services\RandomPicker;
use Exception;
use Tests\ArrayComparer;
use Tests\TestCase;

class RandomPickerTest extends TestCase
{
    use ArrayComparer;

    /**
     * @test
     * @return void
     */
    public function addElementTest()
    {
        $randomPicker = new RandomPicker();

        $randomPicker->addElement('value', 5);

        $this->assertCount(1, $randomPicker->getElements());
        $this->assertEquals('value', $randomPicker->getElements()[0]);

        $this->assertCount(1, $randomPicker->getWeights());
        $this->assertEquals(5, $randomPicker->getWeights()[0]);
    }

    /**
     * @test
     * @return void
     */
    public function addElementsTest()
    {
        $data = collect([
            'val1' => 1,
            'val2' => 2,
            'val3' => 3,
            'val4' => 4,
            'val5' => 5,
            'val6' => 5,
        ]);

        $randomPicker = new RandomPicker();

        $randomPicker->addElements($data);

        $this->assertEqualsArrays($data->keys()->toArray(), $randomPicker->getElements());
        $this->assertEqualsArrays($data->values()->toArray(), $randomPicker->getWeights());

        $this->assertCount($data->count(), $randomPicker->getElements());
        $this->assertCount($data->count(), $randomPicker->getWeights());
    }

    /**
     * @test
     * @return void
     * @throws Exception
     */
    public function randomElementFrequencyTest()
    {
        $data = collect([
            'val1' => 1,
            'val2' => 1,
            'val3' => 1,
            'val4' => 1,
            'val5' => 5,
        ]);

        $randomPicker = new RandomPicker();

        $randomPicker->addElements($data);

        $results = [];

        for ($i = 0; $i < 1000; $i++) {
            $results[] = $randomPicker->getRandomElement();
        }

        $frequency = array_count_values($results);

        $this->assertTrue($frequency['val5'] > 400 && $frequency['val5'] < 700);
    }
}
