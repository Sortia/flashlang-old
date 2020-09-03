<?php

namespace Tests;

trait ArrayComparer
{
    protected function assertEqualsArrays(array $expected, array $actual)
    {
        $this->assertEquals(json_encode($expected), json_encode($actual));
    }

    protected function assertNotEqualsArrays(array $expected, array $actual)
    {
        $this->assertNotEquals(json_encode($expected), json_encode($actual));
    }
}
